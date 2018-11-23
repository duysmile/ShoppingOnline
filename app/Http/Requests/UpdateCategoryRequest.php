<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'bail|required|string|max:125|unique:categories,name',
            'parent_id' => 'int',
            'top' => 'string|in:true'
        ];
    }
    public function attributes()
    {
        return [
            "name" => "Tên danh mục",
            "parent_id" => "Danh mục cha",
            "top" => "Lựa chọn hiển thị TOP"
        ];
    }
}
