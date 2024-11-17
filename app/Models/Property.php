<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_name',
        'street',
        'residential_area',
        'city',
        'postal_code',
        'state',
        'description',
        'tenure',
        'property_type',
        'build_year',
        'developer_name',
        'image_url',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
