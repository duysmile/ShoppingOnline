<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewPassword;
use App\Http\Requests\PasswordRequest;
use App\Mail\PasswordResetMail;
use App\PasswordReset;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
        $this->middleware('guest');
    }

    public function postToken(PasswordRequest $request)
    {
        $email_reset = $request->only('email_reset')['email_reset'];
        $check_email = User::where('email', $email_reset)->first();
        if (isset($check_email)) {
            $pwdReset = PasswordReset::where('user_id', $check_email->id)->first();
            DB::beginTransaction();
            try {
                if (isset($pwdReset)) {
                    $pwdReset->delete();
                }

                PasswordReset::create([
                    'user_id' => $check_email['id'],
                    'token' => $check_email->id . str_random(35) . time()
                ]);

                Mail::to($email_reset)->send(new PasswordResetMail($check_email));
                DB::commit();

            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => [
                        'email_reset' => 'Đã xảy ra lỗi, vui lòng thử lại.'
                    ],
                    'data' => [
                        'email_reset' => $email_reset,
                    ]
                ]);
            }
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => [
                'email_reset' => 'Email này không tồn tại'
            ],
            'data' => [
                'email_reset' => $email_reset,
            ]
        ]);
    }

    public function reset($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (isset($passwordReset)) {
            return view('welcome', ['token' => $token]);
        }
        abort(404);
    }

    public function storeNewPass(NewPassword $request) {
        $new_password = $request['password'];
        $token = $request['token'];
        $pwdReset = PasswordReset::where('token', $token)->first();
        $user = User::where('id', $pwdReset->user_id)->first();
        $user->password = bcrypt($new_password);
        if ($user->save()){
            $pwdReset->delete();
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => [
                'server' => 'Đã xảy ra lỗi, vui lòng thử lại.'
            ],
            'data' => [
                'password' => '',
            ]
        ]);
    }
}
