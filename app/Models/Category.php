<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable =["name", "slug"];
    // public $timestamps = false;

   public function products(){

    return $this->belongsToMany('App\Models\Product');
   }
}
