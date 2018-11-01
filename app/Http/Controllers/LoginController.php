<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\LoginRequest;
use http\Env\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except('logout');
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = $this->user->where('email', $credentials['id_login'])
            ->orWhere('name', $credentials['id_login'])
            ->first();

        try {
            if ($user === null) {
                return response()->json([
                    'success' => false,
                    'message' => [
                        'id_login' => 'Email/ Tên đăng nhập không tồn tại.'
                    ],
                    'data' => [
                        'id_login' => $credentials['id_login'],
                        'pass_login' => $credentials['pass_login']
                    ]
                ]);
            } else if (!password_verify($credentials['pass_login'], $user['password'])) {
                return response()->json([
                    'success' => false,
                    'message' => [
                        'pass_login' => 'Mật khẩu không đúng.'
                    ],
                    'data' => [
                        'id_login' => $credentials['id_login'],
                        'pass_login' => $credentials['pass_login']
                    ]
                ]);
            }
            Auth::attempt([
                'name' => $user->name,
                'password' => $credentials['pass_login']
            ], $credentials['remember_me']);
        } catch (AuthenticationException $e){
            return response()->json([
                'success' => false,
                'message' => [
                    'server' => 'Đăng nhập thất bại. Vui lòng thử lại.'
                ]
            ]);
        }
        return response()->json([
            'success' => true
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
