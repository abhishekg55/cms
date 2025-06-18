<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'contacts', 'as' => 'contact.'], function () {
        Route::post('/store', [HomeController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
        Route::post('/update', [HomeController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'custom-fields', 'as' => 'custom-fields.'], function () {
        Route::get('/', [CustomFieldController::class, 'index'])->name('index');
        Route::post('/store', [CustomFieldController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CustomFieldController::class, 'edit'])->name('edit');
        Route::post('/update', [CustomFieldController::class, 'update'])->name('update');
        Route::post('/getCustomFields', [CustomFieldController::class, 'getCustomFields'])->name('getCustomFields');
    });
    Route::get('/merge/{id}', [HomeController::class, 'merge'])->name('contact.merge');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
