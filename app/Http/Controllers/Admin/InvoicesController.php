<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveInvoiceRequest;
use App\Model\Invoice;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the invoices in progress.
     *
     * @return \Illuminate\Http\Response
     */
    public function inProgress()
    {
        $invoices = Invoice::getAllInvoices(constants('CART.STATUS.PENDING'));
        return view('admin.invoices.in_progress', compact('invoices'));
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

    public function cancel(\Illuminate\Http\Request $request)
    {
        $id = $request->only('del-id')['del-id'];
        $invoice = Invoice::find($id);
        if ($invoice->cancel()) {
            return redirect('admin/invoices/in-progress')->with('success', 'Đã hủy đơn hàng thành công');
        }
        return redirect('admin/invoices/in-progress')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }
}
