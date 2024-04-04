<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoInformado extends Model
{
    use HasFactory;
    protected $table = 'pagos_informados';

    protected $fillable = [
        'nombre_deudor',
        'pago_id',
        'dni_deudor',
        'nro_cuota',
        'fecha_de_pago',
        'monto',
        'medio_de_pago',
        'sucursal',
        'hora',
        'cuenta',
        'nombre_tercero',
        'central_de_pago',
        'comprobante',
        'usuario_ultima_modificacion_id',
    ];

    public function pagoId()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class, 'usuario_ultima_modificacion_id');
    }
}
