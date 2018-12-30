<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('admin');
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
            "email" => 'bail|required|email|max:255|unique:users,email',
            "tel" => 'bail|required|max:15',
            "password" => 'bail|required|min:8|max:255|confirmed',
            "role" => 'bail|required|string|in:staff,user'
        ];
    }

    public function attributes()
    {
        return [
            "username" => "Tên đăng nhập",
            "email" => "Email",
            "tel" => "Số điện thoại",
            "password" => "Mật khẩu",
            "role" => "Vai trò"
        ];
    }
}
