<?php

namespace App\Imports;

use App\Models\ImportacionTemporalPago;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportacionTemporalPagoImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //Si no hay cuil la instancia se omite
        $cuil = $row['cuil'];
        if(!$cuil) {
            return null;
        }

        //Si no hay cuil la instancia se omite
        $monto = $row['monto'];
        if(!$monto) {
            return null;
        }

        return new ImportacionTemporalPago([
            'cuil'=>$cuil,
            'monto'=>$monto
        ]);
    }
}
