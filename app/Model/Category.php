<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * attach child categories
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * attach posts to category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'categories_products');
    }

    /**
     * attach user who creates this category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_user', 'id');
    }

    /**
     * Get all parent categories
     * @return mixed
     */
    public static function getParentCategories()
    {
        return Category::whereNull('parent_id')->get();
    }

    /**
     * Save a category
     * @param $request
     * @return bool
     */
    public static function saveCategory($request, $id)
    {
        $category = new Category();
        $category->name = $request['name'];
        $category->top = $request['top'] == 'true';
        $category->created_user = $id;
        if ($request['is_parent'] == 'child') {
            if (Category::where('id', $request['parent_id'])->count() > 0) {
                $category->parent_id = $request['parent_id'];
            } else {
                return false;
            }
        }
        return $category->save();
    }

    /**
     * Get categories with format parent - child
     * @return mixed
     */
    public static function getCategories()
    {
        $categories = Category::whereNull('parent_id')->with('children')->paginate(constants('paginate.categories'));
        foreach ($categories as $category) {
            $category['count_products'] = $category->products()->count();
            foreach ($category->children as $child) {
                $child['count_products'] = $child->products()->count();
            }
        }
        return $categories;
    }

    /**
     * Get categories in client with format parent - child
     * @return mixed
     */
    public static function getCategoriesClient()
    {
        $categories = Category::whereNull('parent_id')->with('children')->limit(constants('paginate.categories_client'))->get();
        foreach ($categories as $category) {
            $category['count_products'] = $category->products()->count();
            foreach ($category->children as $child) {
                $child['count_products'] = $child->products()->count();
            }
        }
        return $categories;
    }

    /**
     * Get top categories
     * @return mixed
     */
    public static function getTopCategories()
    {
        $categories = Category::where('top', true)
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($categories as $key => $category) {
            $categories[$key]['products'] = Product::getProductsHome($category);
        }
        return $categories;
    }
}
