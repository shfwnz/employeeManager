<?php

use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::apiResource('/employee', EmployeeController::class);
    Route::apiResource('/division', DivisionController::class);
    Route::apiResource('/position', PositionController::class);
    Route::apiResource('/job', JobController::class);
});
