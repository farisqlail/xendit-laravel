<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::post('/create-invoice', [PaymentController::class, 'createInvoice']);
Route::post('/pay', [PaymentController::class, 'createEWalletInvoice']);
Route::get('/get-invoice/{invoiceId}', [PaymentController::class, 'getInvoice']);
