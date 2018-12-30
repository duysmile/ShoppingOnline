<?php
/**
 * Created by PhpStorm.
 * User: duy21
 * Date: 11/28/2018
 * Time: 10:27 PM
 */

namespace App\Http\ViewComposers;

use App\Model\Cart;
use App\Model\Category;
use App\Model\Product;
use Illuminate\View\View;

class ClientViewComposer
{
    /**
     * attach data to view
     * @param View $view
     */
    public function compose(View $view)
    {
        $categories = Category::getCategoriesClient();
        $cartCount = Cart::getCountCurrent();
        $recommendProducts = Product::recommendProduct();
        $view->with('categories', $categories);
        $view->with('cartCount', $cartCount);
        $view->with('recommendProducts', $recommendProducts);
    }
}
