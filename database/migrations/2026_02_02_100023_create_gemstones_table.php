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
        if (Schema::hasTable('gemstones')) {
            Schema::drop('gemstones');
        }
        Schema::create('gemstones', function (Blueprint $table) {
            $table->bigIncrements('gemstone_id');
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->string('gemstone_name', 50);
            $table->enum('type', ['diamond', 'ruby', 'sapphire', 'emerald', 'pearl', 'other']);
            $table->string('color', 30)->nullable();
            $table->string('clarity', 30)->nullable();
            $table->string('cut_grade', 30)->nullable();
            $table->decimal('default_carat_weight', 6, 3)->nullable();
            $table->string('gemstone_code', 50)->nullable()->unique();
            $table->string('shape', 50)->nullable();
            $table->string('cut', 50)->nullable();
            $table->decimal('measurement_length', 6, 2)->nullable();
            $table->decimal('measurement_width', 6, 2)->nullable();
            $table->decimal('measurement_depth', 6, 2)->nullable();
            $table->string('treatment', 100)->nullable();
            $table->string('origin', 100)->nullable();
            $table->string('fluorescence', 50)->nullable();
            $table->string('symmetry', 50)->nullable();
            $table->string('polish', 50)->nullable();
            $table->string('girdle', 50)->nullable();
            $table->string('culet', 50)->nullable();
            $table->decimal('table_percentage', 5, 2)->nullable();
            $table->decimal('depth_percentage', 5, 2)->nullable();
            $table->string('certification_lab', 100)->nullable();
            $table->string('certification_number', 100)->nullable();
            $table->date('certification_date')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->index('type', 'idx_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gemstones');
    }
};
