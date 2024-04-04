<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportacionTemporalDeudor extends Model
{
    use HasFactory;

    protected $table = 'importaciones_temporales_deudores';

    protected $fillable = [
        'nombre',
        'tipo_doc',
        'nro_doc',
        'cuil',
        'domicilio',
        'localidad',
        'codigo_postal',
    ];
}
