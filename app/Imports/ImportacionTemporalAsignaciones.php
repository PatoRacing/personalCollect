<?php

namespace App\Imports;

use App\Models\ImportacionTemporalAsignacion;
use App\Models\Operacion;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportacionTemporalAsignaciones implements ToModel, WithHeadingRow
{
    public $excelSinOperacion = 0;
    public $excelSinAgenteAsignado = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //Si no hay operacion que coincidan con nro operacion y cliente_id la instancia se omite
        $operacion = $row['operacion'];
        $cliente_id = $row['cliente_id'];
        $operacionEnBD = Operacion::where('operacion', $operacion)
                        ->where('cliente_id', $cliente_id)
                        ->first();
        if(!$operacionEnBD) {
            $this->excelSinOperacion++;
            return null;
        }

        //Si no hay agente asignado Id la instancia se omite
        $agente_asignado_id = $row['agente_asignado_id'];
        $agenteEnBD = User::find($agente_asignado_id);
        if(!$agenteEnBD) {
            $this->excelSinAgenteAsignado++;
            return null;
        }

        if(!empty(array_filter($row))) {
            return new ImportacionTemporalAsignacion([
                'operacion'=>$operacion,
                'cliente_id'=>$cliente_id,
                'agente_asignado_id'=>$agente_asignado_id,
            ]);
        }
    }
}
