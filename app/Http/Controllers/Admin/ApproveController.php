<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveRequest;
use App\Model\Product;

class ApproveController extends Controller
{
    public function index() {
        $products = Product::getUnapprovedProduct();
        return view('admin.approve.index', compact('products'));
    }

    public function approve(ApproveRequest $request) {
        $data = $request->only(['id', 'type']);
        $check = false;
        if ($data['type'] == 'product') {
            $check = Product::approveProduct($data['id']);
        }

        if($check) {
            return response()->json([
                'success' => true,
                'data' => Product::getUnapprovedProductApi(),
                'message' => 'Đã phê duyệt.'
            ]);
        }
        throw new \Error('Đã xảy ra lỗi. Vui lòng thử lại.');
    }
}
