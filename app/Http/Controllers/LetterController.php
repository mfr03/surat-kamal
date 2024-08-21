<?php
namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");

class LetterController extends Controller
{
    public function downloadLetter($id)
    {
        $surat = Surat::findOrFail($id);
        $template = '';
        $data = [];
    
        if ($surat->jenis_id == 1) {
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
                'nik' => $surat->id_number,
                'keperluan' => $surat->purpose,
                'berlaku_mulai' => Carbon::parse($surat->valid_from)->translatedFormat('d F Y'),
                'keterangan_lain' => $surat->remarks,
                'tanggal' => now()->translatedFormat('d F Y'),
                'jenis_surat' => 'SKA',
                'jalan_desa' => 'Alamat: Jl. Raya Bulu - Sanggang Km 2.5 No. Telp. -Kode Pos. 57563',
                'desa' => 'Kamal',
                'kecamatan' => 'Bulu',
                'kabupaten' => 'Sukoharjo',

                'jabatan' => $surat->jabatan, 

                'nama_pejabat' => $surat->jabatan == 'kepala_desa' ? 'Widodo' :
                                    ($surat->jabatan == 'sekdes' ? 'Suwandi' :
                                    ($surat->jabatan == 'kaur_tu' ? 'Subandi' : null)),

            ];
        } elseif ($surat->jenis_id == 2) {
            // Surat Keterangan Usaha
            $template = 'sku';
            $dateOfBirth = Carbon::parse($surat->date_of_birth);
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

                'jenis_surat' => 'SKU',

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
        }
    
        // Convert data to uppercase
        $uppercaseData = array_map('strtoupper', $data);
    
        // Load the appropriate PDF template
        $pdf = PDF::loadView($template, $uppercaseData);
    
        // Format the filename
        $formattedNomor = str_replace('/', '-', $data['nomor']);
        $filename = preg_replace('/[\/\\\:\*\?"<>\|]/', '', $formattedNomor) . '.pdf';
    
        // Return the PDF download
        return $pdf->download($filename);
    }
    

}
