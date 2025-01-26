<?php
namespace App\Services;
use App\Models\Stock;
use App\Models\StockPrice;
use App\Services\AlphaVantageService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StockPriceProcessorService {


    private function updateSockPrice (Stock $stock): bool {
        $service = app(AlphaVantageService::class);
        $data = $service->fetchStockPrice($stock->ticker);
    
        if (!isset($data['Time Series (1min)'])) {
            Log::error("Error fetching data for {$stock}");
            return false;
        }

        // current data 
        $latestTime = array_key_first($data['Time Series (1min)']);
        $stockData = $data['Time Series (1min)'][$latestTime];


        

        // previous data
        $previousData = array_values($data['Time Series (1min)'])[1]; // get previous data 
        $previousClosePrice = $previousData['4. close']; // get previous price

        // calculate percentage change
        $percentageChange =( ($stockData['4. close'] - $previousClosePrice ) / $previousClosePrice ) * 100;

        $stockPriceData = [
            'stock_id'    => $stock->id,
            'open'      => $stockData['1. open'],
            'high'      => $stockData['2. high'],
            'low'       => $stockData['3. low'],
            'close'     => $stockData['4. close'],
            'previous_close' => $previousClosePrice,
            'percentage_change' => $percentageChange,
            'recorded_at'=> $latestTime
        ];

        // Store the data in the database
        StockPrice::updateOrCreate(['stock_id' => $stock->id],
        $stockPriceData);

        $cacheKey = self::getStockCacheKey($stock->ticker); 
        $cacheData = [
            'stock' => $stock,
            'stock_price' => $stockPriceData
        ];

        Cache::put($cacheKey, $cacheData, now()->addMinute());
        echo "adding into cache";
        Log::info("{$stock->ticker}: price updated");
        return true;
    }

    public function updateStockPrices() {
        $stocks = Stock::all();
        try {
            
            foreach($stocks as $stock) {
                $this->updateSockPrice($stock);
            }
        } catch (\Throwable $e) {
            echo $e->getMessage();
            Log::error("Error fetching data for {$e->getMessage()}");
        }
    }

    static function getStockCacheKey ($ticker) {
        return "stock_price_{$ticker}";
    }
}
?>