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
        Schema::create('websettings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('site_url');
            $table->string('contact_person', 100);
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('sales_email', 150)->nullable();
            $table->text('address');
            $table->string('logo', 100)->nullable();
            $table->string('fav_icon', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websettings');
    }
};
