<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveInvoiceRequest;
use App\Model\Invoice;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the invoices in progress.
     *
     * @return \Illuminate\Http\Response
     */
    public function inProgress()
    {
        $status = constants('CART.STATUS.PENDING');
        $invoices = Invoice::getAllInvoices(constants('CART.STATUS.PENDING'));
        return view('admin.invoices.index', compact(['status', 'invoices']));
    }

    /**
     * Display a listing of the invoices in transport.
     *
     * @return \Illuminate\Http\Response
     */
    public function inTransport()
    {
        $status = constants('CART.STATUS.ON_THE_WAY');
        $invoices = Invoice::getAllInvoices(constants('CART.STATUS.ON_THE_WAY'));
        return view('admin.invoices.index', compact(['status', 'invoices']));
    }

    /**
     * Display a listing of the invoices in success.
     *
     * @return \Illuminate\Http\Response
     */
    public function inSuccess()
    {
        $status = constants('CART.STATUS.PAID');
        $invoices = Invoice::getAllInvoices(constants('CART.STATUS.PAID'));
        return view('admin.invoices.index', compact(['status', 'invoices']));
    }

    /**
     * Display a listing of the invoices in canceled.
     *
     * @return \Illuminate\Http\Response
     */
    public function inCanceled()
    {
        $status = constants('CART.STATUS.CANCELED');
        $invoices = Invoice::getAllInvoices(constants('CART.STATUS.CANCELED'));
        return view('admin.invoices.index', compact(['status', 'invoices']));
    }

    /**
     * Approve a invoice
     * @param ApproveInvoiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Error
     */
    public function updateStatus(ApproveInvoiceRequest $request)
    {
        $data = $request->only(['id', 'type']);
        $check = false;
        if ($data['type'] == 'invoice') {
            $check = Invoice::approveInvoice($data['id']);
        }

        if($check) {
            return response()->json([
                'success' => true,
                'data' => Invoice::getAllInvoices(constants('CART.STATUS.PENDING')),
                'message' => 'Đã xác nhận đơn hàng.'
            ]);
        }
        throw new \Error('Đã xảy ra lỗi. Vui lòng thử lại.');
    }

    /**
     * Approve a invoice
     * @param ApproveInvoiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Error
     */
    public function updateStatusDetail(ApproveInvoiceRequest $request)
    {
        $data = $request->only(['id', 'type']);
        $check = false;
        if ($data['type'] == 'invoice') {
            $check = Invoice::approveInvoice($data['id']);
        }

        if($check) {
            return redirect('admin/invoices/in-progress')->with('success', 'Đã duyệt đơn hàng thành công.');
        }
        return redirect('/admin/invoices/in-progress')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại');
    }

    /**
     * cancel a invoice
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request)
    {
        $id = $request->only('del-id')['del-id'];
        $invoice = Invoice::find($id);
        if ($invoice->cancel()) {
            return redirect('admin/invoices/in-progress')->with('success', 'Đã hủy đơn hàng thành công');
        }
        return redirect('admin/invoices/in-progress')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }

    /**
     * show detail of a invoice
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDetail($id)
    {
        $invoice = Invoice::showDetail($id);
        return view('admin.invoices.detail', compact('invoice'));
    }
}
