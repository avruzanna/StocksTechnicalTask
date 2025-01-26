<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->decimal('open', 10, 4)->nullable();
            $table->decimal('high', 10, 4)->nullable();
            $table->decimal('low', 10, 4)->nullable();
            $table->decimal('close', 10, 4)->nullable();
            $table->decimal('previous_close', 10, 4)->nullable();
            $table->decimal('percentage_change', 10, 4)->nullable();
            $table->timestamp('recorded_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_prices');
    }
};
