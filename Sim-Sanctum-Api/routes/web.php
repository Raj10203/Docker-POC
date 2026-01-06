<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Debug route: checks cache and sends a test email (Mailpit)
use App\Http\Controllers\TestController;
Route::get('/debug/test-cache-mail', [TestController::class, 'check'])->name('debug.test-cache-mail');
