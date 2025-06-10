<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::post('/store', [HomeController::class, 'store'])->name('contact.store');
    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('contact.edit');
    Route::post('/edit/{id}', [HomeController::class, 'update'])->name('contact.edit');
    Route::get('/merge/{id}', [HomeController::class, 'merge'])->name('contact.merge');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
