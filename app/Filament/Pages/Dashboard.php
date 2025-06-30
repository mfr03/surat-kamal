<?php

namespace App\Filament\Pages;

use App\Filament\Resources\SuratKematianResource\Widgets\StatsKematian;
use App\Filament\Resources\SuratLahirResource\Widgets\StatsKelahiran;
use App\Filament\Resources\SuratResource\Widgets\Stats;
use App\Filament\Resources\SuratPengantarResource\Widgets\StatsOverview;
use App\Filament\Resources\SuratUsahaResource\Widgets\StatsUsaha;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            // Stats::class, 
            StatsOverview::class,
            StatsUsaha::class,
            StatsKematian::class,
            StatsKelahiran::class,

        ];
    }
    public static function getNavigationLabel(): string
    {
        return __('Dashboard');
    }
}
