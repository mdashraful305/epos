<?php

use App\Http\Controllers as Con;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
    return view('welcome');
});
Route::get('/home', function () {
    return redirect()->route('dashboard');
});

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');

    return redirect()->back()->withSuccess('Cache cleared successfully.');
})->name('clear');
Route::get('/route', function() {
    Artisan::call('permission:create-permission-routes');
    return redirect()->back()->withSuccess('Cache cleared successfully.');
})->name('route');
Auth::routes();
Route::group(['namespace' => 'App\Http\Controllers','middleware' => ['auth', 'permission']], function()
{
    Route::get('/dashboard', [Con\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [Con\HomeController::class, 'profile'])->name('users.profile');


    Route::resources([
        'roles' => Con\RoleController::class,
        'users' => Con\UserController::class,
        'permissions'=>Con\PermissionController::class,
        'stores'=>Con\StoreController::class,
        'categories'=>Con\CategoryController::class,
        'products'=>Con\ProductController::class,
    ]);


});
