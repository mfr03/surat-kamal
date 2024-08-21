<?php
namespace App\Filament\Resources\SuratResource\Pages;

use App\Filament\Resources\SuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurat extends EditRecord
{
    protected static string $resource = SuratResource::class;
    
    public function mount($record): void
    {
        parent::mount($record);

        // Fill form with the current record's data
        $this->form->fill([
            'kode_surat' => $this->record->kode_surat,
            'nomor_surat' => $this->record->nomor_surat,
            'name' => $this->record->name,
            'date_of_birth' => $this->record->date_of_birth,
            'place_of_birth' => $this->record->place_of_birth,
            'nationality' => $this->record->nationality,
            'religion' => $this->record->religion,
            'job' => $this->record->job,
            'address' => $this->record->address,
            'id_number' => $this->record->id_number,
            'letter_number' => $this->record->letter_number,
            'purpose' => $this->record->purpose,
            'valid_from' => $this->record->valid_from,
            'valid_until' => $this->record->valid_until,
            'remarks' => $this->record->remarks,
            'jenis_id' => $this->record->jenis_id,
            'kartu_keluarga' => $this->record->kartu_keluarga,
            'nama_ibu_kandung' => $this->record->nama_ibu_kandung,
            'nomor_hp' => $this->record->nomor_hp,
            'keterangan_usaha' => $this->record->keterangan_usaha,
            'jabatan' => $this->record->jabatan,
            'jenis_kelamin' => $this->record->jenis_kelamin,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
