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
        Schema::create('product_labor', function (Blueprint $table) {
            $table->increments('product_labor_id');
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('labor_id')->index();
            $table->integer('quantity')->default(1);
            $table->decimal('actual_hours', 5, 2)->nullable();
            $table->decimal('labor_cost', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('product_id', 'idx_product_labor_product');
            $table->index('labor_id', 'idx_product_labor_labor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_labor');
    }
};
