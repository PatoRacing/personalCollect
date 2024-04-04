<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacionesOperaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'operacion',
        'cliente_id'
    ];

    public function clienteId()
    {
        return $this->belongsTo(Cliente::class);
    }
}
