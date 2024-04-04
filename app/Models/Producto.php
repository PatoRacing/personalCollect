<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cliente_id',
        'honorarios',
        'comision_cliente',
        'estado', // 1- Activo / 2- Inactivo
        'acepta_cuotas_variables', // 1- Si / 2-No 
        'usuario_ultima_modificacion_id',        
    ];

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class, 'usuario_ultima_modificacion_id');
    }

    public function clienteId()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
