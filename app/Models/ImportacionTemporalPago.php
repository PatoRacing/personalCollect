<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportacionTemporalPago extends Model
{
    use HasFactory;

    protected $table = 'importaciones_temporales_pagos';
    protected $fillable = [
        'monto',
        'cuil'
    ];
}
