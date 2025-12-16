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
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// rotas autenticadas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    
    
    Route::get('/deposit', [DepositController::class, 'show'])->name('deposit.show');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');
    
    Route::get('/transfer', [TransferController::class, 'show'])->name('transfer.show');
    Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');

    Route::post('/transactions/{transaction}/revert', [ReversalController::class, 'store'])->name('transactions.revert');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
