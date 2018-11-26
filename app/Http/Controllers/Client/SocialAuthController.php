<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\SocialAccountService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($social, Request $request)
    {
        session(['redirect_url' => $request['_url']]);
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
        auth()->login($user);
        $url = session()->get('redirect_url');
        session()->forget('redirect_url');
        return redirect()->to($url);
    }
}
