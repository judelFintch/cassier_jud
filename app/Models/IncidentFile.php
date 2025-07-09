<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'incident_id',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
