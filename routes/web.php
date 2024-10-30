<?php

use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('orders.index'));
});

Route::get('/orders', [OrdersController::class, 'inProgressIndex'])->name('orders.index');
Route::get('/orders/top-products', [OrdersController::class, 'topProductsIndex'])->name('orders.top_products');
Route::get('/product/stock', [ProductsController::class, 'updateToDefaultStock'])->name('product.update_stock');
Route::post('/orders/stock', [ProductsController::class, 'storeDefaultStock'])->name('product.store_stock');

