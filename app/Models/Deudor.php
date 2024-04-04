<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deudor extends Model
{
    protected $table = 'deudors';

    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_doc',
        'nro_doc',
        'cuil',
        'domicilio',
        'localidad',
        'codigo_postal',
        'usuario_ultima_modificacion_id',
    ];

    public function usuarioUltimaModificacion()
    {
        return $this->belongsTo(User::class);
    }

    public function gestionesDeudores()
    {
        return $this->hasMany(GestionesDeudores::class, 'deudor_id');
    }

}
