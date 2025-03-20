<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/employee', EmployeeController::class);
Route::get('/employee/detail', [DetailEmployeeController::class, 'index']);
Route::get('/employee/detail/{id}', [DetailEmployeeController::class, 'show']);
Route::apiResource('/division', DivisionController::class);
Route::apiResource('/position', PositionController::class);
Route::apiResource('/job', JobController::class);
