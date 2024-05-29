<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('admin', function () {
    return view('admin');
});

Route::post('checkout',[WebhookController::class,'checkout'])->name('checkout');

Route::post('webhook-receiver',[WebhookController::class,'webhook'])->name('webhook');
Route::get('notify',[WebhookController::class,'notify'])->name('notify');