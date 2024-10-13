<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Politica extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'producto_id',
        'propiedad_politica_uno',
        'valor_propiedad_uno',
        'propiedad_politica_dos',
        'valor_propiedad_dos',
        'propiedad_politica_tres',
        'valor_propiedad_tres',
        'propiedad_politica_cuatro',
        'valor_propiedad_cuatro',
        'valor_quita',
        'valor_cuota',
        'valor_quita_descuento',
        'valor_cuota_descuento',
        'estado', // 1- Activo - 2-Inactivo
        'usuario_ultima_modificacion_id',        
    ];

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class, 'usuario_ultima_modificacion_id');
    }

    public function productoId()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
