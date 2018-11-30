<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * show home page client
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::getTopCategories();
        $topProducts = Product::getTopProducts();
        return view('client.home', compact(['topProducts', 'categories']));
    }

    /**
     * list products by category
     * @param $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list($category)
    {
        $category = Category::where('slug', $category)->first();
        $listProducts = $category->products()->where('is_approved', true)->paginate(constants('paginate.products_client'));
        return view('client.list_products', compact(['category', 'listProducts']));
    }

    /**
     * get detail product according slug
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailProduct($slug)
    {
        $product = Product::getDetailProduct($slug);
        return view('client.detail', compact('product'));
    }
}
