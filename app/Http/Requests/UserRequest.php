<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->canDo(['CREATE_USERS', 'UPDATE_USERS']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->parameter('user')->id ?? '';

        return [
            'login' => 'required|string|unique:users,login,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|integer'
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('password', 'required|string|min:6|confirmed', function ($input) {
            return !empty($input->password)
                || (empty($input->password) && $this->route()->getName() !== 'admin.users.update');
        });
    }
}
