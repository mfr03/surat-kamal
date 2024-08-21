<?php

namespace App\Filament\Pages;

use App\Filament\Resources\SuratResource\Widgets\Stats;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            Stats::class,  // Register your Stats widget here
        ];
    }
}
