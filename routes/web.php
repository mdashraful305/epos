<?php

use App\Http\Controllers as Con;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SubCategoryController;
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
include('shifat.php');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return redirect()->route('dashboard');
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');

    return redirect()->back()->withSuccess('Cache cleared successfully.');
})->name('clear');
Route::get('/route', function () {
    Artisan::call('permission:create-permission-routes');
    return redirect()->back()->withSuccess('Cache cleared successfully.');
})->name('route');
Auth::routes();
Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => ['auth', 'permission']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [HomeController::class, 'profile'])->name('users.profile');
    include('shifat.php');

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'permissions' => PermissionController::class,
    ]);

    //catagoey
    Route::group(['as'=> 'categories.', 'prefix' => 'categories'],function (){
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    //subcatagory
    Route::group(['as'=> 'subcategories.', 'prefix' => 'subcategories'],function (){
        Route::get('/', [SubCategoryController::class, 'index'])->name('index');
        Route::get('create', [SubCategoryController::class, 'create'])->name('create');
        Route::post('store', [SubCategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SubCategoryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [SubCategoryController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [SubCategoryController::class, 'destroy'])->name('destroy');
    });



    //customer
    Route::group(['as'=> 'customers.', 'prefix' => 'customers'],function (){
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('create', [CustomerController::class, 'create'])->name('create');
        Route::post('store', [CustomerController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CustomerController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [CustomerController::class, 'destroy'])->name('destroy');
    });


    //product
    Route::group(['as'=> 'products.', 'prefix' => 'products'],function (){
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('subcategories/', [ProductController::class, 'getSubCategories'])->name('subcategories');
        Route::post('change-status', [ProductController::class, 'changeStatus'])->name('change-status');
    });

    //store
    Route::group(['as'=> 'stores.', 'prefix' => 'stores'],function (){
        Route::get('/', [StoreController::class, 'index'])->name('index');
        Route::get('create', [StoreController::class, 'create'])->name('create');
        Route::post('store', [StoreController::class, 'store'])->name('store');
        Route::get('show/{id}', [StoreController::class, 'show'])->name('show');
        Route::get('edit/{id}', [StoreController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [StoreController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [StoreController::class, 'destroy'])->name('destroy');
    });

    //pos
    Route::group(['as'=> 'pos.', 'prefix' => 'pos'],function (){
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::post('subcategories/', [PosController::class, 'getSubCategories'])->name('subcategories');
        Route::post('products/', [PosController::class, 'getProducts'])->name('products');
        Route::get('customers/', [PosController::class, 'getCustomers'])->name('customers');
    });




    //expense
    Route::group(['as'=> 'expenses.', 'prefix' => 'expenses'], function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('index');
        Route::get('create', [ExpenseController::class, 'create'])->name('create');
        Route::post('store', [ExpenseController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ExpenseController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ExpenseController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [ExpenseController::class, 'destroy'])->name('destroy');
    });

    Route::group(['as'=> 'suppliers.', 'prefix' => 'suppliers'], function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('create', [SupplierController::class, 'create'])->name('create');
        Route::post('store', [SupplierController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [SupplierController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [SupplierController::class, 'destroy'])->name('destroy');
    });



});
