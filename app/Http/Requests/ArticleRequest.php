<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->canDo(['CREATE_ARTICLES', 'UPDATE_ARTICLES']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'text' => 'required',
            'category_id' => 'required|integer'
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('alias', 'unique:articles|max:255', function ($input) {
            if ($this->route()->hasParameter('article')) {
                $model = $this->route()->parameter('article');
                return ($model->alias !== $input->alias) && !empty($input->alias);
            }
            return !empty($input->alias);
        });

        $validator->sometimes('image', 'required', function ($input) {
            return empty($input->old_image);
        });

/*
        $validator->after(function ($validator) {
            if (!$this->route()->hasParameter('image') && !$this->route()->hasParameter('old_image')) {
                $validator->errors()->add('memu_type', 'Необходимо выбрать изображение.');
            }
        });*/
    }
}
