<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $guarded = [];
    public $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }
}
