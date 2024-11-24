<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'unit_id',
    ];

    // Relationship: Checklist belongs to a Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Relationship: Checklist belongs to a Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Relationship: Checklist has many Checklist Items
    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }
}
