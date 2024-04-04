<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'acuerdo_id',
        'concepto',
        'monto',
        'vencimiento',
        'estado', //1- Vigente 2-Informado 3-Aplicado 4-Enviado 5-Rendido 6-Incumplido
        'comprobante',
        'usuario_ultima_modificacion_id',
        'nro_cuota'
    ];

    public function acuerdo()
    {
        return $this->belongsTo(Acuerdo::class, 'acuerdo_id');
    }

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class, 'usuario_ultima_modificacion_id');
    }
}
