<?php

use App\Http\Controllers\PosController;


Route::group(['as'=> 'pos.', 'prefix' => 'pos'],function (){
    Route::post('/add-to-cart', [PosController::class, 'addToCart'])->name('add-to-cart');
});
