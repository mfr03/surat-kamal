<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\surat_pengantar;

class SuratExport implements FromCollection, WithHeadings
{
    protected $month;

    // Constructor to accept the month
    public function __construct($month)
    {
        $this->month = $month;
    }

    public function collection()
    {
        return surat_pengantar::whereYear('created_at', '=', substr($this->month, 0, 4))
            ->whereMonth('created_at', '=', substr($this->month, 5, 2))
            ->get();
    }

    // Define the headings for the Excel file
    public function headings(): array
    {
        return [
            'Id',
            'Kode Surat',
            'Nomor',
            'Nomor Surat',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Kewarganegaraan',
            'Pekerjaan',
            'Alamat',
            'NIK',
            'Kartu Keluarga',
            'Tujuan',
            'Tujuan Surat',
            'Berlaku dari',
            'Keterangan1',
            'Keterangan2',
            'Tanda tangan',
            'Dibuat Tanggal',
            'Diperbarui Tanggal',
            
        ];
    }
}
