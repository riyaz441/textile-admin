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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('category_id');
            $table->unsignedBigInteger('company_id')->index();
            $table->string('category_name', 100);
            $table->string('category_code', 20)->unique();
            $table->text('description')->nullable();
            $table->integer('parent_category_id')->default(0)->index();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
