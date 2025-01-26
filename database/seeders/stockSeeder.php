<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stock;

class stockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stock::insert([
            [ 'ticker' => 'AAPL', 'name' => 'Apple Inc.'],
            [ 'ticker' => 'GOOGL', 'name' => 'Google'],
            [ 'ticker' => 'META', 'name' => 'Meta'],
            [ 'ticker' => 'NFLX', 'name' => 'Netflix'],
            [ 'ticker' => 'NVDA', 'name' => 'NVIDIA'],
            [ 'ticker' => 'INTC', 'name' => 'Intel Corp'],
            [ 'ticker' => 'IBM', 'name' => 'IBM'],
            [ 'ticker' => 'MSFT', 'name' => 'Microsoft'],
            [ 'ticker' => 'AMZN', 'name' => 'Amazon'],
            [ 'ticker' => 'TSLA', 'name' => 'Tesla']

        ]);
    }
}
