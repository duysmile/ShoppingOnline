<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_login' => 'bail|required|max:255|min:5',
            'pass_login' => 'bail|required|min:8|max:255',
            'remember_me' => 'nullable|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'id_login' => "Email/Tên đăng nhập",
            'pass_login' => "Mật khẩu"
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
