<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'space_id',
        'photo_path',
        'remark',
    ];

    // Relationship: Checklist Item belongs to a Checklist
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    // Relationship: Checklist Item belongs to a Space
    public function space()
    {
        return $this->belongsTo(Space::class);
    }
}
