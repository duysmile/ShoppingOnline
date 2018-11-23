<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
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
            'product_name' => 'bail|required|max:255|string',
            'sum' => 'max:1000|string',
            'qty' => 'bail|required|numeric|min:0',
            'categories' => '',
            'content' => 'bail|required|string|min:100',
            'images' => 'bail|required|mimes:jpeg,jpg,png,gif,bmp|max:5120',
            'price' => 'bail|required|integer|min:0'
        ];
    }

    public function attributes()
    {
        return [
            'product_name' => 'Tên sản phẩm',
            'sum' => 'Mô tả sản phẩm',
            'qty' => 'Số lượng sản phẩm',
            'categories' => 'Danh mục của sản phẩm',
            'content' => 'Chi tiết sản phẩm',
            'images' => 'Ảnh tải lên',
            'price' => 'Giá sản phẩm'
        ];
    }
}
