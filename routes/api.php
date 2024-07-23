<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// ['middleware' => ['web']]
Route::prefix('v1')->group(function() {
    Route::get('/user', [AuthController::class, 'user'])->name('user');

    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
