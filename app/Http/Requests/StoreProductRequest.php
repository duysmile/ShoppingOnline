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
        return Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'));
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
            'desc' => 'bail|required|string|min:100',
            'images' => 'bail|required',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,bmp|max:2048',
            'price' => 'bail|required|numeric|min:0',
            'discount' => 'integer|min:0|max:99'
        ];
    }

    public function attributes()
    {
        return [
            'product_name' => 'Tên sản phẩm',
            'sum' => 'Mô tả sản phẩm',
            'qty' => 'Số lượng sản phẩm',
            'categories' => 'Danh mục của sản phẩm',
            'desc' => 'Chi tiết sản phẩm',
            'images' => 'Ảnh tải lên',
            'price' => 'Giá sản phẩm',
            'discount' => 'Giảm giá'
        ];
    }
}
