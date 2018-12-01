<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartRequest;
use App\Model\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * add to cart one item
     * @param AddCartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCartOneItem(AddCartRequest $request) {
        if (Cart::addToCart($request)){
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi. Vui lòng thử lại.'
            ]);
        }
    }
}
