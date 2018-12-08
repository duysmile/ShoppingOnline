<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at')->paginate(constants('PAGINATE.PRODUCTS'));
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getCategories();
        return view('admin.products.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        if(Product::saveProduct($request)){
            return redirect('admin/products')->with('success', 'Thêm sản phẩm thành công.');
        }
        return redirect('admin/products/create')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::getProduct($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::getCategories();
        $product = Product::getProduct($id);
        return view('admin.products.edit', compact(['categories', 'product']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        if(Product::updateProduct($request, $id)){
            return redirect('admin/products')->with('success', 'Chỉnh sửa sản phẩm thành công.');
        }
        return redirect('admin/products/create')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->only('del-id')['del-id'];
        $product = Product::find($id);
        if ($request->only('type')['type'] == 'approve'){
            if ($product->delete()) {
                return redirect('admin/approve')->with('success', 'Đã xóa sản phẩm thành công');
            }
            return redirect('admin/approve')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
        }
        else if ($product->delete()) {
            return redirect('admin/products')->with('success', 'Đã xóa sản phẩm thành công');
        }
        return redirect('admin/products')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }
}
