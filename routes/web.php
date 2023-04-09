<?php

use App\Http\Controllers\Manage\ManageController;
use App\Http\Controllers\Manage\RemovedItemController;
use App\Models\Basket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('front.pages.home');
})->name('home');

Route::get('/cart', function () {
    return view('front.pages.cart');
})->name('cart');

Auth::routes([
    'reset' => false,
]);

Route::group(
    [
        'prefix' => 'manage',
        'middleware' => ['auth', 'role:admin,sales_team']
    ], function(){

    Route::get('dashboard', [ManageController::class, 'dashboard'])->name('dashboard');

    Route::get('cart/removed', [RemovedItemController::class, 'index'])->name('removed.index');
    Route::delete('cart/removed/{product_id}', [RemovedItemController::class, 'destroy'])->name('removed.destroy');

});

