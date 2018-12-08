<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutItemsRequest;
use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\PaymentRequest;
use App\Model\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * attach data and go to confirm invoice
     * @param CheckoutItemsRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function confirmInvoice(CheckoutItemsRequest $request)
    {
        $data = Invoice::loadInvoiceTmp($request);
        if($data['success']) {
            $products = $data['data']['products'];
            $amount = $data['data']['amount'];
            session([
                'cart_items' => $request->only('items')['items'],
                'amount' => $request->only('amount')['amount']
            ]);
            return view('client.checkout', compact(['products', 'amount']));
        } else {
            dd($data['message']);
            return redirect('cart');
        }
    }

    /**
     * add a new invoice for user
     * @param PaymentRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function addInvoice(PaymentRequest $request)
    {
        $data = Invoice::confirmInvoice($request);
        if($data['success']) {
            session([
                'cart_items' => [],
                'amount' => ''
            ]);
            return redirect('profile')->with(['payment' => true, 'success' => 'Đặt hàng thành công.']);
        } else {
            return view('client.error', ['message' => $data['message']]);
        }
    }
}
