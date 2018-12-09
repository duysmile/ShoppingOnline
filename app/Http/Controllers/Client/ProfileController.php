<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Model\InfoUser;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
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

        $invoiceInProgress = $user->invoices()->where('status', constants('CART.STATUS.PENDING'))->get();
        $invoiceOnWay = $user->invoices()->where('status', constants('CART.STATUS.ON_THE_WAY'))->get();
        $invoiceCanceled = $user->invoices()->where('status', constants('CART.STATUS.CANCELED'))->get();

        foreach($invoiceInProgress as $invoice) {
            $invoice->totalItems = $invoice->items()->sum('quantity');
        }

        foreach($invoiceOnWay as $invoice) {
            $invoice->totalItems = $invoice->items()->sum('quantity');
        }

        return view('client.profile', compact(['user', 'invoiceInProgress', 'invoiceOnWay', 'invoiceCanceled']));
    }

    public function update(UpdateProfileRequest $request)
    {
        $data = User::updateProfile($request);
        return response()->json($data);
    }
}
