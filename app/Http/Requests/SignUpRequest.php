<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            "username" => 'bail|required|min:5|max:255|unique:users,name',
            "email" => 'bail|email|required|max:255|unique:users,email',
            "tel" => 'bail|required|max:11',
            "password" => 'bail|required|min:8|max:255|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            "username" => "Tên đăng nhập",
            "email" => "Email",
            "tel" => "Số điện thoại",
            "password" => "Mật khẩu"
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
