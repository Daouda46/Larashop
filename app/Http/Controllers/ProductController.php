<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use MercurySeries\Flashy\Flashy;

class ProductController extends Controller
{
    public function index(){

        if (request()->categorie) {
            $products = Product::with("categories")->whereHas('categories', function
            ($query){
                $query->where('slug', request()->categorie);
            })->orderBy('created_at', 'DESC')->paginate(4);
        }else{

            $products = Product::with("categories")->orderBy('created_at', 'DESC')->paginate(10);
        }
 
        
        return view('product/index')->with('products', $products);
    }
    public function show($slug){
 
        $product = Product::where('slug', $slug)->firstOrFail();
        $stock = $product->stock === 0? 'Indisponible': 'Disponible';
        
        return view('product/show',[
            'stock' => $stock,
            'product' => $product
        ]);
    }

    public function search(){

        request()->validate([
            'q' => 'required|min:3'
        ]);
        $q = request()->input("q");

        $products = Product::where('title', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%")
                // ->orCategory::where('name', 'like', "%$q%")
                ->paginate(6);
        
        return view('product/search')->with('products', $products);
    }
}
