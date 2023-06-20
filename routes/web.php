<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TempFileUploadController;
use App\Http\Controllers\UserAccountController;
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

// User Account (Registration)
Route::resource('account', UserAccountController::class)->only(['create', 'store', 'index']);

// Auth Routes
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

// Products
Route::get('products/category/{category?}', [ProductController::class, 'index']);
Route::resource('products', ProductController::class);
Route::name('temp.upload')
    ->post('temp/upload', TempFileUploadController::class);
// Cart
Route::resource('cart', CartController::class)
    ->middleware('auth')
    ->only(['index', 'destroy']);
Route::put('cart/{cart}/stock/{stock}', [CartController::class, 'update'])
    ->middleware('auth')
    ->name('cart.update');
// Favorites
Route::resource('favorites', FavoriteController::class)
    ->middleware('auth')
    ->except('store');
Route::post('products/favorite/{product}/{size?}', [FavoriteController::class, 'store'])
    ->middleware('auth')
    ->name('products.favorite');
Route::resource('products.cart', CartController::class)
    ->middleware('auth')
    ->only(['store']);
Route::post('orders', [OrderController::class, 'store'])
    ->middleware('auth')
    ->name('orders.store');
// Route::resource('orders', OrderController::class)
//     ->middleware('auth')
//     ->only(['index']);