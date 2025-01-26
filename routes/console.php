<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


use App\Jobs\FetchStockPriceJob;
use Illuminate\Console\Scheduling\Schedule;
use App\Services\StockPriceProcessorService;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('fetch:stock-prices', function () {
    $stockPriceProccessor = app(StockPriceProcessorService::class);
    try {
        $stockPriceProccessor->updateStockPrices();
        $this->info("Data created");
    }catch(\Throwable $e) {
        $this->error("Error. ");
    }
   
})->describe('Fetch stock prices from Alpha Vantage');