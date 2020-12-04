<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\coupon;
use App\Models\Category;
use MercurySeries\Flashy\Flashy;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartItems = Cart::content();
        $ids = $cartItems->pluck('id');
        $products = Product::findMany($ids);
        // $categories = Category::first();
        

        return view('cart/index', compact('cartItems', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $duplicata = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id == $request->product_id;
        });
        
        if($duplicata -> isNotEmpty()){
            
            Flashy::warning('Ce produit existe déjà dans votre panier');
            return redirect()->route('homepage');
            // ->with('success', 'Ce produit existe déjà dans votre panier !');
        }
        
        $product = Product::find($request->product_id);
        
        Cart::add($product->id, $product->title, 1, $product->price)
        ->associate('App\Models\Product');
        
            Flashy::message('Votre Produit a bien été ajouté !');
            return redirect()->route('homepage');
            // ->with('success', 'Votre Produit a bien été ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function storeCoupon(Request $request){

        $code = $request->get('code');
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            Flashy::error('Le coupon est invalide');
            return redirect()->back();
            // ->with('error', 'Le coupon est invalide');
        }
        $request->session()->put('coupon', [
            'code' => $coupon->code,
            'remise' => $coupon->discount(Cart::subtotal())
        ]);
            
        Flashy::success('Le coupon est appliqué');
        return redirect()->back();
        // ->with('success', 'Le coupon est appliqué !');
     }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,6'
        ]);

        if ($validator->fails()) {
            Flashy::error('La quantité doit être comprise entre 1 et 5 !');
            return response()->json(['error', 'Quantity product has not been change']);
        }

        if ($data['quantity'] > $data['stock']) {
            Session::flash('error','Cette quantité de produit n est pas disponible');
            return response()->json(['error', 'Laquantité n est pas modifiable']);
        }
        // $data = $request->json()->all();

        Cart::update($id, $request->quantity);

        Flashy::success( 'La quantité du produit a été modifié avec success !!');
        
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        
        Flashy::primary( 'Votre produit a été supprimé avec succès !!');
        return back();
        // ->with('success', 'Votre produit a été supprimé avec succès !!');
    }
    
    public function destroyCoupon()
    {
        request()->session()->forget('coupon');
        
        Flashy::success( 'Le coupon a été retiré  !!');
        return redirect()->back();
        // ->with('success', 'Le coupon a été retiré !');
    }
}
