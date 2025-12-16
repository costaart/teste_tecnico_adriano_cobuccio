<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ReversalController;
use App\Http\Controllers\TransferController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:3,1');
});

// rotas autenticadas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    
    Route::get('/deposit', [DepositController::class, 'show'])->name('deposit.show');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store')->middleware('throttle:10,1');
    
    Route::get('/transfer', [TransferController::class, 'show'])->name('transfer.show');
    Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store')->middleware('throttle:5,1');

    Route::post('/transactions/{transaction}/revert', [ReversalController::class, 'store'])->name('transactions.revert')->middleware('throttle:5,1');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
