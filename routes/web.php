<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhooksController;


Route::get('/', function () {
    return view('welcome');
});



Route::post('webhook-reciever',[WebhookController::class,'webhook'])->name('webhook');
