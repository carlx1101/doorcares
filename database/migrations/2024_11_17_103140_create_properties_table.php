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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_name');
            $table->string('street');
            $table->string('residential_area')->nullable();
            $table->string('city');
            $table->string('postal_code');
            $table->string('state');
            $table->text('description')->nullable();
            $table->string('tenure');
            $table->string('property_type');
            $table->integer('build_year');
            $table->string('developer_name');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
