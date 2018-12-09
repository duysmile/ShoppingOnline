<?php

return [
    'required' => ':attribute là bắt buộc',
    'min' => [
        'numeric' => ':attribute ít nhất :min.',
        'file'    => ':attribute ít nhất :min kilobytes.',
        'string'  => ':attribute ít nhất :min kí tự.',
        'array'   => ':attribute ít nhất :min items.',
    ],
    'max'                  => [
        'numeric' => ':attribute nhiều nhất nhất :max.',
        'file'    => ':attribute có kích thước lớn nhất là :max kilobytes.',
        'string'  => ':attribute nhiều nhất :max kí tự.',
        'array'   => ':attribute nhiều nhất :max items.',
    ],
    'boolean' => ':attribute phải có giá trị là true hoặc false.',
    'confirmed' => ':attribute không trùng khớp.',
    'unique' => ':attribute đã tồn tại.',
    'email' => ':attribute không hợp lệ.',
    'string' => ':attribute phải là chuỗi kí tự.',
    'numeric' => ':attribute phải là một số.',
    'mimes' => ':attribute phải có định dạng :values',
    'date_format' => ':attribute không đúng định dạng'
];
