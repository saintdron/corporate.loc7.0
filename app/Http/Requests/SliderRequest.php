<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->canDo(['CREATE_SLIDERS', 'UPDATE_SLIDERS']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'max:255',
            'desc' => 'sometimes|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'desc' => '"Описание"'
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('image', 'required', function ($input) {
            return !isset($input->old_image);
        });
    }
}
