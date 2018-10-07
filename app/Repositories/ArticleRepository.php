<?php

namespace Corp\Repositories;

use Corp\Article;
use Corp\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;

class ArticleRepository extends Repository
{
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function get($select = '*', $take = false, $pagination = false, $where = false)
    {
        $articles = parent::get($select, $take, $pagination, $where);
        if ($articles) {
            $articles->load('category', 'user', 'comments');
        }
        return $articles;
    }

    public function one($alias, $select = '*', $needLoad = true)
    {
        $article = parent::one($alias, $select);
        if ($article && $needLoad) {
            $article->load('category', 'user', 'comments');
            $article->comments->load('user');
        }
        return $article;
    }

    public function addArticle(ArticleRequest $request)
    {
        if (Gate::denies('create', $this->model)) {
//            abort(403);
            $key = 'custom.CREATE_' . strtoupper(class_basename($this->model)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $data = $request->except('_token', 'image');

        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        } else {
            $data['alias'] = $this->transliterate($data['alias']);
        }
        $data['alias'] = chop(substr($data['alias'], 0, config('settings.articles_alias_length')), '-');

        if (empty($data['desc'])) {
            $data['desc'] = '<p>' . str_limit(strip_tags($data['text']), config('settings.articles_desc_length')) . '</p>';
        }

        if ($this->one($data['alias'], ['alias'], false)) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();
            return ['error' => 'Данный псевдоним уже используется'];
        }

        $image = $this->getImage($request);
        if ($image) {
            $data['img'] = $image;
        }

        $this->model->fill($data);

        if ($request->user()->articles()->save($this->model)) {
            return ['status' => 'Материал добавлен'];
        } else {
            return ['error' => 'Не удалось сохранить материал'];
        }
    }

    public function updateArticle(ArticleRequest $request, Article $article)
    {
        if (Gate::denies('update', $this->model)) {
//            abort(403);
            $key = 'custom.UPDATE_' . strtoupper(class_basename($this->model)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        if (Auth::user()->id !== $article->user_id && Auth::user()->roles()->first()->name === 'Guest') {
            return ['error' => 'Вы не можете редактировать чужие статьи'];
        }

        $data = $request->except('_token', 'image', '_method');

        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        } else {
            $data['alias'] = $this->transliterate($data['alias']);
        }
        $data['alias'] = chop(substr($data['alias'], 0, config('settings.articles_alias_length')), '-');

        if (empty($data['desc'])) {
            $data['desc'] = '<p>' . str_limit(strip_tags($data['text']), config('settings.articles_desc_length')) . '</p>';
        }

        $foundArticle = $this->one($data['alias'], ['id'], false);
        if (!empty($foundArticle) && $foundArticle->id !== $article->id) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();
            return ['error' => 'Данный псевдоним уже используется'];
        }

        $image = $this->getImage($request);
        if ($image) {
            $data['img'] = $image;
        }

        $article->fill($data);

        if ($article->update()) {
            return ['status' => 'Материал обновлен'];
        } else {
            return ['error' => 'Не удалось обновить материал'];
        }
    }

    public function deleteArticle(Article $article)
    {
        if (Gate::denies('delete', $article)) {
//            abort(403);
            $key = 'custom.DELETE_' . strtoupper(class_basename($article)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        if (Auth::user()->id !== $article->user_id && Auth::user()->roles()->first()->name === 'Guest') {
            return ['error' => 'Вы не можете удалять чужие статьи'];
        }

        $article->comments()->delete();

        if ($article->delete()) {
            return ['status' => 'Материал удален'];
        } else {
            return ['error' => 'Не удалось удалить материал'];
        }
    }

    public function getImage(ArticleRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $str = str_random(8);
                $obj = new \stdClass();
                $obj->mini = $str . '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                Image::make($image)->fit(config('settings.image')['width'], config('settings.image')['height'])
                    ->save(public_path() . '/' . config('settings.theme') . '/images/' . config('settings.articles_path') . '/' . $obj->path);
                Image::make($image)->fit(config('settings.articles_img')['max']['width'], config('settings.articles_img')['max']['height'])
                    ->save(public_path() . '/' . config('settings.theme') . '/images/' . config('settings.articles_path') . '/' . $obj->max);
                Image::make($image)->fit(config('settings.articles_img')['mini']['width'], config('settings.articles_img')['mini']['height'])
                    ->save(public_path() . '/' . config('settings.theme') . '/images/' . config('settings.articles_path') . '/' . $obj->mini);

                return json_encode($obj);
            }
        }
        return null;
    }
}