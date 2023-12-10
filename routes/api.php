<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/login', 'login');
    Route::post('/auth/register', 'register');
    Route::post('/auth/logout', 'logout');
    Route::post('/auth/refresh', 'refresh');

});

Route::controller(UserController::class)->group(function () {
    Route::post('/user/info', 'get_user_info');
    Route::post('/user/update-info', 'update_user_info');

});
