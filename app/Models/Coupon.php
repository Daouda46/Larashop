<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function discount($subtotal){

        return ($subtotal * ($this->percent_of /100));
    }
}
