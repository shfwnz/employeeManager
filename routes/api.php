<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\JobController;

// Auth
Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

// Security
Route::middleware('auth:api')->group(function () {
    // Get user login
    // api/user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Resource
    Route::apiResource('/employee', EmployeeController::class);
    Route::apiResource('/division', DivisionController::class);
    Route::apiResource('/position', PositionController::class);
    Route::apiResource('/job', JobController::class);

    // Statistic Employees
    Route::prefix('employees')->group(function () {
        Route::get('/total', [EmployeeController::class, 'getTotalEmployees']);
        Route::get('/status', [EmployeeController::class, 'getEmployeesByStatus']);
        Route::get('/division', [EmployeeController::class, 'getEmployeesByDivision']);
    });
});
