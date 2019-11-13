<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Customer extends Model
{
     use HasApiTokens;

     protected $fillable = [
        'name', 'phone', 'address','credit_limit','c_status'
    ];
}
