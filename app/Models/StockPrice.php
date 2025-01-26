<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPrice extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'open','low', 'high', 'close', 'previous_close', 'percentage_change','recorded_at'];

    protected $casts = [
        'open'      => 'decimal:4',
        'high'      => 'decimal:4',
        'low'       => 'decimal:4',
        'close'     => 'decimal:4',
        'previous_close'  => 'decimal:4',
        'percentage_change'  => 'decimal:4', 
        'recorded_at'=> 'datetime',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}