<?php

namespace App\Http\Controllers;

use App\Models\surat_keterangan_kematian;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuratKematianExport;
use Illuminate\Http\Request;

class SuratKematianController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function exportSuratKematianByMonth(Request $request)
    {
        // Validate the input
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = $request->input('month'); // Expected format: 'YYYY-MM'

        // You can also add validation to check if any data exists before exporting
        $data = surat_keterangan_kematian::whereYear('created_at', '=', substr($month, 0, 4))
            ->whereMonth('created_at', '=', substr($month, 5, 2))
            ->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'No data found for the selected month.');
        }

        $export = new SuratKematianExport($month);
        return Excel::download($export, 'surat_kematian_' . $month . '.xlsx');
    }
}
