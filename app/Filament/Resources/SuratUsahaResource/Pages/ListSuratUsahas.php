<?php

namespace App\Filament\Resources\SuratUsahaResource\Pages;

use App\Filament\Resources\SuratUsahaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratUsahas extends ListRecords
{
    protected static string $resource = SuratUsahaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
