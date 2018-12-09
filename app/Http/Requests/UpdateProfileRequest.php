<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tel' => 'bail|required|string|max:15|required',
            'address' => 'string|max:256|nullable',
            'name' => 'string|max:256|nullable',
            'gender' => 'string|in:true,false|nullable',
            'birth_date' => 'date_format:"Y-m-d"|nullable',
            'email' => 'bail|email|required|',
        ];
    }

    public function attributes()
    {
        return [
            'tel' => 'Số điên thoại',
            'address' => 'Địa chỉ',
            'name' => 'Họ và tên',
            'gender' => 'Giới tính',
            'birth_date' => 'Ngày sinh'
        ];
    }
}
