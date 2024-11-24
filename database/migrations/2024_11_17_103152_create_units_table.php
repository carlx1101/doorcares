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
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->string('tenure')->nullable();
            $table->string('block')->nullable();
            $table->string('level')->nullable();
            $table->string('unit')->nullable();
            $table->string('layout_type')->nullable();
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('car_parks');
            $table->string('balcony')->nullable();
            $table->string('cooker_type')->nullable();
            $table->string('bathtub')->nullable();
            $table->integer('built_up_area');
            $table->integer('land_area');
            $table->string('type');
            $table->decimal('price', 10, 2);
            $table->string('furnishing_status')->nullable();
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
    
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
