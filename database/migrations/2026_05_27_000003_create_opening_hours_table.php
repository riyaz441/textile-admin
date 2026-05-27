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
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('websetting_id')->constrained('websettings')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_index');
            $table->string('day_name', 20);
            $table->string('from_time', 20)->nullable();
            $table->string('to_time', 20)->nullable();
            $table->timestamps();

            $table->unique(['websetting_id', 'day_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_hours');
    }
};
