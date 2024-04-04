<?php

namespace App\Imports;

use App\Models\ImportacionTemporalInformacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportacionTemporalInformacionImport implements ToModel, WithHeadingRow
{
    public $excelSinDocumento = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $documento = $row['documento'];
        if(!$documento) {
            $this->excelSinDocumento++;
            return null;
        }
        if(!empty(array_filter($row))) {
            return new ImportacionTemporalInformacion([
                'documento'=>$documento,
                'cuil'=>$row['cuil'],
                'email'=>$row['email'],
                'telefono_uno'=>$row['telefono_uno'],
                'telefono_dos'=>$row['telefono_dos'],
                'telefono_tres'=>$row['telefono_tres'],
            ]);
        }
    }
}
