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
Route::get('/employee/total', [EmployeeController::class, 'getTotalEmployees']);
Route::get('/employee/status', [EmployeeController::class, 'getEmployeesByStatus']);
Route::get('/employee/division', [EmployeeController::class, 'getEmployeesByDivision']);
Route::apiResource('/division', DivisionController::class);
Route::get('/divisions', [DivisionController::class, 'index']);
Route::apiResource('/position', PositionController::class);
Route::apiResource('/job', JobController::class);
