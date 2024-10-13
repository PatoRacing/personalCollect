<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportacionTemporalAsignacion extends Model
{
    use HasFactory;

    protected $table = 'importaciones_temporales_asignaciones';

    protected $fillable = [
        'operacion',
        'cliente_id',
        'agente_asignado_id',
    ];

    public function clienteId()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function agenteAsignadoId()
    {
        return $this->belongsTo(User::class, 'agente_asignado_id');
    }
}
