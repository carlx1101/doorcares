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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('tenure');
            $table->string('block');
            $table->string('level');
            $table->string('unit');
            $table->string('layout_type');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('car_parks');
            $table->string('balcony');
            $table->string('cooker_type');
            $table->string('bathtub');
            $table->integer('built_up_area');
            $table->integer('land_area');
            $table->string('type');
            $table->decimal('price', 10, 2);
            $table->string('furnishing_status');
            $table->string('description');
            $table->string('image_url')->nullable();
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
