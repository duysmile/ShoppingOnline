<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutItemsRequest extends FormRequest
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
            'items' => 'bail|required|string',
            'amount' => 'bail|required|numeric|min:1000'
        ];
    }

    public function attributes()
    {
        return [
            'items' => 'Sản phẩm được chọn',
            'amount' => 'Tổng số tiền',
        ];
    }
}
