<?php

namespace App\Imports;

use App\Models\ImportacionTemporalDeudor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportacionTemporalDeudoresImport implements ToModel, WithHeadingRow
{
    public $excelSinDocumento = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //Si no hay nro_doc la instancia se omite
        $documento = $row['nro_doc'];
        if(!$documento) {
            $this->excelSinDocumento++;
            return null;
        }

        if(!empty(array_filter($row))) {
            return new ImportacionTemporalDeudor([
                'nombre'=>$row['nombre'],
                'tipo_doc'=>$row['tipo_doc'],
                'nro_doc'=>$documento,
                'cuil'=>$row['cuil'],
                'domicilio'=>$row['domicilio'],
                'localidad'=>$row['localidad'],
                'codigo_postal'=>$row['codigo_postal'],
            ]);
        }
    }
}
