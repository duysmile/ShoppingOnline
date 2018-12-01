<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    /**
     * attach owner to cart
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * attach items to cart
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Product::class, 'carts_products')->withPivot('quantity');
    }

    /**
     * add a item to cart
     * @param $request
     * @return bool
     */
    public static function addToCart($request)
    {
        $id = $request->only('id')['id'];
        $cart = Auth::user()->cart;
        DB::beginTransaction();
        try {
            if ($cart == null) {
                $cart = new Cart();
                $cart->user_id = Auth::user()->id;
                $cart->save();
            }
            $product = $cart->items->find($id);

            if ($product != null) {
                $oldQty = $product->pivot->quantity;
                //TODO: check quantity products

                $cart->items()->updateExistingPivot($id, [
                    'quantity' => $oldQty + 1
                ]);
            } else {
                $product = Product::find($id);
                $cart->items()->save($product, ['quantity' => 1]);
            }
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }

    }
}
