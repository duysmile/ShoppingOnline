<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PaymentRequest extends FormRequest
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
            'address' => 'bail|required|string|max:256',
            'tel_no' => 'bail|required|string|max:15'
        ];
    }

    public function attributes()
    {
        return [
            'address' => 'Địa chỉ nhận hàng',
            'tel_no' => 'Số điện thoại'
        ];
    }
}
