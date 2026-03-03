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
        Schema::create('product_components', function (Blueprint $table) {
            $table->id('component_id');
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('component_type_id')->nullable();
            $table->string('component_name', 100);

            // Material Information
            $table->unsignedBigInteger('material_id')->nullable();
            $table->decimal('material_weight', 8, 3)->nullable();
            $table->string('material_purity', 20)->nullable();

            // Gemstone Information
            $table->unsignedBigInteger('gemstone_id')->nullable();
            $table->integer('gemstone_quantity')->default(1);
            $table->decimal('gemstone_weight', 8, 3)->nullable();
            $table->decimal('gemstone_carat_weight', 8, 3)->nullable();
            $table->string('gemstone_shape', 50)->nullable();
            $table->string('gemstone_color', 50)->nullable();
            $table->string('gemstone_clarity', 50)->nullable();
            $table->string('gemstone_cut_grade', 50)->nullable();
            $table->string('gemstone_certificate', 100)->nullable();

            // Dimensions
            $table->decimal('dimension_length', 8, 2)->nullable();
            $table->decimal('dimension_width', 8, 2)->nullable();
            $table->decimal('dimension_height', 8, 2)->nullable();
            $table->decimal('diameter', 8, 2)->nullable();

            // Costing
            $table->decimal('component_cost', 10, 2)->nullable();
            $table->decimal('labor_cost', 10, 2)->nullable();
            $table->decimal('setting_cost', 10, 2)->nullable();
            $table->decimal('total_component_cost', 10, 2)->storedAs('(component_cost + labor_cost + setting_cost)');

            // Position/Order
            $table->integer('position_order')->default(0);
            $table->string('position_description', 200)->nullable();

            // Status
            $table->boolean('is_main_component')->default(false);

            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('product_id', 'idx_product');
            $table->index('component_type_id', 'idx_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_components');
    }
};
