<?php

namespace App\Imports;

use App\Models\ImportacionTemporalPago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
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
        //Si no hay monto la instancia se omite
        $monto = $row['monto'];
        if(!$monto) {
            return null;
        }
        //Si no hay cuenta la instancia se omite
        $cuenta = $row['cuenta'];
        if(!$cuenta) {
            return null;
        }
        //Si no hay sucursal la instancia se omite
        $sucursal = $row['sucursal'];
        if(!$sucursal) {
            return null;
        }
        //Si no hay fecha la instancia se omite
        $fecha = $row['fecha'];
        if ($fecha) {
            $fechaFormateada = Carbon::createFromFormat('Y-m-d', '1900-01-01')
                            ->addDays($fecha - 1) 
                            ->toDateString(); 
        } else {
            return null;
        }
        return new ImportacionTemporalPago([
            'cuil'=>$cuil,
            'monto'=>$monto,
            'cuenta'=>$cuenta,
            'sucursal'=>$sucursal,
            'fecha' => $fechaFormateada
        ]);
    }
}
