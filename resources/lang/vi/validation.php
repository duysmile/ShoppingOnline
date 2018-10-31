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
        'file'    => ':attribute nhiều nhất :max kilobytes.',
        'string'  => ':attribute nhiều nhất :max kí tự.',
        'array'   => ':attribute nhiều nhất :max items.',
    ],
    'boolean' => ':attribute phải có giá trị là true hoặc false.',
];
