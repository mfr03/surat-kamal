<?php

namespace App\Filament\Resources\SuratResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Surat;
use Carbon\Carbon;

class Stats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Surat Terbuat', Surat::count()),  
            Stat::make('Surat Hari Ini', Surat::whereDate('created_at', today())->count()), 

        ];
    }
}
