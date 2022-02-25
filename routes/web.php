<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->middleware('is_admin')->group(function(){
    Route::get('/', [AdminController::class, 'admin'])->name('admin');
    Route::get('/users', [AdminController::class, 'users'])->name('adminUsers');
    Route::get('/products/{category}', [AdminController::class, 'products'])->name('adminProducts');
    Route::post('/products', [AdminController::class, 'productsFilter'])->name('adminProductsFilter');
    Route::get('/categories', [AdminController::class, 'categories'])->name('adminCategories');
    Route::get('/test', [AdminController::class, 'test'])->name('adminTest');
    Route::get('/enterAsUser/{id}', [AdminController::class, 'enterAsUser'])->name('enterAsUser');
    Route::post('/exportCategories', [AdminController::class, 'exportCategories'])->name('exportCategories');
    Route::post('/deleteCategory', [AdminController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/addCategory', [AdminController::class, 'addCategory'])->name('addCategory');
    Route::post('/addproduct', [AdminController::class, 'addProduct'])->name('addProduct');
    Route::post('/deleteproduct', [AdminController::class, 'deleteProduct'])->name('deleteProduct');
});

Route::prefix('cart')->group(function(){
    Route::get('/', [CartController::class, 'cart'])->name('cart');
    Route::post('removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('addToCart', [CartController::class, 'addToCart'])->name('addToCart');
    Route::post('createOrder', [CartController::class, 'createOrder'])->name('createOrder');
});

Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');

Route::prefix('profile')->middleware('check_user')->group(function(){
    Route::get('/{id}', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/{id}/orderhistory', [ProfileController::class, 'orderHistory'])->name('orderHistory');
    Route::get('/{id}/repeatorder/{order_id}', [ProfileController::class, 'repeatOrder'])->name('repeatOrder');
});
Route::post('/profile/save', [ProfileController::class, 'save'])->name('saveProfile');

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

