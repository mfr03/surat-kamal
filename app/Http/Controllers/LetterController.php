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
        // Retrieve the record by ID
        $surat = Surat::findOrFail($id);
    
        
    
        // Determine the letter type based on the `jenis` field
        $template = '';
        $data = [];
    
        if ($surat->jenis_id == 1) {
            // Surat Pengantar
            $template = 'surat_pengantar';
            // Convert the date_of_birth to a Carbon instance
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
                'sekdes' => 'SUWANDI',
                'jenis_surat' => 'SKA',
                'jalan_desa' => 'Alamat: Jl. Raya Bulu - Sanggang Km 2.5 No. Telp. -Kode Pos. 57563',
                'desa' => 'Kamal',
                'kecamatan' => 'Bulu',
                'kabupaten' => 'Sukoharjo',
                'kepala_desa' => 'Widodo',
            ];
        } elseif ($surat->jenis_id == 2) {
            // Surat Keterangan Usaha
            $template = 'surat_keterangan_usaha';
            $data = [
                'nomor' => $surat->letter_number,
                'nama' => $surat->name,
                'tempat_tinggal' => $surat->address,
                'nik' => $surat->id_number,
                'keperluan' => $surat->purpose,
                'berlaku_mulai' => Carbon::parse($surat->valid_from)->translatedFormat('d F Y'),
                'keterangan_lain' => $surat->remarks,
                'tanggal' => now()->translatedFormat('d F Y'),
                'sekdes' => 'SUWANDI',
                'jenis_surat' => 'SKA',
                'jalan_desa' => 'Alamat: Jl. Raya Bulu - Sanggang Km 2.5 No. Telp. -Kode Pos. 57563',
                'desa' => 'Kamal',
                'kecamatan' => 'Bulu',
                'kabupaten' => 'Sukoharjo',
                'kepala_desa' => 'Widodo',
            ];
        }
    
        // Convert data to uppercase
        $uppercaseData = array_map('strtoupper', $data);
    
        // Load the appropriate PDF template
        $pdf = PDF::loadView('testing', $uppercaseData);
    
        // Format the filename
        $formattedNomor = str_replace('/', '-', $data['nomor']);
        $filename = preg_replace('/[\/\\\:\*\?"<>\|]/', '', $formattedNomor) . '.pdf';
    
        // Return the PDF download
        return $pdf->download($filename);
    }
    

}
