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
        Schema::dropIfExists('locations');
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('location_id');
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->string('location_code', 50)->unique();
            $table->string('location_name', 100);
            $table->enum('location_type', ['store', 'warehouse', 'display_case', 'safe', 'vault', 'counter', 'workshop', 'qc_area', 'quarantine'])->default('store');
            $table->unsignedBigInteger('parent_location_id')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('temperature_controlled')->default(false);
            $table->boolean('humidity_controlled')->default(false);
            $table->enum('security_level', ['low', 'medium', 'high', 'maximum'])->default('medium');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->text('notes')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
