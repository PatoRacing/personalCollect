<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportacionTemporalOperacion extends Model
{
    protected $table = 'importaciones_temporales_operaciones';

    use HasFactory;

    protected $fillable = [
        'segmento',
        'producto',
        'operacion',
        'nro_doc',
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
        'cliente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
