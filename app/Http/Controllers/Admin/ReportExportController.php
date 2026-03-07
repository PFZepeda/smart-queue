<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TurnsReportExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportExportController extends Controller
{
    public function export()
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $filename = 'reporte_' . now()->format('d-m-Y') . '.xlsx';

        return Excel::download(new TurnsReportExport, $filename);
    }
}
