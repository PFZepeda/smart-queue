<?php

namespace App\Exports;

use App\Models\Turn;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TurnsReportExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Reporte de Turnos';
    }

    public function headings(): array
    {
        return [
            'Métrica',
            'Valor',
        ];
    }

    public function array(): array
    {
        $totalGenerados = Turn::count();
        $totalExpirados = Turn::where('status', 'expired')->count();
        $totalCancelados = Turn::where('status', 'cancelled')->count();
        $totalFinalizados = Turn::where('status', 'completed')->count();
        $atendidosExito = $totalFinalizados;
        $promedioExito = $totalGenerados > 0
            ? round(($atendidosExito / $totalGenerados) * 100, 1)
            : 0;

        return [
            ['Total de turnos generados', $totalGenerados],
            ['Total de turnos expirados', $totalExpirados],
            ['Total de turnos cancelados', $totalCancelados],
            ['Total de turnos finalizados', $totalFinalizados],
            ['Promedio de personas atendidas con éxito (%)', $promedioExito],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getColumnDimension('A')->setWidth(45);
        $sheet->getColumnDimension('B')->setWidth(15);

        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
