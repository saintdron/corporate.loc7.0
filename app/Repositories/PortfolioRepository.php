<?php

namespace Corp\Repositories;

use Corp\Http\Requests\PortfolioRequest;
use Corp\Portfolio;
use Illuminate\Support\Facades\Gate;
use Image;


class PortfolioRepository extends Repository
{
    public function __construct(Portfolio $model)
    {
        $this->model = $model;
    }

    public function get($select = '*', $take = false, $pagination = false, $where = false)
    {
        $portfolios = parent::get($select, $take, $pagination, $where);
        if ($portfolios) {
            $portfolios->load('filter');
        }
        return $portfolios;
    }

    public function one($alias, $select = '*', $needLoad = true)
    {
        $portfolio = parent::one($alias, $select);
        if ($portfolio && $needLoad) {
            $portfolio->load('filter');
        }
        return $portfolio;
    }

    public function addPortfolio(PortfolioRequest $request)
    {
        if (Gate::denies('create', $this->model)) {
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
        $data['alias'] = chop(substr($data['alias'], 0, config('settings.portfolios_alias_length')), '-');

        if ($this->one($data['alias'], ['alias'], false)) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();
            return ['error' => 'Данный псевдоним уже используется'];
        }

        $image = $this->getImage($request);
        if ($image) {
            $data['img'] = $image;
        }
//
//        try {
//            $this->model->save($data);
//            return ['status' => 'Работа добавлена'];
//        } catch (\Exception $e) {
//            return ['error' => 'Не удалось сохранить работу'];
//        }

        if ($this->model->fill($data)->save()) {
            return ['status' => 'Работа добавлена'];
        } else {
            return ['error' => 'Не удалось сохранить работу'];
        }
    }

    public function updatePortfolio(PortfolioRequest $request, Portfolio $portfolio)
    {
        if (Gate::denies('update', $portfolio)) {
            $key = 'custom.UPDATE_' . strtoupper(class_basename($portfolio)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
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
        $data['alias'] = chop(substr($data['alias'], 0, config('settings.portfolios_alias_length')), '-');

        $foundPortfolio = $this->one($data['alias'], ['id'], false);
        if (!empty($foundPortfolio) && $foundPortfolio->id !== $portfolio->id) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();
            return ['error' => 'Данный псевдоним уже используется'];
        }

        $image = $this->getImage($request);
        if ($image) {
            $data['img'] = $image;
        }

        if ($portfolio->update($data)) {
            return ['status' => 'Работа обновлена'];
        } else {
            return ['error' => 'Не удалось обновить работу'];
        }
    }

    public function deletePortfolio(Portfolio $portfolio)
    {
        if (Gate::denies('delete', $portfolio)) {
            $key = 'custom.DELETE_' . strtoupper(class_basename($portfolio)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        if ($portfolio->delete()) {
            return ['status' => 'Работа удалена'];
        } else {
            return ['error' => 'Не удалось удалить работу'];
        }
    }

    public function getImage(PortfolioRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $str = str_random(8);
                $obj = new \stdClass();
                $obj->mini = $str . '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                Image::make($image)->resize(config('settings.image')['width'], config('settings.image')['height'], function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save(public_path() . '/' . config('settings.theme') . '/images/' . config('settings.portfolios_path') . '/' . $obj->path);
                Image::make($image)->fit(config('settings.portfolios_img')['max']['width'], config('settings.portfolios_img')['max']['height'])
                    ->save(public_path() . '/' . config('settings.theme') . '/images/' . config('settings.portfolios_path') . '/' . $obj->max);
                Image::make($image)->fit(config('settings.portfolios_img')['mini']['width'], config('settings.portfolios_img')['mini']['height'])
                    ->save(public_path() . '/' . config('settings.theme') . '/images/' . config('settings.portfolios_path') . '/' . $obj->mini);

                return json_encode($obj);
            }
        }
        return null;
    }
}