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
        Schema::create('labors', function (Blueprint $table) {
            $table->bigIncrements('labor_id');
            $table->unsignedBigInteger('company_id')->index();
            $table->string('labor_code', 50)->unique();
            $table->string('labor_name', 100);
            $table->text('description')->nullable();
            $table->decimal('base_cost', 10, 2)->nullable();
            $table->decimal('cost_per_hour', 10, 2)->nullable();
            $table->decimal('estimated_hours', 5, 2)->nullable();
            $table->enum('skill_level', ['basic', 'intermediate', 'advanced', 'master'])->default('basic')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labors');
    }
};
