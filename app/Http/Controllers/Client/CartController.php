<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartRequest;
use App\Http\Requests\DeleteItemCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Model\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * display cart
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cart = Cart::getCurrent();
        return view('client.cart', compact('cart'));
    }

    /**
     * add to cart one item
     * @param AddCartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCartOneItem(AddCartRequest $request)
    {
        $data = Cart::addToCart($request);
        if ($data['success']) {
            return response()->json($data);
        } else {
            return response()->json($data);
        }
    }

    /**
     * update quantity of specified item by id
     * @param UpdateCartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQtyItem(UpdateCartRequest $request)
    {
        $data = Cart::updateQtyItem($request);
        if ($data['success']) {
            return response()->json($data);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi. Vui lòng thử lại.'
            ]);
        }
    }

    public function deleteItem(DeleteItemCartRequest $request)
    {
        $data = Cart::deleteItem ($request);
        if ($data['success']) {
            return response()->json($data);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi. Vui lòng thử lại.'
            ]);
        }
    }
}
