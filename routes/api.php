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

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

// Endpoint yang memerlukan autentikasi
Route::middleware('auth:api')->group(function () {
    // Mendapatkan data pengguna yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Endpoint untuk resource
    Route::apiResource('/employee', EmployeeController::class);
    Route::apiResource('/division', DivisionController::class);
    Route::apiResource('/position', PositionController::class);
    Route::apiResource('/job', JobController::class);

    // Endpoint untuk statistik karyawan
    Route::get('/employees/total', [EmployeeController::class, 'getTotalEmployees']);
    Route::get('/employees/status', [EmployeeController::class, 'getEmployeesByStatus']);
    Route::get('/employees/division', [EmployeeController::class, 'getEmployeesByDivision']);
});

// Endpoint untuk mendapatkan daftar divisi (tanpa autentikasi)
Route::get('/divisions', [DivisionController::class, 'index']);
