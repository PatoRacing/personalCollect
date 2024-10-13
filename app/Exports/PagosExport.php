<?php

namespace App\Exports;

use App\Models\Pago;
use App\Models\PagoInformado;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PagosExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $pagosAplicadosSinEnviar = Pago::where('estado', 3)->take(20)->get();
        $data = collect();
        foreach($pagosAplicadosSinEnviar as $pagoAplicadoSinEnviar) {
            $informePago = PagoInformado::where('pago_id', $pagoAplicadoSinEnviar->id)->first();
            //Info a exportar
            if($pagoAplicadoSinEnviar->acuerdo->propuesta->deudorId->tipo_doc) {
                $tipoDoc = $pagoAplicadoSinEnviar->acuerdo->propuesta->deudorId->tipo_doc;
            } else {
                $tipoDoc = '-';
            }
            $documento = $pagoAplicadoSinEnviar->acuerdo->propuesta->deudorId->nro_doc;
            $titular = $pagoAplicadoSinEnviar->acuerdo->propuesta->deudorId->nombre;
            $tipoOperacion = $pagoAplicadoSinEnviar->acuerdo->propuesta->operacionId->productoId->nombre;
            $nroOperacion = $pagoAplicadoSinEnviar->acuerdo->propuesta->operacionId->operacion;
            $fechaDePago = $informePago->fecha_de_pago;
            $fechaFormateada = Carbon::parse($fechaDePago)->format('d-m-Y');
            $fechaRendicion =  now()->format('d-m-Y');
            $montoAbonado = $informePago->monto;
            $montoARendir = $montoAbonado / (1 + ($pagoAplicadoSinEnviar->acuerdo->propuesta->operacionId->productoId->honorarios / 100));                
            $cuota = $informePago->nro_cuota;
            $proformaRendicion = '-';
            $honorarios = $montoAbonado - $montoARendir;
            $porcentajeHonorarios = $pagoAplicadoSinEnviar->acuerdo->propuesta->operacionId->productoId->honorarios;
            $pagoId= $pagoAplicadoSinEnviar->id;
            
            $data->push([
                $tipoDoc,
                $documento,
                $titular,
                $tipoOperacion,
                $nroOperacion,
                $fechaFormateada,
                $fechaRendicion,
                '$' . number_format($montoARendir, 2, ',', '.'),
                $cuota,
                $proformaRendicion,
                '$' . number_format($honorarios, 2, ',', '.'),
                $porcentajeHonorarios . '%',
                $pagoId
            ]);
            $pagoAplicadoSinEnviar->estado = 4;
            $pagoAplicadoSinEnviar->save();
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'Tipo Doc.',
            'DNI',
            'Titular',
            'T. de Operación',
            'Nro. Operación',
            'Fecha de Pago',
            'Fecha Rendición',
            'Monto a Rendir',
            'Cuota',
            'Proforma y Rend. CG',
            'Honorarios',
            '% Honorarios',
            'Pago Id',
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A'=> 15, 
            'B'=> 15, 
            'C'=> 25, 
            'D'=> 20, 
            'E'=> 20, 
            'F'=> 20, 
            'G'=> 20, 
            'H'=> 20, 
            'I'=> 20, 
            'J'=> 20, 
            'K'=> 20, 
            'L'=> 20, 
            'M'=> 20, 
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
