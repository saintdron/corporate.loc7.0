<?php

namespace Corp\Repositories;

use Corp\Http\Requests\SliderRequest;
use Corp\Slider;
use Gate;
use Image;

class SliderRepository extends Repository
{
    public function __construct(Slider $model)
    {
        $this->model = $model;
    }

    public function addSlider($request)
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

        $image = $this->getImage($request, $data['cutout']);
        if ($image) {
            $data['img'] = $image;
        } else {
            return ['error' => 'Не удалось сохранить картинку'];
        }

        $this->model->fill($data);

        if ($this->model->save($data)) {
            return ['status' => 'Слайд добавлен'];
        } else {
            return ['error' => 'Не удалось сохранить слайд'];
        }
    }

    public function updateSlider($request, $slider)
    {
        if (Gate::denies('update', $slider)) {
//            abort(403);
            $key = 'custom.UPDATE_' . strtoupper(class_basename($slider)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $data = $request->except('_token', 'image');
        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }

        $image = $this->getImage($request, $data['cutout']);
        if ($image) {
            $data['img'] = $image;
        }

        try {
            if ($slider->update($data)) {
                return ['status' => 'Слайд обновлен'];
            }
            return ['error' => 'Не удалось обновить слайд'];
        } catch (\Exception $exception) {
            return ['error' => 'Не удалось обновить слайд'];
        }
    }

    public function deleteSlider($slider)
    {
        if (Gate::denies('delete', $slider)) {
//            abort(403);
            $key = 'custom.DELETE_' . strtoupper(class_basename($slider)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        if ($slider->delete()) {
            return ['status' => 'Слайд удален'];
        } else {
            return ['error' => 'Не удалось удалить слайд'];
        }
    }

    public function getImage($request, $cutout = 'center')
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $name = str_random(8) . '.jpg';

                Image::make($image)->fit(config('settings.slider_img')['width'], config('settings.slider_img')['height'], function ($constraint) {
                    $constraint->upsize();
                }, $cutout)->save(public_path() . '/' . config('settings.theme') . '/images/' . config('settings.slider_path') . '/' . $name);

                return $name;
            }
        }
        return null;
    }
}