<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return $this->belongsToMany(Category::class, 'categories_products')->withTimestamps();
    }

    /**
     * attach images thumbnail product
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images() {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }

    /**
     * save new product with image
     * @param $request
     * @return bool
     */
    public static function saveProduct($request) {
        $data = $request->only(['product_name', 'sum', 'desc', 'qty', 'categories', 'price']);
        DB::beginTransaction();
        try{
            $product = Product::create([
                'name' => $data['product_name'],
                'slug' => str_slug($data['product_name'], '-'),
                'summary' => $data['sum'],
                'price' => $data['price'],
                'description' => $data['desc'],
                'quantity' => $data['qty'],
                'created_user' => Auth::user()->id
            ]);

            foreach ($request->file('images') as $key => $image) {
                $extension = $image->getClientOriginalExtension();
                $name = 'thumbnail_' . $product->id . '_' . time() . '.' .$extension;

                $uploadPath = public_path('images\\' . $product->id);

                Image::create([
                    'url' => $uploadPath . '\\' . $key . $name ,
                    'created_user' => Auth::user()->id,
                    'product_id' => $product->id
                ]);

                $image->move($uploadPath, $name);
            }

            if(!empty($data['categories'])){
                $product->categories()->attach(Category::whereIn('id', $data['categories'])->get());
            }
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e);
            return false;
        }

    }
}
