<?php

namespace App\Http\Controllers;

use App\Exports\SuratExport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuratPengantarExport;
use App\Exports\SuratUsahaExport;
use App\Models\surat_pengantar;
use App\Models\surat_keterangan_usaha;
use Illuminate\Http\Request;

class SuratController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function exportSuratPengantarByMonth(Request $request)
    {
        // Validate the input
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = $request->input('month'); // Expected format: 'YYYY-MM'

        // Check if data exists for the selected month
        $data = surat_pengantar::whereYear('created_at', '=', substr($month, 0, 4))
            ->whereMonth('created_at', '=', substr($month, 5, 2))
            ->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'No data found for the selected month.');
        }

        $export = new SuratExport($month);
        return Excel::download($export, 'surat_pengantar_' . $month . '.xlsx');
    }
    public function exportSuratUsahaByMonth(Request $request)
    {
        // Validate the input
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = $request->input('month'); // Expected format: 'YYYY-MM'

        // Check if data exists for the selected month
        $data = surat_keterangan_usaha::whereYear('created_at', '=', substr($month, 0, 4))
            ->whereMonth('created_at', '=', substr($month, 5, 2))
            ->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'No data found for the selected month.');
        }

        $export = new SuratUsahaExport($month);
        return Excel::download($export, 'surat_usaha_' . $month . '.xlsx');
    }
}
