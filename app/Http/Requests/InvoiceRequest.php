<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InvoiceRequest extends FormRequest
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
            'list' => 'bail|required',
            'amount' => 'bail|numeric|min:1'
        ];
    }

    public function attributes()
    {
        return [
            'list' => 'Danh sách sản phẩm',
            'amount' => 'Tổng số tiền'
        ];
    }
}
