<?php

namespace App\Filament\Resources\SuratLahirResource\Pages;

use App\Filament\Resources\SuratLahirResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratLahirs extends ListRecords
{
    protected static string $resource = SuratLahirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
