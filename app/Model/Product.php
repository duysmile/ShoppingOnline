<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'summary', 'quantity', 'description', 'price', 'slug'];
    /**
     * attach categories to product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() {
        return $this->belongsToMany(Category::class, 'categories_products');
    }

    /**
     * attach images thumbnail product
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images() {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }

    public static function saveProduct($request) {
        $data = $request->only(['product_name', 'sum', 'content', 'qty', 'categories', 'price']);
        $check = Product::create([
           'name' => $data['product_name'],
           'slug' => str_slug($data['product_name'], '-'),
           'summary' => $data['sum'],
           'price' => $data['price'],
           'description' => $data['content'],
           'quantity' => $data['qty'],
        ]);
        return $check;
    }
}
