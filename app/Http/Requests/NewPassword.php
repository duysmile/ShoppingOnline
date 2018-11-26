<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewPassword extends FormRequest
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
            "token" => 'bail|required',
            "password" => 'bail|required|min:8|max:255|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            "password" => "Mật khẩu",
            "token" => "Mã"
        ];
    }
}
