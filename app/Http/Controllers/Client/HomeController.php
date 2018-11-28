<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::getTopCategories();
        $topProducts = Product::getTopProducts();
        return view('client.home', compact(['topProducts', 'categories']));
    }

    public function list($category)
    {
        $category = Category::where('slug', $category)->first();
        $listProducts = $category->products()->paginate(constants('paginate.products_client'));
        return view('client.list_products', compact(['category', 'listProducts']));
    }
}
