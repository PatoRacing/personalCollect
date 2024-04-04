<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcuerdoTemporal extends Model
{
    use HasFactory;

    protected $table = 'acuerdos_temporales';

    protected $fillable = [
        'propuesta_id',
        'estado',
    ];

    public function propuesta()
    {
        return $this->belongsTo(Propuesta::class, 'propuesta_id');
    }
}
