<?php

namespace App\Model;

use App\Permission\HasPermissionsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasPermissionsTrait;
    use SoftDeletes;

    protected $dates = ['is_blocked'];
    const DELETED_AT = 'is_blocked';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function socialAccount()
    {
        return $this->hasOne('App\Model\SocialAccount');
    }

    public function verifyUser()
    {
        return $this->hasOne('App\Model\VerifyUser');
    }

    public function passwordReset()
    {
        return $this->hasOne('App\Model\PasswordReset');
    }
}
