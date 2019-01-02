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
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
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
                if ((int)$product->quantity < (int)$item->qty || (int)$item->qty < 0 || $product == null) {
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
            $countInvoices = $user->invoices()->where([
                'status' => constants('CART.STATUS.PENDING')
            ])
                ->orWhere([
                    'status' => constants('CART.STATUS.ON_THE_WAY')
                ])
                ->whereDate('created_at', Carbon::now()->toDateString())
                ->count();
            if ($countInvoices > constants('USER.MAX_INVOICES')) {
                throw new \Exception('Bạn chỉ có thể đặt tối đa 5 đơn 1 ngày.');
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

                // subtract product according qty in invoice
                $product->quantity -= $item->qty;
                $product->save();

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
     * get all invoices according status of current user
     * @param $status
     * @return mixed
     */
    public static function getInvoicesCurrent($status)
    {
        if ($status == constants('CART.STATUS.TRANSPORTED')) {
            $invoices = Invoice::where([
                'user_id' => Auth::user()->id
            ])
                ->whereIn('status' , [$status, constants('CART.STATUS.PAID')])
                ->orderBy('status')
                ->orderBy('created_at', 'desc')
                ->paginate(constants('PAGINATE.INVOICES'));
        } else {
            $invoices = Invoice::where(['status' => $status, 'user_id' => Auth::user()->id])
                ->orderBy('created_at', 'desc')
                ->paginate(constants('PAGINATE.INVOICES'));
        }
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
        if ($user_id != null) {
            $inProgress = Invoice::where([
                'user_id' => $user_id,
                'status' => constants('CART.STATUS.PENDING')
            ])->count();
            $onTheWay = Invoice::where([
                'user_id' => $user_id,
                'status' => constants('CART.STATUS.ON_THE_WAY')
            ])->count();
            $transported = Invoice::where([
                'user_id' => $user_id,
                'status' => constants('CART.STATUS.TRANSPORTED')
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
            $transported = Invoice::where([
                'status' => constants('CART.STATUS.TRANSPORTED')
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
            'countTransported' => $transported,
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
        if ($invoice != null) {
            $invoice->status = constants('CART.STATUS.ON_THE_WAY');
            return [
                'success' => $invoice->save(),
                'data' => constants('CART.STATUS.PENDING')
            ];
        }

        $invoice = Invoice::where(['id' => $id, 'status' => constants('CART.STATUS.ON_THE_WAY')])->first();
        if ($invoice != null) {
            $invoice->status = constants('CART.STATUS.TRANSPORTED');
            return [
                'success' => $invoice->save(),
                'data' => constants('CART.STATUS.ON_THE_WAY')
            ];
        }

        return [
            'success' => false,
            'data' => ''
        ];
    }

    /**
     * cancel invoice
     * @return bool
     */
    public function cancel()
    {
        foreach ($this->items as $item) {
            $product = $item->product;
            $product->quantity += $item->quantity;
            $product->save();
        }
        $this->status = constants('CART.STATUS.CANCELED');
        return $this->save();
    }

    /**
     * confirm is transported
     * @param $id
     * @return array
     */
    public static function confirmTransported($id)
    {
        $invoice = Invoice::where([
            'id' => $id,
            'status' => constants('CART.STATUS.ON_THE_WAY')
        ])->first();

        if ($invoice != null) {
            $invoice->update([
                'status' => constants('CART.STATUS.TRANSPORTED')
            ]);
            $invoices = Invoice::where([
                'status' => constants('CART.STATUS.ON_THE_WAY'),
                'user_id' => Auth::user()->id
            ])->get();
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

    /**
     * confirm is received
     * @param $id
     * @return array
     */
    public static function confirmReceived($id)
    {
        $invoice = Invoice::where([
            'id' => $id,
            'status' => constants('CART.STATUS.TRANSPORTED')
        ])->first();

        if ($invoice != null) {
            $invoice->update([
                'status' => constants('CART.STATUS.PAID')
            ]);

            $invoices = Invoice::where([
                'user_id' => Auth::user()->id
            ])
                ->whereIn('status', [constants('CART.STATUS.TRANSPORTED'), constants('CART.STATUS.PAID')])
                ->orderBy('status')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($invoices as $key => $invoice) {
                $invoices[$key]->quantity = $invoice->items()->sum('quantity');
                $invoices[$key]->totalItems = $invoice->items()->sum('quantity');
                $invoices[$key]->owner = $invoice->owner->name;
                $invoices[$key]->status = constants('STATUS.' . $invoice->status);
            }

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

    /**
     * cancel an invoice
     * @param $id
     * @return array
     */
    public static function cancelInvoice($id)
    {
        $invoice = Invoice::where([
            'id' => $id,
            'status' => constants('CART.STATUS.PENDING')
        ])
            ->orWhere([
                'id' => $id,
                'status' => constants('CART.STATUS.ON_THE_WAY')
            ])
            ->first();

        if ($invoice != null) {
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

    /**
     * show detail of an invoice
     * @param $id
     * @return mixed
     */
    public static function showDetail($id)
    {
        $items = Invoice::find($id);
        return $items;
    }

    /**
     * calculate revenue according time
     * @param string $type
     * @return \Illuminate\Support\Collection
     */
    public static function calRevenue($type = 'day')
    {
        switch ($type) {
            case 'day':
                $revenues = DB::table('invoices')
                    ->select(DB::raw('
                        SUM(amount) as revenue, 
                        DATE_FORMAT(created_at, "%d-%m-%Y") as day, 
                        count(*) as count
                    '))->where([
                        'status' => constants('CART.STATUS.PAID'),
                        ['created_at', '<=', Carbon::now()->toDateTimeString()],
                        ['created_at', '>=', Carbon::now()->subDay(30)->toDateTimeString()]
                    ])
                    ->orderBy('created_at')
                    ->groupBy(DB::raw('day(created_at)'))
                    ->get();
                break;
            case 'month':
                $revenues = DB::table('invoices')
                    ->select(DB::raw('
                        SUM(amount) as revenue, 
                        DATE_FORMAT(created_at, "%m-%Y") as day, 
                        count(*) as count
                    '))->where([
                        'status' => constants('CART.STATUS.PAID'),
                        ['created_at', '<=', Carbon::now()->toDateTimeString()],
                        ['created_at', '>=', Carbon::now()->subMonth(12)->toDateTimeString()]
                    ])
                    ->orderBy('created_at')
                    ->groupBy(DB::raw('month(created_at)'))
                    ->get();
                break;
            case 'year':
                $revenues = DB::table('invoices')
                    ->select(DB::raw('
                        SUM(amount) as revenue, 
                        DATE_FORMAT(created_at, "%Y") as day, 
                        count(*) as count
                    '))->where([
                        'status' => constants('CART.STATUS.PAID'),
                        ['created_at', '<=', Carbon::now()->toDateTimeString()],
                        ['created_at', '>=', Carbon::now()->subYear(5)->toDateTimeString()]
                    ])
                    ->orderBy('created_at')
                    ->groupBy(DB::raw('year(created_at)'))
                    ->get();
                break;
            default:
                $revenues = Invoice::where([
                    'status' => constants('CART.STATUS.PAID')
                ])->sum('amount');
        }
        return $revenues;
    }

    /**
     * calculate order according time
     * @param string $type
     * @return \Illuminate\Support\Collection
     */
    public static function calOrder($type = 'day')
    {
        switch ($type) {
            case 'day':
                $orders = DB::table('invoices')
                    ->select(DB::raw('count(*) as count, status'))
                    ->whereDay('created_at', Carbon::now()->day)
                    ->groupBy('status')
                    ->get();
                break;
            case 'month':
                $orders = DB::table('invoices')
                    ->select(DB::raw('count(*) as count, status'))
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->groupBy('status')
                    ->get();
                break;
            case 'year':
                $orders = DB::table('invoices')
                    ->select(DB::raw('count(*) as count, status'))
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('status')
                    ->get();
                break;
            default:
                $orders = Invoice::where([
                ])->count();
        }
        foreach ($orders as $key => $order) {
            switch ($order->status) {
                case constants('CART.STATUS.PENDING'):
                    $orders[$key]->status = 'Đang xử lí';
                    break;
                case constants('CART.STATUS.ON_THE_WAY'):
                    $orders[$key]->status = 'Đang giao hàng';
                    break;
                case constants('CART.STATUS.PAID'):
                    $orders[$key]->status = 'Đã giao';
                    break;
                case constants('CART.STATUS.CANCELED'):
                    $orders[$key]->status = 'Bị hủy';
                    break;
            }
        }

        return $orders;
    }
}
