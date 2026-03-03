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
        Schema::create('product_measurements', function (Blueprint $table) {
            $table->increments('measurement_id');
            $table->unsignedBigInteger('product_id')->index();
            $table->string('measurement_type', 50)->nullable();
            $table->string('unit', 20)->nullable();
            $table->decimal('value_decimal', 8, 2)->nullable();
            $table->string('value_string', 100)->nullable();
            $table->string('position', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_measurements');
    }
};
