<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InfoUser extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'tel_no', 'gender', 'birth_date'];
}
