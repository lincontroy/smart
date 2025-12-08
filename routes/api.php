<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
// use App\Http\Controllers\CryptoController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/process-card-payment', [PaymentController::class, 'processCardPayment']);
Route::post('/mpesa-stk-push', [PaymentController::class, 'mpesaStkPush']);
// Route::post('/mpesacallback', [PaymentController::class, 'mpesaStkPush']);
    Route::get('/mpesa-status/{checkoutRequestId}', [PaymentController::class, 'mpesaStatus']);
// Payment routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/withdrawals', [WithdrawalController::class, 'index']);
        Route::get('/withdrawals/{withdrawal}', [WithdrawalController::class, 'show']);
   
    // Card payments
    // Route::post('/process-card-payment', [PaymentController::class, 'processCardPayment']);
    
    // M-Pesa payments
    
    
    // // Crypto payments
    // Route::get('/crypto/wallet/{crypto}', [CryptoController::class, 'getWalletAddress']);
    // Route::post('/crypto/verify', [CryptoController::class, 'verifyCryptoPayment']);
});

// Public webhook routes (no auth required)
Route::post('/mpesa/callback', [PaymentController::class, 'mpesaCallback'])->name('mpesa.callback');

