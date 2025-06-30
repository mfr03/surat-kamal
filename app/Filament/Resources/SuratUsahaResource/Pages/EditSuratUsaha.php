<?php

namespace App\Filament\Resources\SuratUsahaResource\Pages;

use App\Filament\Resources\SuratUsahaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuratUsaha extends EditRecord
{
    protected static string $resource = SuratUsahaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
