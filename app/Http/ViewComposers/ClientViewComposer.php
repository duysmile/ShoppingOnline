<?php
/**
 * Created by PhpStorm.
 * User: duy21
 * Date: 11/28/2018
 * Time: 10:27 PM
 */

namespace App\Http\ViewComposers;

use App\Model\Category;
use Illuminate\View\View;

class ClientViewComposer
{
    public function compose(View $view)
    {
        $categories = Category::getCategories();
        $view->with('categories', $categories);
    }
}
