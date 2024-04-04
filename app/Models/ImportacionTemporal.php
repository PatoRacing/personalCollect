<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportacionTemporal extends Model
{
    protected $table = 'importaciones_temporales';
    
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_doc',
        'nro_doc',
        'cuil',
        'domicilio',
        'localidad',
        'codigo_postal',
        'email',
        'telefono_uno',
        'telefono_dos',
        'telefono_tres',
        'segmento',
        'producto',
        'operacion',
        'fecha_apertura',
        'cant_cuotas',
        'sucursal',
        'fecha_atraso',
        'dias_atraso',
        'fecha_castigo',
        'deuda_total',
        'monto_castigo',
        'deuda_capital',
        'fecha_ult_pago',
        'estado',
        'fecha_asignacion',
        'ciclo',
        'acuerdo',
        'sub_producto',
        'compensatorio',
        'punitivos',
        'cliente_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
