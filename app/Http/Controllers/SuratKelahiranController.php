<?php

namespace App\Http\Controllers;

use App\Models\surat_keterangan_kelahiran;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuratKelahiranExport;
use Illuminate\Http\Request;

class SuratKelahiranController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function exportSuratKelahiranByMonth(Request $request)
    {
        // Validate the input
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = $request->input('month'); // Expected format: 'YYYY-MM'

        // Check if data exists for the selected month
        $data = surat_keterangan_kelahiran::whereYear('created_at', '=', substr($month, 0, 4))
            ->whereMonth('created_at', '=', substr($month, 5, 2))
            ->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'No data found for the selected month.');
        }

        $export = new SuratKelahiranExport($month);
        return Excel::download($export, 'surat_kelahiran_' . $month . '.xlsx');
    }
}
