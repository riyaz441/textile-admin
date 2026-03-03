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
        Schema::create('component_types', function (Blueprint $table) {
            $table->bigIncrements('type_id');
            $table->unsignedBigInteger('company_id')->index();
            $table->string('type_name', 100);
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_types');
    }
};
