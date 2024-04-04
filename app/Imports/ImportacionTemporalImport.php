<?php

namespace App\Imports;

use App\Models\ImportacionTemporal;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportacionTemporalImport implements ToModel, WithHeadingRow
{
    public $clienteId;
    public $docOmitidos = 0;
    public $operacionesOmitidas = 0;
    public $productoOmitidos = 0;
    
    public function __construct($clienteId)
    {
        $this->clienteId = $clienteId;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        //Si no hay nro_doc la instancia se omite
        $nro_doc = $row['nro_doc'];
        if(!$nro_doc) {
            $this->docOmitidos++;
            return null;
        }

        //Si no hay operacion la instancia se omite
        $operacion = $row['operacion'];
        if(!$operacion) {
            $this->operacionesOmitidas++;
            return null;
        }

        //Si no hay producto la instancia se omite
        $producto = $row['producto'];
        if(!$producto) {
            $this->productoOmitidos++;
            return null;
        }

        return new ImportacionTemporal([
            'nombre'=>$row['nombre'],
            'tipo_doc'=>$row['tipo_doc'],
            'nro_doc'=>$nro_doc,
            'domicilio'=>$row['domicilio'],
            'localidad'=>$row['localidad'],
            'codigo_postal'=>$row['codigo_postal'],
            'telefono'=>$row['telefono'],
            'segmento'=>$row['segmento'],
            'producto'=>$row['producto'],
            'operacion'=>$operacion,
            'fecha_atraso' => $this->formatearFecha($row['fecha_atraso']),
            'dias_atraso'=>$row['dias_atraso'],
            'fecha_apertura' => $this->formatearFecha($row['fecha_apertura']),
            'cant_cuotas'=>$row['cant_cuotas'],
            'sucursal'=>$row['sucursal'],
            'deuda_total'=>$row['deuda_total'],
            'deuda_capital'=>$row['deuda_capital'],
            'estado'=>$row['estado'],
            'fecha_asignacion' => $this->formatearFecha($row['fecha_asignacion']),
            'ciclo'=>$row['ciclo'],
            'fecha_ult_pago' => $this->formatearFecha($row['fecha_ult_pago']),
            'cliente_id'=>$this->clienteId
        ]);
    }

    private function formatearFecha($value)
    {
        try {
            if ($value === null || !is_numeric($value)) {
                return null;
            }
            $dateTimeObject = Date::excelToDateTimeObject($value);
            return $dateTimeObject->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
