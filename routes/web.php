<?php

use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('orders.index'));
});

Route::get('/orders', [OrdersController::class, 'inProgressIndex'])->name('orders.index');
