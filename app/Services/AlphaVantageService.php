<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AlphaVantageService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('ALPHA_VANTAGE_API_KEY');
    }

    public function fetchStockPrice($ticker)
    {

        $mockedData = file_get_contents(dirname(__FILE__) . '/mocked-api-response.json');
        $data = json_decode($mockedData,true);
        return $data;


        try{
            $response = Http::timeout(10)->retry(3, 1000)->get("https://www.alphavantage.co/query", [
                'function' => 'TIME_SERIES_INTRADAY',
                'symbol'   => $ticker,
                'interval' => '1min',
                'apikey'   => $this->apiKey,
            ]);
           
            return $response->json();
        }catch(\Throwable $e) {
            Log::error("Failed to fetch data from Alpha Vantage");

            throw new \Exception('Failed to fetch data from Alpha Vantage');
            return null;
        }
    }
}