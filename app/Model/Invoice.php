<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'amount', 'status', 'address', 'tel_no'];

    /**
     * attach users with their invoices
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * attach detail order to invoice
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }

    /**
     * load item to confirm
     * @param $request
     * @return array
     */
    public static function loadInvoiceTmp($request)
    {
        $items = json_decode($request->only('items')['items']);
        $amount = $request->only('amount')['amount'];
        $products = [];
        try {
            $totalItems = 0;
            foreach ($items as $item) {
                $product = Product::where([
                    'id' => $item->id,
                    'is_approved' => true
                ])->first();
                if ($product->quantity < $item->qty || $item->qty < 0 || $product == null) {
                    throw new \Exception('Danh sách sản phẩm không hợp lệ.');
                }
                $totalItems += $item->qty;
                $product->quantity = $item->qty;
                $products[] = $product;
            }
            if ($totalItems > constants('CART.TOTAL_ITEMS')) {
                throw new \Exception('Số lượng sản phẩm tối đa là ' . constants('CART.TOTAL_ITEMS'));
            }

            return [
                'success' => true,
                'data' => [
                    'products' => $products,
                    'amount' => $amount
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * confirm invoice
     * @param $request
     * @return array
     */
    public static function confirmInvoice($request)
    {
        $items = json_decode(session('cart_items'));
        $amount = session('amount');
        $address = $request->only('address')['address'];
        $tel_no = $request->only('tel_no')['tel_no'];
        DB::beginTransaction();
        try {
            $totalItems = 0;
            $invoice = Invoice::create([
                'user_id' => Auth::user()->id,
                'amount' => $amount,
                'status' => false,
                'address' => $address,
                'tel_no' => $tel_no
            ]);

            $cart = Cart::getCurrent();

            foreach ($items as $item) {
                $product = Product::where([
                    'id' => $item->id,
                    'is_approved' => true
                ])->first();
                if ($product->quantity < $item->qty || $item->qty < 0) {
                    throw new \Exception('Số lượng sản phẩm không hợp lệ.');
                }
                $totalItems += $item->qty;
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'quantity' => $item->qty,
                    'status' => false
                ]);

                $cart->items()->detach($product);
            }
            if ($totalItems > constants('CART.TOTAL_ITEMS')) {
                throw new \Exception('Số lượng sản phẩm tối đa là ' . constants('CART.TOTAL_ITEMS'));
            }

            DB::commit();
            return [
                'success' => true
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
