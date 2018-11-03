<?php
/**
 * Created by PhpStorm.
 * User: duy21
 * Date: 11/3/2018
 * Time: 10:39 PM
 */

namespace App\Services;

use App\SocialAccount;
use App\User;

class SocialAccountService
{
    public static function createOrGetUser($providerUser, $social)
    {
        $account = SocialAccount::whereProvider($social)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if($account) {
            return $account->user;
        } else {
            $email = $providerUser->getEmail() ?? $providerUser->getNickname();
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $social
            ]);
            $user = User::whereEmail($email)->first();
            if(!$user) {
                $user = User::create([
                    'email' => $email,
                    'name' => $providerUser->getName(),
                    'email_verified_at' => date('Y-m-d H:i:s', time()),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
