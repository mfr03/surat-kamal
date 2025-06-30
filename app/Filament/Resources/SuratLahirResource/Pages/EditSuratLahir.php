<?php

namespace App\Filament\Resources\SuratLahirResource\Pages;

use App\Filament\Resources\SuratLahirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuratLahir extends EditRecord
{
    protected static string $resource = SuratLahirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
