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
        $qty = empty($request->only('qty')) ? '1' : $request->only('qty')['qty'];

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
                    'quantity' => $oldQty + $qty
                ]);
            } else {
                $product = Product::find($id);
                $cart->items()->save($product, ['quantity' => $qty]);
            }
            DB::commit();
            return [
                'success' => true,
                'count' => $cart->items()->count()
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false,
            ];
        }
    }

    /**
     * get cart of current user
     * @return array
     */
    public static function getCurrent()
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();
        if($cart == null) {
            return [];
        }
        return $cart;
    }

    /**
     * get count items of cart of current user
     * @return int
     */
    public static function getCountCurrent()
    {
        $cart = Cart::getCurrent();
        if (empty($cart)) {
            return 0;
        }
        return $cart->items()->count();
    }

    public static function updateQtyItem($request)
    {
        $data = $request->only(['id', 'qty']);
        $cart = Auth::user()->cart;

        $product = $cart->items()->find($data['id']);

        $qty = empty($request->only('qty')) ? $product->pivot->quantity : $data['qty'];

        if ($product == null) {
            return [
                'success' => false
            ];
        }

        $cart->items()->updateExistingPivot($data['id'], [
           'quantity' => $qty
        ]);

        return ['success' => true];
    }
}
