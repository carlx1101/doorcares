<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'tenure',
        'block',
        'level',
        'unit',
        'layout_type',
        'bedrooms',
        'bathrooms',
        'car_parks',
        'balcony',
        'cooker_type',
        'bathtub',
        'built_up_area',
        'land_area',
        'type',
        'price',
        'furnishing_status',
        'description'
    ];

    // Relationship with Property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
