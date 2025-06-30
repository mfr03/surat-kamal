<?php

namespace App\Filament\Resources\SuratKematianResource\Pages;

use App\Filament\Resources\SuratKematianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuratKematian extends EditRecord
{
    protected static string $resource = SuratKematianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
