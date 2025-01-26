<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockPriceController;

Route::get('/', [StockPriceController::class, 'getStocks']);