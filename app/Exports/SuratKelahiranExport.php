<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\surat_keterangan_kelahiran;

class SuratKelahiranExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    protected $month;

    // Constructor to accept the month
    public function __construct($month)
    {
        $this->month = $month;
    }

    public function collection()
    {
        return surat_keterangan_kelahiran::whereYear('created_at', '=', substr($this->month, 0, 4))
            ->whereMonth('created_at', '=', substr($this->month, 5, 2))
            ->get();
    }

    // Define the headings for the Excel file
    public function headings(): array
    {
        return [
            'Id',
            'Nama Kepala Keluarga',
            'Nomor Kepala Keluarga',
            'Nama Bayi',
            'Jenis Kelamin Bayi',
            'Tempat Dilahirkan',
            'Tempat Kelahiran',
            'Tanggal Lahir Bayi',
            'Pukul Lahir',
            'Jenis Kelahiran',
            'Kelahiran ke',
            'Penolong Kelahiran',
            'Berat Bayi',
            'Panjang Bayi',
            'NIK Ayah',
            'Nama Ayah',
            'Tanggal Lahir Ayah',
            'Umur Ayah',
            'Pekerjaan Ayah',
            'Alamat Ayah',
            'Kewarganegaraan Ayah',
            'Kebangsaan Ayah',
            'NIK Ibu',
            'Nama Ibu',
            'Tanggal Lahir Ibu',
            'Umur Ibu',
            'Pekerjaan Ibu',
            'Alamat Ibu',
            'Kewarganegaraan Ibu',
            'Kebangsaan Ibu',
            'Tanggal Kawin',
            'NIK Pelapor',
            'Nama Pelapor',
            'Umur Pelapor',
            'Jenis Kelamin Pelapor',
            'Pekerjaan Pelapor',
            'Alamat Pelapor',
            'NIK Saksi 1',
            'Nama Saksi 1',
            'Umur Saksi 1',
            'Pekerjaan Saksi 1',
            'Alamat Saksi 1',
            'NIK Saksi 2',
            'Nama Saksi 2',
            'Umur Saksi 2',
            'Pekerjaan Saksi 2',
            'Alamat Saksi 2',
            
            'Desa/Kelurahan Ibu',
            'Kabupaten/Kota Ibu',
            'Kecamatan Ibu',
            'Provinsi Ibu',
            'Desa/Kelurahan Ayah',
            'Kabupaten/Kota Ayah',
            'Kecamatan Ayah',
            'Provinsi Ayah',
            'Desa/Kelurahan Pelapor',
            'Kabupaten/Kota Pelapor',
            'Kecamatan Pelapor',
            'Provinsi Pelapor',
            'Desa/Kelurahan Saksi 1',
            'Kabupaten/Kota Saksi 1',
            'Kecamatan Saksi 1',
            'Provinsi Saksi 1',
            'Desa/Kelurahan Saksi 2',
            'Kabupaten/Kota Saksi 2',
            'Kecamatan Saksi 2',
            'Provinsi Saksi 2',
            'Kode Wilayah',
            'Jabatan',
            'Nomor Surat',
            'Created At',
            'Updated At',
        ];
    }

    // Format the columns to avoid scientific notation
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT, // Nomor Kepala Keluarga
            'P' => NumberFormat::FORMAT_TEXT, // NIK Ayah
            'X' => NumberFormat::FORMAT_TEXT, // NIK Ibu
            'AB' => NumberFormat::FORMAT_TEXT, // NIK Pelapor
            'AF' => NumberFormat::FORMAT_TEXT, // NIK Saksi 1
            'AJ' => NumberFormat::FORMAT_TEXT, // NIK Saksi 2
            // Add more columns here if needed
        ];
    }
}
