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
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $countInvoices = $user->invoices()->count();
            if ($countInvoices > constants('USER.MAX_INVOICES')) {
                throw new \Exception('Bạn chỉ có thể đặt tối đa 5 đơn.');
            }
            $totalItems = 0;
            $invoice = Invoice::create([
                'user_id' => Auth::user()->id,
                'amount' => $amount,
                'status' => constants('CART.STATUS.PENDING'),
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
                    'status' => constants('CART.STATUS.PENDING')
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

    /**
     * get all invoices according status
     * @param $status
     * @return mixed
     */
    public static function getAllInvoices($status)
    {
        $invoices = Invoice::where('status', $status)->paginate(constants('PAGINATE.INVOICES'));
        foreach ($invoices as $invoice) {
            $invoice->quantity = $invoice->items()->sum('quantity');
            $invoice->totalItems = $invoice->items()->sum('quantity');
            $invoice->owner = $invoice->owner->name;
            $invoice->status = constants('STATUS.' . $invoice->status);
        }
        return $invoices;
    }

    /**
     * get all invoices according status off current user
     * @param $status
     * @return mixed
     */
    public static function getInvoicesCurrent($status)
    {
        $invoices = Invoice::where(['status' => $status, 'user_id' => Auth::user()->id])->paginate(constants('PAGINATE.INVOICES'));
        foreach ($invoices as $invoice) {
            $invoice->quantity = $invoice->items()->sum('quantity');
            $invoice->totalItems = $invoice->items()->sum('quantity');
            $invoice->owner = $invoice->owner->name;
            $invoice->status = constants('STATUS.' . $invoice->status);
        }
        return $invoices;
    }

    /**
     * count invoices with status
     * @param $user_id
     * @return array
     */
    public static function countInvoices($user_id = null)
    {
        if($user_id != null) {
            $inProgress = Invoice::where([
                'user_id' => $user_id,
                'status' => constants('CART.STATUS.PENDING')
            ])->count();
            $onTheWay = Invoice::where([
                'user_id' => $user_id,
                'status' => constants('CART.STATUS.ON_THE_WAY')
            ])->count();
            $success = Invoice::where([
                'user_id' => $user_id,
                'status' => constants('CART.STATUS.PAID')
            ])->count();
            $canceled = Invoice::where([
                'user_id' => $user_id,
                'status' => constants('CART.STATUS.CANCELED')
            ])->count();
        } else {
            $inProgress = Invoice::where([
                'status' => constants('CART.STATUS.PENDING')
            ])->count();
            $onTheWay = Invoice::where([
                'status' => constants('CART.STATUS.ON_THE_WAY')
            ])->count();
            $success = Invoice::where([
                'status' => constants('CART.STATUS.PAID')
            ])->count();
            $canceled = Invoice::where([
                'status' => constants('CART.STATUS.CANCELED')
            ])->count();
        }

        return [
            'countInProgress' => $inProgress,
            'countOnTheWay' => $onTheWay,
            'countSuccess' => $success,
            'countCanceled' => $canceled,
        ];
    }

    /**
     * approve a invoice
     * @param $id
     * @return bool
     */
    public static function approveInvoice($id)
    {
        $invoice = Invoice::where(['id' => $id, 'status' => constants('CART.STATUS.PENDING')])->first();

        if ($invoice == null) {
            return false;
        }
        $invoice->status = constants('CART.STATUS.ON_THE_WAY');
        return $invoice->save();
    }

    /**
     * cancel invoice
     * @return bool
     */
    public function cancel()
    {
        $this->status = constants('CART.STATUS.CANCELED');
        return $this->save();
    }

    /**
     * confirm is received
     * @param $id
     * @return array
     */
    public static function confirm($id)
    {
        $invoice = Invoice::where([
            'id' => $id,
            'status' => constants('CART.STATUS.ON_THE_WAY')
         ])->first();

        if($invoice != null) {
            $invoice->update([
                'status' => constants('CART.STATUS.PAID')
            ]);
            $invoices = Invoice::getAllInvoices(constants('CART.STATUS.ON_THE_WAY'));
            return [
                'success' => true,
                'data' => $invoices
            ];
        }

        return [
            'success' => false,
            'message' => 'Đã xảy ra lỗi. Vui lòng thử lại.'
        ];
    }

    public static function cancelInvoice($id)
    {
        $invoice = Invoice::where([
            'id' => $id,
            'status' => constants('CART.STATUS.PENDING')
        ])->first();

        if($invoice != null) {
            $invoice->cancel();
            $invoices = Invoice::getAllInvoices(constants('CART.STATUS.PENDING'));
            return [
                'success' => true,
                'data' => $invoices
            ];
        }

        return [
            'success' => false,
            'message' => 'Sản phẩm đang được giao, bạn không thể hủy.'
        ];
    }
}
