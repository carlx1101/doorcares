<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'space_id',
        'space_name'
    ];
    
    // Define the relationship
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
