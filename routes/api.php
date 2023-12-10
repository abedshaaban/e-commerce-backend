<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/login', 'login');
    Route::post('/auth/register', 'register');
    Route::post('/auth/logout', 'logout');
    Route::post('/auth/refresh', 'refresh');

});

Route::controller(UserController::class)->group(function () {
    Route::post('/user/info/get', 'get_user_info');
    Route::post('/user/info/update', 'update_user_info');
    
});

Route::controller(AddressController::class)->group(function () {
    Route::post('/user/address/create', 'create_user_address');
    Route::post('/user/address/get', 'get_user_address');
    Route::post('/user/address/update', 'update_user_address');

});

Route::controller(CartController::class)->group(function () {
    Route::post('/user/cart/create', 'create_cart');
    Route::post('/user/cart/get', 'get_cart_ids');
    Route::post('/user/cart/get/{id}', 'get_cart_by_id');

});

Route::controller(ProductController::class)->group(function () {
    Route::post('/product/create', 'create_product');
    Route::get('/product/get', 'get_products');
    Route::post('/product/update', 'update_product');
    Route::post('/product/add/{cart_id}/{product_id}', 'add_to_cart');

});
