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
        if (Schema::hasTable('materials')) {
            Schema::drop('materials');
        }
        Schema::create('materials', function (Blueprint $table) {
            $table->bigIncrements('material_id');
            $table->string('material_name', 50)->unique();
            $table->string('carat_purity', 20)->nullable();
            $table->decimal('density', 8, 4)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
