<?php

namespace App\Imports;

use App\Models\Pago;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PagosRendidosImport implements ToModel, WithHeadingRow
{
    public $procesarPagosRendidos = [];
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //Obtengo los valores de las columnas necesarias
        $pagoId = $row['pago_id']; 
        $montoARendir = $row['monto_a_rendir'];
        $this->procesarPagosRendidos[] = [
            'pago_id' => $pagoId,
            'monto_a_rendir' => $montoARendir,
        ];
    }
}
