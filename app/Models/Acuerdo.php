<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acuerdo extends Model
{
    use HasFactory;

    protected $fillable = [
        'propuesta_id',
        'usuario_ultima_modificacion_id',
        'propuesta_de_pago_pdf',
        'estado',
        'responsable'
    ];

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class, 'usuario_ultima_modificacion_id');
    }

    public function propuesta()
    {
        return $this->belongsTo(Propuesta::class, 'propuesta_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable');
    }
}
