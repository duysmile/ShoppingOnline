<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimeRevenueRequest;
use App\Model\Invoice;
use App\Model\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * define dashboard view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $countNewProducts = Product::countUnapprovedProduct();
        $countInvoice = Invoice::countInvoices();
        $invoiceInProgress = $countInvoice['countInProgress'];
        $invoiceInTransport = $countInvoice['countOnTheWay'];
        $invoiceInDestroy = $countInvoice['countCanceled'];
        $revenues = Invoice::calRevenue();
        $orders = Invoice::calOrder();
        return view(
            'admin',
            compact([
                'countNewProducts',
                'invoiceInProgress',
                'invoiceInTransport',
                'invoiceInDestroy',
                'revenues',
                'orders'
            ])
        );
    }

    /**
     * get revenue according time
     * @param TimeRevenueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRevenue(TimeRevenueRequest $request) {
        $revenue = Invoice::calRevenue($request->time);
        return response()->json([
            'success' => true,
            'data' => $revenue
        ]);
    }

    /**
     * get orders according time
     * @param TimeRevenueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrder(TimeRevenueRequest $request) {
        $order = Invoice::calOrder($request->time);
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }
}
