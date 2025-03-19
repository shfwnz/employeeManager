<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

Route::apiResource('/employee', App\Http\Controllers\Api\EmployeeController::class);
Route::apiResource('/division', App\Http\Controllers\Api\DivisionController::class);
Route::apiResource('/position', App\Http\Controllers\Api\PositionController::class);
Route::apiResource('/job', App\Http\Controllers\Api\JobController::class);
