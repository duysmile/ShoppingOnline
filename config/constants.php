<?php
/**
 * Created by PhpStorm.
 * User: duy21
 * Date: 11/28/2018
 * Time: 9:43 PM
 */
return [
    'PAGINATE' => [
        'PRODUCTS' => 10,
        'PRODUCTS_CLIENT' => 20,
        'CATEGORIES' => 5,
        'CATEGORIES_CLIENT' => 5,
        'INVOICES' => 10
    ],
    'CART' => [
        'TOTAL_ITEMS' => 20,
        'STATUS' => [
            'PENDING' => 0,
            'ON_THE_WAY' => 1,
            'PAID' => 2,
            'CANCELED' => 3
        ],
    ],
    'USER' => [
        'MAX_INVOICES' => 5
    ],
    'PROFILE' => [
        'INFO' => 1,
        'INVOICES' => 2
    ],
    'STATUS' => [
        '0' => 'Đang xử lí',
        '1' => 'Đang giao',
        '2' => 'Đã nhận',
        '3' => 'Đã hủy'
    ]
];
