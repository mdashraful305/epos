<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;


Route::group(['as'=> 'pos.', 'prefix' => 'pos'],function (){
    Route::get('/load-cart', [PosController::class, 'loadCart'])->name('load-cart');
    Route::post('/add-to-cart', [PosController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/remove-cart-item', [PosController::class, 'removeCartItem'])->name('remove-cart-item');
});

Route::group(['as'=> 'order.', 'prefix' => 'order'],function (){
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('create', [OrderController::class, 'create'])->name('create');
    Route::post('store', [OrderController::class, 'store'])->name('store');
    Route::get('edit/{id}', [OrderController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [OrderController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [OrderController::class, 'destroy'])->name('destroy');
});
