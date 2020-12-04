<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["title", "slug", "subtotal", "description", "stock"];
    // public $timestamps = false;

    public function getPrice(){
        $price = $this->price / 10;
        return number_format($price, 2,',',' ')." eur";
    }

    public function categories(){

        return $this->belongsToMany('App\Models\Category');
    }
}
