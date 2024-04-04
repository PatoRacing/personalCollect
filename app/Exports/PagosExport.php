<?php

namespace App\Exports;

use App\Models\Pago;
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
        $pagosAplicados = Pago::where('estado', 3)->get();
        $data = collect();
        foreach($pagosAplicados as $pagoAplicado) {
            $monto = $pagoAplicado->monto;
            $montoBanco = $monto / (1 + ($pagoAplicado->acuerdo->propuesta->operacionId->productoId->honorarios / 100));
            $montoHonorarios = $monto - $montoBanco;
            $data->push([
                '$' . number_format($montoBanco, 2, ',', '.'),
                '$' . number_format($montoHonorarios, 2, ',', '.'),
                '$' . number_format($monto, 2, ',', '.')
            ]);
            $pagoAplicado->estado = 4;
            $pagoAplicado->save();
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'Monto Cliente',
            'Monto Honorarios',
            'Total'];
    }
    public function columnWidths(): array
    {
        return [
            'A'=> 25, // $ cliente
            'B'=> 25, // $ honorarios
            'C'=> 25, // Total.
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
