<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'deudor_id',
        'tipo',
        'contacto',
        'numero',
        'estado', // 1-Verificado 2-Sin verificar
        'email',
        'usuario_ultima_modificacion_id',
    ];

    public function deudorId()
    {
        return $this->belongsTo(Deudor::class, 'deudor_id');
    }

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class, 'usuario_ultima_modificacion_id');
    }
}
