<?php

namespace App\Imports;

use App\Models\AcuerdoTemporal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class AcuerdosTemporalesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

     public function model(array $row)
    {
        return new AcuerdoTemporal([
            'propuesta_id' => $row['propuesta_id'],
            'estado' => $row['estado'],
        ]);
    }

}
