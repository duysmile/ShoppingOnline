<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Model\InfoUser;
use App\Model\Invoice;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * load user info
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        session([
            'active' => constants('PROFILE.INFO')
        ]);
        $user = Auth::user();
        if ($user->info == null) {
            $user->info = new InfoUser();
            $user->info->tel_no = '';
            $user->info->address = '';
            $user->info->gender = null;
            $user->info->birth_date = '';
        }

        return view('client.profile', compact('user'));
    }

    /**
     * update profile
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        $data = User::updateProfile($request);
        return response()->json($data);
    }

    /**
     * load invoices when change tab
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function loadInvoices(Request $request) {
        $status = $request->only('status')['status'];
        $invoices = Invoice::getInvoicesCurrent($status);
        $count = Invoice::countInvoices(Auth::user()->id);
        return response()->json([
            'countInProgress' => $count['countInProgress'],
            'countOnTheWay' => $count['countOnTheWay'],
            'countSuccess' => $count['countSuccess'],
            'countCanceled' => $count['countCanceled'],
            'view' => view('layout_user.invoice-list', compact(['invoices', 'status']))->render()
        ]);
    }

    /**
     * confirm invoice is received
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function confirm(Request $request) {
        $id = $request->only('id')['id'];
        $data = Invoice::confirm($id);
        if ($data['success']){
            $count = Invoice::countInvoices(Auth::user()->id);
            $invoices = $data['data'];
            $status = constants('CART.STATUS.ON_THE_WAY');
            return response()->json([
                'countInProgress' => $count['countInProgress'],
                'countOnTheWay' => $count['countOnTheWay'],
                'countSuccess' => $count['countSuccess'],
                'countCanceled' => $count['countCanceled'],
                'view' => view('layout_user.invoice-list', compact(['invoices', 'status']))->render()
            ]);
        }
        throw new \Exception($data['message']);
    }

    /**
     * cancel invoice
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function cancel(Request $request) {
        $id = $request->only('id')['id'];
        $data = Invoice::cancelInvoice($id);
        if ($data['success']){
            $count = Invoice::countInvoices(Auth::user()->id);
            $invoices = $data['data'];
            $status = constants('CART.STATUS.PENDING');
            return response()->json([
                'countInProgress' => $count['countInProgress'],
                'countOnTheWay' => $count['countOnTheWay'],
                'countSuccess' => $count['countSuccess'],
                'countCanceled' => $count['countCanceled'],
                'view' => view('layout_user.invoice-list', compact(['invoices', 'status']))->render()
            ]);
        }
        throw new \Exception($data['message']);
    }
}
