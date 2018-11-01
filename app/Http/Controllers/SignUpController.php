<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\User;

class SignUpController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest');
    }

    public function postSignup(SignUpRequest $request)
    {
        //TODO: coding signup
    }
}
