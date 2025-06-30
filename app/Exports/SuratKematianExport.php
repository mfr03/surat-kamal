<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\surat_keterangan_kematian;

class SuratKematianExport implements FromCollection, WithHeadings
{
    protected $month;

    // Constructor to accept the month
    public function __construct($month)
    {
        $this->month = $month;
    }

    public function collection()
    {
        return surat_keterangan_kematian::whereYear('created_at', '=', substr($this->month, 0, 4))
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
            'NIK',
            'Nama Jenazah',
            'Jenis Kelamin',
            'Tanggal Lahir Jenazah',
            'Umur Jenazah',
            'Tempat Kelahiran',
            'Agama',
            'Pekerjaan',
            'Alamat Jenazah',
            'Desa/Kelurahan Jenazah',
            'Kecamatan Jenazah',
            'Kabupaten/Kota Jenazah',
            'Provinsi Jenazah',
            'Anak Ke',
            'Tanggal Kematian Jenazah',
            'Pukul',
            'Sebab Kematian',
            'Tempat Kematian',
            'Yang Menerangkan',
            'NIK Ayah',
            'Nama Ayah',
            'Tanggal Lahir Ayah',
            'Umur Ayah',
            'Pekerjaan Ayah',
            'Alamat Ayah',
            'NIK Ibu',
            'Nama Ibu',
            'Tanggal Lahir Ibu',
            'Umur Ibu',
            'Pekerjaan Ibu',
            'Alamat Ibu',
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
            'created at',
            'updated at',
        ];
    }
}
