<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_ultima_modificacion_id',
        'operacion_id',
        'porcentaje_quita',
        'anticipo',
        'cantidad_de_cuotas_uno',
        'monto_de_cuotas_uno',
        'cantidad_de_cuotas_dos',
        'monto_de_cuotas_dos',
        'vencimiento',
        'accion',
        'estado',
        'observaciones',
        'cantidad_de_cuotas_tres',
        'monto_de_cuotas_tres',
        'tipo_de_propuesta',//1- Cancelacion 2-Cuota fijas 3-Cuotas con dto 4-Cuota Variables
        'deudor_id',
        'fecha_pago_anticipo',
        'fecha_pago_cuota',
        'monto_ofrecido',
        'total_acp'
    ];

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class, 'usuario_ultima_modificacion_id');
    }

    public function operacionId()
    {
        return $this->belongsTo(Operacion::class, 'operacion_id');
    }

    public function deudorId()
    {
        return $this->belongsTo(Deudor::class, 'deudor_id');
    }
}
