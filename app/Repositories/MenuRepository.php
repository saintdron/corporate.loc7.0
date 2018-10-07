<?php

namespace Corp\Repositories;

use Corp\Menu;
use Illuminate\Support\Facades\Gate;

class MenuRepository extends Repository
{
    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function addMenu($request)
    {
        if (Gate::denies('create', $this->model)) {
//            abort(403);
            $key = 'custom.CREATE_' . strtoupper(class_basename($this->model)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $data = $request->only('type', 'title', 'parent_id');
        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }

        switch ($data['type']) {
            case 'customLink':
                $data['path'] = $request->input('custom_link');
                break;
            case 'blogLink':
                if ($request->input('category_alias')) {
                    if ($request->input('category_alias') === 'parent') {
                        $data['path'] = route('articles.index');
                    } else {
                        $data['path'] = route('articlesCat', ['cat_alias' => $request->input('category_alias')]);
                    }
                } else if ($request->input('article_alias')) {
                    $data['path'] = route('articles.show', ['alias' => $request->input('article_alias')]);
                }
                break;
            case 'portfolioLink':
                if ($request->input('filter_alias')) {
                    if ($request->input('filter_alias') === 'parent') {
                        $data['path'] = route('portfolios.index');
                    } else {
                        // Отображение всех портфолио по указанному фильтру 'filter_alias'
                    }
                } else if ($request->input('portfolio_alias')) {
                    $data['path'] = route('portfolios.show', ['alias' => $request->input('portfolio_alias')]);
                }
                break;
            default:
                return ['error' => 'Не выбран путь для нового пункта меню'];
        }

        unset($data['type']);

        if ($this->model->fill($data)->save()) {
            return ['status' => 'Новый пункт меню добавлен'];
        } else {
            return ['error' => 'Не удалось добавить пункт меню'];
        }
    }

    public function updateMenu($request, $menu)
    {
        if (Gate::denies('update', $menu)) {
//            abort(403);
            $key = 'custom.UPDATE_' . strtoupper(class_basename($menu)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $data = $request->only('type', 'title', 'parent_id');
        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }

        switch ($data['type']) {
            case 'customLink':
                $data['path'] = $request->input('custom_link');
                break;
            case 'blogLink':
                if ($request->input('category_alias')) {
                    if ($request->input('category_alias') === 'parent') {
                        $data['path'] = route('articles.index');
                    } else {
                        $data['path'] = route('articlesCat', ['cat_alias' => $request->input('category_alias')]);
                    }
                } else if ($request->input('article_alias')) {
                    $data['path'] = route('articles.show', ['alias' => $request->input('article_alias')]);
                }
                break;
            case 'portfolioLink':
                if ($request->input('filter_alias')) {
                    if ($request->input('filter_alias') === 'parent') {
                        $data['path'] = route('portfolios.index');
                    } else {
                        // Отображение всех портфолио по указанному фильтру 'filter_alias'
                    }
                } else if ($request->input('portfolio_alias')) {
                    $data['path'] = route('portfolios.show', ['alias' => $request->input('portfolio_alias')]);
                }
                break;
            default:
                return ['error' => 'Не выбран путь для пункта меню'];
        }

        unset($data['type']);

        if ($menu->update($data)) {
            return ['status' => 'Пункт меню обновлен'];
        } else {
            return ['error' => 'Не удалось обновить пункт меню'];
        }
    }

    public function deleteMenu($menu)
    {
        if (Gate::denies('delete', $menu)) {
//            abort(403);
            $key = 'custom.DELETE_' . strtoupper(class_basename($menu)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        if ($menu->delete()) {
            return ['status' => 'Пункт меню удален'];
        } else {
            return ['error' => 'Не удалось удалить пункт меню'];
        }
    }
}