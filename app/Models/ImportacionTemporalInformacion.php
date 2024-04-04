<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportacionTemporalInformacion extends Model
{
    use HasFactory;

    protected $table = 'importaciones_temporales_informacion';

    protected $fillable = [
        'documento',
        'cuil',
        'email',
        'telefono_uno',
        'telefono_dos',
        'telefono_tres',
    ];
}
