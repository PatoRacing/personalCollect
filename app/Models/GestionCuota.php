<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionCuota extends Model
{
    use HasFactory;
    protected $table = 'gestiones_cuotas';

    protected $fillable = [
        'pago_id',
        'fecha_de_pago',
        'monto_abonado',
        'medio_de_pago',
        'sucursal',
        'hora',
        'cuenta',
        'nombre_tercero',
        'central_de_pago',
        'comprobante',
        'usuario_informador_id',
        'fecha_informe',
        'situacion',
        // 1-Informado
        // 2-Rechazado
        // 3-Aplicado
        // 4-Rendido
        // 5-Incompleto
        // 6-Completo
        // 7-Procesado
        // 8-Para Rendir
        // 9-Rendido a Cuenta
        // 10-Devuelto
        // 11-Previo 
        'usuario_ultima_modificacion_id',
        'monto_a_rendir',
        'rendicionCG',
        'proforma',
        'usuario_rendidor_id',
        'fecha_de_rendicion'

    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }

    public function usuarioInformador()
    {
        return $this->belongsTo(User::class, 'usuario_informador_id');
    }

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class, 'usuario_ultima_modificacion_id');
    }
    public function usuarioRendidor()
    {
        return $this->belongsTo(User::class, 'usuario_rendidor_id');
    }
}
