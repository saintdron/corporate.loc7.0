<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->canDo(['CREATE_PORTFOLIOS', 'UPDATE_PORTFOLIOS']);
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
            'filter_alias' => 'required|string',
            'date' => 'required|string'
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('alias', 'unique:portfolios|max:255', function ($input) {
            if ($this->route()->hasParameter('portfolio')) {
                $model = $this->route()->parameter('portfolio');
                return ($model->alias !== $input->alias) && !empty($input->alias);
            }
            return !empty($input->alias);
        });

        $validator->sometimes('image', 'required', function ($input) {
            return empty($input->old_image);
        });
    }
}
