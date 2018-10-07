<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->canDo(['CREATE_MENUS', 'UPDATE_MENUS']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->menuTypeCheck()) {
                $validator->errors()->add('memu_type', 'Необходимо выбрать тип меню.');
            }
        });
    }

    protected function menuTypeCheck()
    {
        return $this->filled('custom_link')
            || ($this->filled('category_alias') && $this->category_alias !== '0')
            || $this->filled('article_alias')
            || $this->filled('filter_alias')
            || $this->filled('portfolio_alias');
    }
}
