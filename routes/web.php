<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use Gloudemans\Shoppingcart\Facades\Cart;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ProductController::class, 'index'])->name('homepage');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

Route::group(['middleware' => ['auth']], function(){
    /* Cart routes */
    Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/ajouter', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/panier/{rowId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/supprimer-article/{rowId}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/coupon', [CartController::class, 'storeCoupon'])->name('cart.storeCoupon');
    Route::delete('/coupon', [CartController::class, 'destroyCoupon'])->name('cart.destroyCoupon');
});

Route::group(['middleware' => ['auth']], function(){
    /*Payment route */
    Route::get('/paiement', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/paiement', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/merci', [PaymentController::class, 'merci'])->name('payment.merci');
});

// Route::get('videpanier', function(){
//     Cart::destroy();
// });


// Route::group(['middleware' => ['role:Admin']], function (){
//     Voyager::routes();
// });
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});



Auth::routes();

Route::get('/mes-commandes', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
