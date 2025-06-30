<?php
namespace App\Filament\Resources\SuratResource\Pages;

use App\Filament\Resources\SuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Carbon\Carbon;

class EditSurat extends EditRecord
{
    protected static string $resource = SuratResource::class;
    
    public function mount($record): void
    {
        parent::mount($record);

        // Determine the type of letter based on jenis_id
        $jenisId = $this->record->jenis_id;

        // Common data for all types
        $data = [
            'kode_surat' => $this->record->kode_surat,
            'nomor_surat' => $this->record->nomor_surat,
            'name' => $this->record->name,
            'date_of_birth' => $this->record->date_of_birth,
            'place_of_birth' => $this->record->place_of_birth,
            'nationality' => $this->record->nationality,
            'religion' => $this->record->religion,
            'job' => $this->record->job,
            'address' => $this->record->address,
            // 'id_number' => $this->record->id_number,
            'letter_number' => $this->record->letter_number,
            'remarks' => $this->record->remarks,
            'jenis_id' => $this->record->jenis_id,
            'jabatan' => $this->record->jabatan,
            'purpose' => $this->record->purpose,
                'valid_from' => $this->record->valid_from,
                'valid_until' => $this->record->valid_until ?? Carbon::parse($this->record->valid_from)->addMonth()->toDateString(),
                'kartu_keluarga' => $this->record->kartu_keluarga,
        ];

        // Additional fields for Surat Pengantar
        if ($jenisId == 1) {
            $data = array_merge($data, [
                'purpose' => $this->record->purpose,
                'valid_from' => $this->record->valid_from,
                'valid_until' => $this->record->valid_until ?? Carbon::parse($this->record->valid_from)->addMonth()->toDateString(),
                'kartu_keluarga' => $this->record->kartu_keluarga,
            ]);
        }

        // Additional fields for Surat Keterangan Usaha
        if ($jenisId == 2) {
            $data = array_merge($data, [
                'jenis_kelamin' => $this->record->jenis_kelamin,
                'nama_ibu_kandung' => $this->record->nama_ibu_kandung,
                'nomor_hp' => $this->record->nomor_hp,
                'keterangan_usaha' => $this->record->keterangan_usaha,
            ]);
        }

      
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
