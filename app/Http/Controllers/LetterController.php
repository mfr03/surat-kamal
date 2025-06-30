<?php
namespace App\Http\Controllers;

use App\Models\surat_keterangan_kelahiran;
use App\Models\surat_keterangan_kematian;
use App\Models\surat_keterangan_usaha;
use App\Models\surat_pengantar;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
setlocale(LC_TIME, 'id_ID');
Carbon::setLocale('id');
Carbon::now()->isoFormat('dddd, D MMMM YYYY');



class LetterController extends Controller
{
    public function downloadSuratUsaha($id)
    {
        $surat = surat_keterangan_usaha::findOrFail($id);
        $data = [];
        // Surat Keterangan Usaha
        $template = 'sku';
        $data = [
            'nomor' => $surat->letter_number,
            'nama' => $surat->name,
            'tempat_tinggal' => $surat->address,
            'nik' => $surat->id_number,
            'jenis_kelamin' => $surat -> jenis_kelamin,
            'ibu_kandung' => $surat->nama_ibu_kandung,
            'agama' => $surat->religion,
            'alasan' => $surat->remarks,
            'nomor_hp' => $surat->nomor_hp,
            'domisili' => $surat->domisili,
            'selama' => $surat->selama,
            'tanggal' => now()->translatedFormat('d F Y'),
            'jabatan' => $surat->jabatan, 

            'kepala_desa' => $surat->jabatan == 'kepala_desa' ? 'Widodo' : null,
            'sekdes' => $surat->jabatan == 'sekdes' ? 'Suwandi' : null,
            'kaur_tu' => $surat->jabatan == 'kaur_tu' ? 'Subandi' : null,
            'nama_pejabat' => $surat->jabatan == 'kepala_desa' ? 'Widodo' :
                                ($surat->jabatan == 'sekdes' ? 'Suwandi' :
                                ($surat->jabatan == 'kaur_tu' ? 'Subandi' : null)),

            'jalan_desa' => 'Alamat: Jl. Raya Bulu - Sanggang Km 2.5 No. Telp. -Kode Pos. 57563',
            'desa' => 'Kamal',
            'kecamatan' => 'Bulu',
            'kabupaten' => 'Sukoharjo',
            
        ];
        
        $uppercaseData = array_map('strtoupper', $data);
    
        $pdf = PDF::loadView('sku', $uppercaseData);
    
        $formattedNomor = str_replace('/', '-', $data['nomor']);
        $filename = preg_replace('/[\/\\\:\*\?"<>\|]/', '', $formattedNomor) . '.pdf';
    
        return $pdf->download($filename);
    }
    public function downloadSuratPengantar($id)
    {
        $surat = surat_pengantar::findOrFail($id);
        $data = [];
        // Surat Pengantar
        $template = 'surat_pengantar';
        $dateOfBirth = Carbon::parse($surat->date_of_birth);
        $data = [
            'nomor' => $surat->letter_number,
            'nama' => $surat->name,
            'tempat_tanggal_lahir' => $surat->place_of_birth . ', ' . $dateOfBirth->translatedFormat('d F Y'),
            'kewarganegaraan' => $surat->nationality,
            'agama' => $surat->religion,
            'pekerjaan' => $surat->job,
            'tempat_tinggal' => $surat->address,
            'kk' => $surat->kartu_keluarga,
            'nik' => $surat->id_number,
            'keperluan' => $surat->purpose,
            'berlaku_mulai' => Carbon::parse($surat->valid_from)->translatedFormat('d F Y'),
            'berlaku_sampai' => Carbon::parse($surat->valid_from)->addMonth()->translatedFormat('d F Y'),
            'keterangan_lain' => $surat->remarks,
            'tanggal' => now()->translatedFormat('d F Y'),
            'jalan_desa' => 'Alamat: Jl. Raya Bulu - Sanggang Km 2.5 No. Telp. -Kode Pos. 57563',
            'desa' => 'Kamal',
            'kecamatan' => 'Bulu',
            'kabupaten' => 'Sukoharjo',

            'jabatan' => $surat->jabatan, 

            'nama_pejabat' => $surat->jabatan == 'kepala_desa' ? 'Widodo' :
                                ($surat->jabatan == 'sekdes' ? 'Suwandi' :
                                ($surat->jabatan == 'kaur_tu' ? 'Subandi' : null)),

        ];
        // } elseif ($surat->jenis_id == 2) {
        //     // Surat Keterangan Usaha
        //     $template = 'sku';
        //     $dateOfBirth = Carbon::parse($surat->date_of_birth);
        //     $data = [
        //         'nomor' => $surat->letter_number,
        //         'nama' => $surat->name,
        //         'tempat_tinggal' => $surat->address,
        //         'nik' => $surat->id_number,
        //         'jenis_kelamin' => $surat -> jenis_kelamin,
        //         'ibu_kandung' => $surat->nama_ibu_kandung,
        //         'agama' => $surat->religion,
        //         'alasan' => $surat->remarks,
        //         'nomor_hp' => $surat->nomor_hp,
        //         'domisili' => $surat->domisili,
        //         'selama' => $surat->selama,
        //         'tanggal' => now()->translatedFormat('d F Y'),

        //         'jenis_surat' => 'SKU',

        //         'jabatan' => $surat->jabatan, 

        //         'kepala_desa' => $surat->jabatan == 'kepala_desa' ? 'Widodo' : null,
        //         'sekdes' => $surat->jabatan == 'sekdes' ? 'Suwandi' : null,
        //         'kaur_tu' => $surat->jabatan == 'kaur_tu' ? 'Subandi' : null,
        //         'nama_pejabat' => $surat->jabatan == 'kepala_desa' ? 'Widodo' :
        //                             ($surat->jabatan == 'sekdes' ? 'Suwandi' :
        //                             ($surat->jabatan == 'kaur_tu' ? 'Subandi' : null)),
        //         'jalan_desa' => 'Alamat: Jl. Raya Bulu - Sanggang Km 2.5 No. Telp. -Kode Pos. 57563',
        //         'desa' => 'Kamal',
        //         'kecamatan' => 'Bulu',
        //         'kabupaten' => 'Sukoharjo',
                
        //     ];
        // }
    
        $uppercaseData = array_map('strtoupper', $data);
    
        $pdf = PDF::loadView('surat_pengantar', $uppercaseData);
    
        $formattedNomor = str_replace('/', '-', $data['nomor']);
        $filename = preg_replace('/[\/\\\:\*\?"<>\|]/', '', $formattedNomor) . '.pdf';
    
        return $pdf->download($filename);
    }
    


// kelahiran
    // 474.1/no/bulan/tahun

// kematian 
// 474.3/no/bulan/tahun


    private function prepareSuratData($surat)
    {
        // Format the dates
        $tanggal_lahir_ibu_formatted = Carbon::parse($surat->tanggal_lahir_ibu)->translatedFormat('l, d F Y');
        $tanggal_lahir_ayah_formatted = Carbon::parse($surat->tanggal_lahir_ayah)->translatedFormat('l, d F Y');
        $tgl_kawin_formatted = Carbon::parse($surat->tgl_kawin)->translatedFormat('l, d F Y');
        $tanggal_lahir_formatted = Carbon::parse($surat->tanggal_lahir_bayi)->translatedFormat('l, d F Y');

        // Prepare the data array
        $data = [
            'id' => $surat->id,
            'nama' => strtoupper($surat->nama),
            'nama_kepala_keluarga' => strtoupper($surat->nama_kepala_keluarga),
            'nomor_kepala_keluarga' => strtoupper($surat->nomor_kepala_keluarga),
            'nama_bayi' => strtoupper($surat->nama_bayi),
            'jenis_kelamin_bayi' => strtoupper($surat->jenis_kelamin_bayi),
            'tempat_dilahirkan' => strtoupper($surat->tempat_dilahirkan),
            'tempat_kelahiran' => strtoupper($surat->tempat_kelahiran),
            'tanggal_lahir_bayi' => strtoupper($tanggal_lahir_formatted),
            'pukul_lahir' => strtoupper(Carbon::parse($surat->pukul_lahir)->format('H:i') . ' WIB'),
            'jenis_kelahiran' => strtoupper($surat->jenis_kelahiran),
            'penolong_kelahiran' => strtoupper($surat->penolong_kelahiran),
            'berat_bayi' => strtoupper($surat->berat_bayi),
            'panjang_bayi' => strtoupper($surat->panjang_bayi),
            'nik_ayah' => strtoupper($surat->nik_ayah),
            'nama_ayah' => strtoupper($surat->nama_ayah),
            'tanggal_lahir_ayah' => strtoupper($tanggal_lahir_ayah_formatted),
            'umur_ayah' => strtoupper($surat->umur_ayah),
            'pekerjaan_ayah' => strtoupper($surat->pekerjaan_ayah),
            'alamat_ayah' => strtoupper($surat->alamat_ayah),
            'nik_ibu' => strtoupper($surat->nik_ibu),
            'nama_ibu' => strtoupper($surat->nama_ibu),
            'tanggal_lahir_ibu' => strtoupper($tanggal_lahir_ibu_formatted),
            'umur_ibu' => strtoupper($surat->umur_ibu),
            'pekerjaan_ibu' => strtoupper($surat->pekerjaan_ibu),
            'alamat_ibu' => strtoupper($surat->alamat_ibu),
            'nik_pelapor' => strtoupper($surat->nik_pelapor),
            'nama_pelapor' => strtoupper($surat->nama_pelapor),
            'umur_pelapor' => strtoupper($surat->umur_pelapor),
            'jenis_kelamin_pelapor' => strtoupper($surat->jenis_kelamin_pelapor),
            'pekerjaan_pelapor' => strtoupper($surat->pekerjaan_pelapor),
            'alamat_pelapor' => strtoupper($surat->alamat_pelapor),
            'nik_saksi1' => strtoupper($surat->nik_saksi1),
            'nama_saksi1' => strtoupper($surat->nama_saksi1),
            'umur_saksi1' => strtoupper($surat->umur_saksi1),
            'pekerjaan_saksi1' => strtoupper($surat->pekerjaan_saksi1),
            'alamat_saksi1' => strtoupper($surat->alamat_saksi1),
            'nik_saksi2' => strtoupper($surat->nik_saksi2),
            'nama_saksi2' => strtoupper($surat->nama_saksi2),
            'umur_saksi2' => strtoupper($surat->umur_saksi2),
            'pekerjaan_saksi2' => strtoupper($surat->pekerjaan_saksi2),
            'alamat_saksi2' => strtoupper($surat->alamat_saksi2),
            'kewarganegaraan_ayah' => strtoupper($surat->kewarganegaraan_ayah),
            'kewarganegaraan_ibu' => strtoupper($surat->kewarganegaraan_ibu),
            'kebangsaan_ayah' => strtoupper($surat->kebangsaan_ayah),
            'kebangsaan_ibu' => strtoupper($surat->kebangsaan_ibu),
            'tgl_kawin' => strtoupper($tgl_kawin_formatted),
            'kelahiran_ke' => strtoupper($surat->kelahiran_ke),
            'desa_kelurahan_ibu' => $surat->desa_kelurahan_ibu,
            'kabupaten_kota_ibu' => $surat->kabupaten_kota_ibu,
            'kecamatan_ibu' => $surat->kecamatan_ibu,
            'provinsi_ibu' => $surat->provinsi_ibu,
            'desa_kelurahan_ayah' => $surat->desa_kelurahan_ayah,
            'kabupaten_kota_ayah' => $surat->kabupaten_kota_ayah,
            'kecamatan_ayah' => $surat->kecamatan_ayah,
            'provinsi_ayah' => $surat->provinsi_ayah,
            'desa_kelurahan_pelapor' => $surat->desa_kelurahan_pelapor,
            'kabupaten_kota_pelapor' => $surat->kabupaten_kota_pelapor,
            'kecamatan_pelapor' => $surat->kecamatan_pelapor,
            'provinsi_pelapor' => $surat->provinsi_pelapor,
            'desa_kelurahan_saksi1' => $surat->desa_kelurahan_saksi1,
            'kabupaten_kota_saksi1' => $surat->kabupaten_kota_saksi1,
            'kecamatan_saksi1' => $surat->kecamatan_saksi1,
            'provinsi_saksi1' => $surat->provinsi_saksi1,
            'desa_kelurahan_saksi2' => $surat->desa_kelurahan_saksi2,
            'kabupaten_kota_saksi2' => $surat->kabupaten_kota_saksi2,
            'kecamatan_saksi2' => $surat->kecamatan_saksi2,
            'provinsi_saksi2' => $surat->provinsi_saksi2,
            'kode_wilayah' => "3311020002",
            'jabatan' => $surat->jabatan,
            'nomor_surat' => $surat->nomor_surat,
            'nama_pejabat' => match ($surat->jabatan) {
                'kepala_desa' => 'Widodo',
                'sekdes' => 'Suwandi',
                'kaur_tu' => 'Subandi',
                default => null,
            },
            'tanggal' => now()->translatedFormat('d F Y'),
        ];

        return $data;
    }


    public function showSurat($id)
    {
        $surat = surat_keterangan_kelahiran::findOrFail($id);
        $data = $this->prepareSuratData($surat);
        $uppercaseData = array_map('strtoupper', $data);

        return view('kelahiran', $uppercaseData);
    }

    public function downloadLetterLahir($id)
    {
        $surat = surat_keterangan_kelahiran::findOrFail($id);
        $data = $this->prepareSuratData($surat);

        $pdf = PDF::loadView('kelahiran', $data);

        $formattedNomor = str_replace('/', '-', $data['nomor_kepala_keluarga']);
        $filename = preg_replace('/[\/\\\:\*\?"<>\|]/', '', $formattedNomor) . '.pdf';

        return $pdf->download($filename);
    }


    private function prepareSuratKematianData($suratku)
    {
        // Format the dates
        $tanggal_lahir_ibu_formatted = Carbon::parse($suratku->tanggal_lahir_ibu)->translatedFormat('l, d F Y');
        $tanggal_lahir_ayah_formatted = Carbon::parse($suratku->tanggal_lahir_ayah)->translatedFormat('l, d F Y');
        $tanggal_kematian_jenazah_formatted = Carbon::parse($suratku->tanggal_kematian_jenazah)->translatedFormat('l, d F Y');

        // Prepare the data array
        $data = [
            'id' => $suratku->id,
            'nama_kepala_keluarga' => strtoupper($suratku->nama_kepala_keluarga),
            'nomor_kepala_keluarga' => strtoupper($suratku->nomor_kepala_keluarga),
            'NIK' => strtoupper($suratku->NIK),
            'nama_jenazah' => strtoupper($suratku->nama_jenazah),
            'jenis_kelamin' => strtoupper($suratku->jenis_kelamin),
            'tanggal_lahir_jenazah' => strtoupper(Carbon::parse($suratku->tanggal_lahir_jenazah)->translatedFormat('l, d F Y')),
            'umur_jenazah' => strtoupper($suratku->umur_jenazah),
            'tempat_kelahiran' => strtoupper($suratku->tempat_kelahiran),
            'agama' => strtoupper($suratku->agama),
            'pekerjaan' => strtoupper($suratku->pekerjaan),
            'alamat_jenazah' => strtoupper($suratku->alamat_jenazah),
            'desa_kelurahan_jenazah' => strtoupper($suratku->desa_kelurahan_jenazah),
            'kecamatan_jenazah' => strtoupper($suratku->kecamatan_jenazah),
            'kabupaten_kota_jenazah' => strtoupper($suratku->kabupaten_kota_jenazah),
            'provinsi_jenazah' => strtoupper($suratku->provinsi_jenazah),
            'anak_ke' => strtoupper($suratku->anak_ke),
            'tanggal_kematian_jenazah' => strtoupper($tanggal_kematian_jenazah_formatted),
            'pukul' => strtoupper(Carbon::parse($suratku->pukul)->format('H:i') . ' WIB'),
            'sebab_kematian' => strtoupper($suratku->sebab_kematian),
            'tempat_kematian' => strtoupper($suratku->tempat_kematian),
            'yang_menerangkan' => strtoupper($suratku->yang_menerangkan),
            
            'nik_ayah' => strtoupper($suratku->nik_ayah),
            'nama_ayah' => strtoupper($suratku->nama_ayah),
            'tanggal_lahir_ayah' => strtoupper($tanggal_lahir_ayah_formatted),
            'umur_ayah' => strtoupper($suratku->umur_ayah),
            'pekerjaan_ayah' => strtoupper($suratku->pekerjaan_ayah),
            'alamat_ayah' => strtoupper($suratku->alamat_ayah),
            'nik_ibu' => strtoupper($suratku->nik_ibu),
            'nama_ibu' => strtoupper($suratku->nama_ibu),
            'tanggal_lahir_ibu' => strtoupper($tanggal_lahir_ibu_formatted),
            'umur_ibu' => strtoupper($suratku->umur_ibu),
            'pekerjaan_ibu' => strtoupper($suratku->pekerjaan_ibu),
            'alamat_ibu' => strtoupper($suratku->alamat_ibu),

            'nik_pelapor' => strtoupper($suratku->nik_pelapor),
            'nama_pelapor' => strtoupper($suratku->nama_pelapor),
            'umur_pelapor' => strtoupper($suratku->umur_pelapor),
            'jenis_kelamin_pelapor' => strtoupper($suratku->jenis_kelamin_pelapor),
            'pekerjaan_pelapor' => strtoupper($suratku->pekerjaan_pelapor),
            'alamat_pelapor' => strtoupper($suratku->alamat_pelapor),
            'nik_saksi1' => strtoupper($suratku->nik_saksi1),
            'nama_saksi1' => strtoupper($suratku->nama_saksi1),
            'umur_saksi1' => strtoupper($suratku->umur_saksi1),
            'pekerjaan_saksi1' => strtoupper($suratku->pekerjaan_saksi1),
            'alamat_saksi1' => strtoupper($suratku->alamat_saksi1),
            'nik_saksi2' => strtoupper($suratku->nik_saksi2),
            'nama_saksi2' => strtoupper($suratku->nama_saksi2),
            'umur_saksi2' => strtoupper($suratku->umur_saksi2),
            'pekerjaan_saksi2' => strtoupper($suratku->pekerjaan_saksi2),
            'alamat_saksi2' => strtoupper($suratku->alamat_saksi2),

            'desa_kelurahan_ibu' => strtoupper($suratku->desa_kelurahan_ibu),
            'kabupaten_kota_ibu' => $suratku->kabupaten_kota_ibu,
            'kecamatan_ibu' => $suratku->kecamatan_ibu,
            'provinsi_ibu' => $suratku->provinsi_ibu,
            'desa_kelurahan_ayah' => $suratku->desa_kelurahan_ayah,
            'kabupaten_kota_ayah' => $suratku->kabupaten_kota_ayah,
            'kecamatan_ayah' => $suratku->kecamatan_ayah,
            'provinsi_ayah' => $suratku->provinsi_ayah,
            'desa_kelurahan_pelapor' => $suratku->desa_kelurahan_pelapor,
            'kabupaten_kota_pelapor' => $suratku->kabupaten_kota_pelapor,
            'kecamatan_pelapor' => $suratku->kecamatan_pelapor,
            'provinsi_pelapor' => $suratku->provinsi_pelapor,
            'desa_kelurahan_saksi1' => $suratku->desa_kelurahan_saksi1,
            'kabupaten_kota_saksi1' => $suratku->kabupaten_kota_saksi1,
            'kecamatan_saksi1' => $suratku->kecamatan_saksi1,
            'provinsi_saksi1' => $suratku->provinsi_saksi1,
            'desa_kelurahan_saksi2' => $suratku->desa_kelurahan_saksi2,
            'kabupaten_kota_saksi2' => $suratku->kabupaten_kota_saksi2,
            'kecamatan_saksi2' => $suratku->kecamatan_saksi2,
            'provinsi_saksi2' => $suratku->provinsi_saksi2,
            'kode_wilayah' => "3311020002",
            'jabatan' => $suratku->jabatan,
            'nomor_surat' => $suratku->nomor_surat,
            'nama_pejabat' => match ($suratku->jabatan) {
                'kepala_desa' => 'Widodo',
                'sekdes' => 'Suwandi',
                'kaur_tu' => 'Subandi',
                default => null,
            },
            'tanggal' => now()->translatedFormat('d F Y'),
        ];

        return $data;
    }


    public function showSuratKematian($id)
    {
        $suratku = surat_keterangan_kematian::findOrFail($id);
        $data = $this->prepareSuratKematianData($suratku);
        $uppercaseData = array_map('strtoupper', $data);

        return view('kematian', $uppercaseData);
       
    }

    public function downloadLetterKematian($id)
    {
        $suratku = surat_keterangan_kematian::findOrFail($id);
        $data = $this->prepareSuratKematianData($suratku);

        $pdf = PDF::loadView('kematian', $data);

        $formattedNomor = str_replace('/', '-', $data['nomor_kepala_keluarga']);
        $filename = preg_replace('/[\/\\\:\*\?"<>\|]/', '', $formattedNomor) . '.pdf';

        return $pdf->download($filename);
    }


}
