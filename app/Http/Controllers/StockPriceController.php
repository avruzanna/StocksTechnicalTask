<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Stock;
use App\Models\StockPrice;
use App\Services\StockPriceProcessorService;

class StockPriceController extends Controller
{
  
    public function getStocks(){

        $stocks = Stock::all()->take(10);
        
        $response = [];
        $notExistsInCache = [];
       
        foreach($stocks as $stock) {
            $cacheKey = StockPriceProcessorService::getStockCacheKey($stock->ticker);
            $existsInCache = Cache::get($cacheKey);
            if ($existsInCache) {
                $response[$stock->ticker] = ['stock_price'=>$existsInCache['stock_price'], 'stock'=> $stock];
            } else {
                $notExistsInCache[] = $stock->id;
            }
        }
        if(count($notExistsInCache)) {
            $pricesFromDb = StockPrice::whereIn('stock_id' , $notExistsInCache)->get();
            
            foreach($pricesFromDb as $price) {
                $cacheKey = StockPriceProcessorService::getStockCacheKey($price->stock->ticker);
                $cacheData = [
                    'stock' => $price->stock,
                    'stock_price' => $price->toArray(),
                ];
                Cache::put($cacheKey, $cacheData, now()->addMinute());
                $response[$price->stock->ticker] = $cacheData;
            }
        }


        return view('stocks', [
            "info"=>"",
            'stocks' => $response,
        ]);
    }
}