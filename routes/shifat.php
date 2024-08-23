<?php

use App\Http\Controllers\PosController;


Route::group(['as'=> 'pos.', 'prefix' => 'pos'],function (){
    Route::get('/load-cart', [PosController::class, 'loadCart'])->name('load-cart');
    Route::post('/add-to-cart', [PosController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/remove-cart-item', [PosController::class, 'removeCartItem'])->name('remove-cart-item');
});
