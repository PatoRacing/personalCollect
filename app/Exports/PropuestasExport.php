<?php

namespace App\Exports;

use App\Models\Propuesta;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PropuestasExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $propuestas = Propuesta::where('estado', 'Propuesta de Pago')->get();
        $data = collect();
        // Iterar sobre cada propuesta y agregar los valores a la colección
        foreach ($propuestas as $propuesta) 
        {
            $tipo_doc = '';
            if($propuesta->deudorId->tipo_doc) {
                $tipo_doc = $propuesta->deudorId->tipo_doc;
            } else {
                $tipo_doc = "-";
            }
            $segmento = '';
            if($propuesta->operacionId->segmento) {
                $segmento = $propuesta->operacionId->segmento;
            } else {
                $segmento = "-";
            }
            $tipo_de_propuesta = "";
            if($propuesta->tipo_de_propuesta == 1) {
                $tipo_de_propuesta = "Cancelación";
            } elseif($propuesta->tipo_de_propuesta == 2) {
                $tipo_de_propuesta = "Cuotas Fijas";
            } elseif($propuesta->tipo_de_propuesta == 3) {
                $tipo_de_propuesta = "Cuotas con Descuento";
            } else {
                $tipo_de_propuesta = "Cuotas Variables";
            }
            $porcentaje_quita = '';
            if($propuesta->porcentaje_quita) {
                $porcentaje_quita = number_format(floatval($propuesta->porcentaje_quita), 2, ',', '.') . '%';
            } else {
                $porcentaje_quita = '0,00%';
            }
            $anticipo = '';
            if($propuesta->anticipo) {
                $anticipo = '$' . number_format(floatval($propuesta->anticipo), 2, ',', '.');
            } else {
                $anticipo = '-';
            }
            $fecha_pago_anticipo = '';
            if($propuesta->fecha_pago_anticipo) {
                $fecha_pago_anticipo = Carbon::parse($propuesta->fecha_pago_anticipo)->format('d/m/Y');
            } else {
                $fecha_pago_anticipo = '-';
            }
            $cantidad_de_cuotas_uno = '';
            if($propuesta->cantidad_de_cuotas_uno) {
                $cantidad_de_cuotas_uno = $propuesta->cantidad_de_cuotas_uno;
            } else {
                $cantidad_de_cuotas_uno = "-";
            }
            $monto_de_cuotas_uno = '';
            if($propuesta->monto_de_cuotas_uno) {
                $monto_de_cuotas_uno = "$" . number_format(floatval($propuesta->monto_de_cuotas_uno), 2, ',', '.');
            } else {
                $monto_de_cuotas_uno = "-";
            }
            $cantidad_de_cuotas_dos = '';
            if($propuesta->cantidad_de_cuotas_dos) {
                $cantidad_de_cuotas_dos = $propuesta->cantidad_de_cuotas_dos;
            } else {
                $cantidad_de_cuotas_dos = "-";
            }
            $monto_de_cuotas_dos = '';
            if($propuesta->monto_de_cuotas_dos) {
                $monto_de_cuotas_dos = "$" . number_format(floatval($propuesta->monto_de_cuotas_dos), 2, ',', '.');
            } else {
                $monto_de_cuotas_dos = "-";
            }
            $cantidad_de_cuotas_tres = '';
            if($propuesta->cantidad_de_cuotas_tres) {
                $cantidad_de_cuotas_tres = $propuesta->cantidad_de_cuotas_tres;
            } else {
                $cantidad_de_cuotas_tre = "-";
            }
            $monto_de_cuotas_tres = '';
            if($propuesta->monto_de_cuotas_tres) {
                $monto_de_cuotas_tres = "$" . number_format(floatval($propuesta->monto_de_cuotas_tres), 2, ',', '.');
            } else {
                $monto_de_cuotas_tres = "-";
            }
            $fecha_pago_cuota = '';
            if($propuesta->fecha_pago_cuota) {
                $fecha_pago_cuota = Carbon::parse($propuesta->fecha_pago_cuota)->format('d/m/Y');
            } else {
                $fecha_pago_cuota = '-';
            }
            $fechaACP =  Carbon::now()->format('d/m/Y');
            if ($propuesta->tipo_de_propuesta == 1) {
                $fechaFinalizacionACP = Carbon::createFromTimestamp(strtotime($propuesta->fecha_pago_cuota))
                ->format('d/m/Y');
            } else {
                $fechaPagoCuota = Carbon::createFromTimestamp(strtotime($propuesta->fecha_pago_cuota));
                $fechaFinalizacionACP = $fechaPagoCuota
                    ->addDays($propuesta->cantidad_de_cuotas_uno * 30)
                    ->addDays($propuesta->cantidad_de_cuotas_dos * 30)
                    ->addDays($propuesta->cantidad_de_cuotas_tres * 30)
                    ->format('d/m/Y');
            }
            $data->push([
                $propuesta->operacionId->clienteId->nombre,
                ucwords(strtolower($propuesta->deudorId->nombre)),
                $tipo_doc,
                $propuesta->deudorId->nro_doc,
                $propuesta->operacionId->operacion,
                $propuesta->operacionId->productoId->nombre,
                $segmento,
                '$' . number_format($propuesta->operacionId->deuda_capital, 2, ',', '.'),
                $tipo_de_propuesta,
                $porcentaje_quita,
                '$' . number_format(floatval($propuesta->monto_ofrecido), 2, ',', '.'),
                '$' . number_format(floatval($propuesta->total_acp), 2, ',', '.'),
                '$' . number_format(floatval($propuesta->honorarios), 2, ',', '.'),
                $anticipo,
                $fecha_pago_anticipo,
                $cantidad_de_cuotas_uno,
                $monto_de_cuotas_uno,
                $cantidad_de_cuotas_dos,
                $monto_de_cuotas_dos,
                $cantidad_de_cuotas_tres,
                $monto_de_cuotas_tres,
                $fecha_pago_cuota,
                $fechaFinalizacionACP,
                $fechaACP,
                $propuesta->id,
                1
            ]);
        }
        DB::beginTransaction();
        try {
            foreach ($propuestas as $propuesta) {
                $propuesta->estado = 'Enviada';
                $propuesta->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; 
        }
        return $data;
    }
    
    public function headings(): array
    {
        return [
            'Cliente',
            'Deudor',
            'Tipo Doc.',
            'Nro. Doc.',
            'Operación',
            'Producto',
            'Segmento',
            'Deuda Capital',
            'Tipo Propuesta',
            '% Quita',
            '$ a Pagar',
            '$ ACP',
            '$ Honorarios',
            '$ Anticipo',
            'Fecha Pago Anticipo',
            'Cant. Ctas. (1)',
            'Monto Ctas. (1)',
            'Cant. Ctas. (2)',
            'Monto Ctas. (2)',
            'Cant. Ctas. (3)',
            'Monto Ctas. (3)',
            'Fecha Pago Cta.',
            'Fecha Finalización',
            'Fecha de Envío',
            'Propuesta ID',
            'Estado',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A'=> 18, // Cliente
            'B'=> 35, // Deudor
            'C'=> 9, // Tipo Doc.
            'D'=> 13, //Nro. Doc.
            'E'=> 13, // Operación
            'F'=> 25, // Producto
            'G'=> 28, // Segmento
            'H'=> 15, // Deuda Capital
            'I'=> 13, // Tipo Propuesta
            'J'=> 10, // % Quita
            'K'=> 15, // $ a Pagar
            'L'=> 15, // $ ACP
            'M'=> 15, //$ Honorarios
            'N'=> 15, //$ Anticipo
            'O'=> 17, // Fecha Pago Anticipo
            'P'=> 15, // Cant. Ctas. (1)
            'Q'=> 15, // Monto Ctas. (1)
            'R'=> 15, // Cant. Ctas. (2)
            'S'=> 15, // Monto Ctas. (2)
            'T'=> 15, // Cant. Ctas. (3)
            'U'=> 15, // Monto Ctas. (3)
            'V'=> 17, // Fecha Pago Cta.
            'W'=> 17, // Fecha Finalización
            'X'=> 17, // Fecha de Envío
            'Y'=> 17,
            'Z'=> 8, // Estado
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $numFilas = $sheet->getHighestRow();

        // Establecer el estilo de la primera fila (encabezado)
        $sheet->getStyle('1')->applyFromArray([
            'font' => ['bold' => true, 'name' => 'Calibri', 'size' => 10, 'color' => ['rgb' => '000000']], 
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'CCCCCC'],
            ],
        ]);

        // Establecer la altura de fila para todas las filas
        $sheet->getDefaultRowDimension()->setRowHeight(40);

        // Aplicar estilo a las filas restantes
        for ($fila = 2; $fila <= $numFilas; $fila++) {
            $sheet->getStyle($fila)->applyFromArray([
                'font' => ['name' => 'Calibri', 'size' => 10, 'color' => ['rgb' => '000000']],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ]);
        }

        return [];
    }
}
