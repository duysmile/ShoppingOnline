<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Mail\VerifyEmail;
use App\User;
use App\VerifyUser;
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
        $tmp = $request->only(['email', 'password', 'username', 'tel']);
        DB::beginTransaction();
        try {
            $user = [
                'name' => $tmp['username'],
                'email' => $tmp['email'],
                'password' => Hash::make($tmp['password'])
            ];
            $user_created = User::create($user);
            VerifyUser::create([
                "user_id" => $user_created->id,
                "token" => $user_created->id . str_random(30) . time()
            ]);
            DB::commit();

            Mail::to($user_created->email)->send(new VerifyEmail($user_created));

            return response()->json([
                "success" => true,
                "message" => "Chúng tôi đã gửi email xác thực. Kiểm tra email và xác nhận."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                "success" => false,
                "message" => [
                    "server" => "Đăng kí thất bại. Vui lòng thử lại."
                ],
                "data" => $request->only(['email', 'username', 'tel'])
            ]);
        }
        // TODO: add tel to infomation table
    }

    public function verifyEmail($token) {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser)) {
            $user = $verifyUser->user;
            if ($user->email_verified_at == null){
                $user->email_verified_at = date('Y-m-d H:i:s', time());
                $user->save();
                $status = "Bạn đã xác thực email thành công. Bây giờ bạn có thể đăng nhập.";
            } else {
                $status = "Bạn đã xác thực email rồi. Bây giờ bạn có thể đăng nhập.";
            }
            return redirect("/")->with('success', $status);
        } else {
            return redirect("/")->with('error', 'Xin lỗi không thể tìm thấy email tài khoản của bạn.');
        }
    }
}
