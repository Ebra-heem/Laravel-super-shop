<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Product extends Model
{
     use HasApiTokens;

     protected $fillable = [
        'p_name', 'p_code', 'p_price','p_sku','p_unit','p_status',
    ];
}
