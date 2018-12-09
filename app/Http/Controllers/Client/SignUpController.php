<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Mail\VerifyEmail;
use App\Model\Role;
use App\Model\User;
use App\Model\VerifyUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SignUpController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest');
    }

    public function postSignup(SignUpRequest $request)
    {
        $result = User::signUp($request);
        return response()->json($result);
        // TODO: add tel to infomation table
    }

    public function verifyEmail($token)
    {
        $result = User::verifyEmail($token);
        if ($result['success']) {
            return redirect("/")->with('success', $result['status']);
        } else {
            return redirect("/")->with('error', $result['status']);
        }
    }
}
