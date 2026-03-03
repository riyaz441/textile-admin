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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->unsignedBigInteger('company_id')->index();

            // Identification
            $table->string('sku', 50)->unique();
            $table->string('barcode', 100)->nullable();
            $table->string('product_name', 200);
            $table->text('description')->nullable();

            // Classification
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->unsignedBigInteger('material_id')->nullable()->index();
            $table->unsignedBigInteger('gemstone_id')->nullable()->index();
            $table->unsignedBigInteger('supplier_id')->nullable()->index();
            $table->string('collection', 100)->nullable();
            $table->string('designer', 100)->nullable();
            $table->string('country_of_origin', 50)->nullable();

            // Physical Attributes
            $table->decimal('weight_grams', 8, 3)->nullable();
            $table->decimal('metal_weight', 8, 3)->nullable();
            $table->decimal('gemstone_weight', 6, 3)->nullable();
            $table->integer('gemstone_count')->default(0);
            $table->decimal('total_metal_weight', 8, 3)->nullable();
            $table->decimal('total_gemstone_weight', 8, 3)->nullable();
            $table->string('carat_purity', 20)->nullable();
            $table->string('size', 20)->nullable();
            $table->string('color', 30)->nullable();
            $table->string('style', 50)->nullable();
            $table->enum('gender', ['male', 'female', 'unisex'])->default('unisex')->nullable();

            // Pricing
            $table->decimal('cost_price', 12, 2);
            $table->decimal('markup_percentage', 5, 2)->nullable();
            $table->decimal('selling_price', 12, 2);
            $table->decimal('wholesale_price', 12, 2)->nullable();
            $table->decimal('discount_price', 12, 2)->nullable();

            // Inventory
            $table->integer('quantity_in_stock')->default(0);
            $table->integer('minimum_stock_level')->default(5);
            $table->integer('reorder_quantity')->nullable();

            // Product Composition
            $table->boolean('component_based')->default(false);
            $table->boolean('is_set')->default(false);
            $table->integer('set_count')->default(1);

            // Serialization & Lot Tracking
            $table->boolean('is_serialized')->default(false);
            $table->boolean('track_individual_items')->default(false);
            $table->string('serial_number_format', 100)->nullable();
            $table->integer('serialized_count')->default(0);
            $table->integer('last_serial_number')->default(0);
            $table->boolean('is_lot_based')->default(false);

            // Certification & Hallmarking
            $table->boolean('requires_certificate')->default(false);
            $table->string('certificate_number', 100)->nullable();
            $table->string('certificate_issuer', 100)->nullable();
            $table->date('certificate_date')->nullable();

            // Status
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->boolean('is_featured')->default(false);

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('sku');
            $table->index('category_id');
            $table->index('selling_price');
            $table->index('quantity_in_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
