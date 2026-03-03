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
        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->increments('stock_id');
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('location_id')->index();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->integer('quantity_on_hand')->default(0);
            $table->integer('quantity_allocated')->default(0);
            $table->integer('quantity_available')->storedAs('(`quantity_on_hand` - `quantity_allocated`)');
            $table->integer('reorder_point')->default(0);
            $table->integer('reorder_quantity')->nullable();
            $table->date('last_reorder_date')->nullable();
            $table->date('next_reorder_date')->nullable();
            $table->decimal('average_cost', 12, 2)->default(0.00);
            $table->decimal('total_value', 12, 2)->storedAs('(`quantity_on_hand` * `average_cost`)');
            $table->decimal('stock_turnover_rate', 8, 2)->nullable();
            $table->integer('days_in_stock')->default(0);
            $table->date('last_movement_date')->nullable();
            $table->integer('safety_stock_level')->default(0);
            $table->integer('minimum_stock_level')->default(0);
            $table->integer('maximum_stock_level')->nullable();
            $table->timestamps();

            $table->index('last_movement_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_stocks');
    }
};
