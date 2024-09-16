<?php

use App\Http\Controllers\PosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmployeeController;


Route::group(['as'=> 'pos.', 'prefix' => 'pos'],function (){
    Route::get('/load-cart', [PosController::class, 'loadCart'])->name('load-cart');
    Route::post('/add-to-cart', [PosController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/update-cart-item', [PosController::class, 'updateCartItem'])->name('update-cart-item');
    Route::post('/remove-cart-item', [PosController::class, 'removeCartItem'])->name('remove-cart-item');
});

Route::group(['as'=> 'orders.', 'prefix' => 'orders'],function (){
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('create', [OrderController::class, 'create'])->name('create');
    Route::post('store', [OrderController::class, 'store'])->name('store');
    Route::get('edit/{id}', [OrderController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [OrderController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [OrderController::class, 'destroy'])->name('destroy');
    Route::post('products', [OrderController::class, 'getOrderData'])->name('getOrderData');
    Route::post('receipt', [OrderController::class, 'receipt'])->name('receipt');
});

Route::group(['as'=>'employees.', 'prefix'=>'employees'],function(){
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('create', [EmployeeController::class, 'create'])->name('create');
    Route::post('store', [EmployeeController::class, 'store'])->name('store');
    Route::get('edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy');

});


Route::delete('users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('reports', [HomeController::class, 'reportIndex'])->name('reports.index');
Route::get('reports/orders', [HomeController::class, 'reportOrders'])->name('reports.orders');
Route::get('reports/customer', [HomeController::class, 'reportCustomer'])->name('reports.customers');
