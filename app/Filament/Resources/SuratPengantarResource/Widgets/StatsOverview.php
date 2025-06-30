<?php

namespace App\Filament\Resources\SuratPengantarResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\surat_pengantar;
use Carbon\Carbon;
class StatsOverview extends BaseWidget
{
   protected function getStats(): array
    {
        // Statistics for Surat model
        $totalSurat = surat_pengantar::count();
        $suratToday = surat_pengantar::whereDate('created_at', today())->count();
        $suratThisMonth = surat_pengantar::whereMonth('created_at', Carbon::now()->month)->count();
        $suratThisYear = surat_pengantar::whereYear('created_at', Carbon::now()->year)->count();
        $averageSuratPerDay = $this->getAverageSuratPerDay();

      

        return [
            // Stats for Surat model
            Stat::make('Total Surat Pengantar Terbuat', $totalSurat)
                ->chart($this->getTotalSuratChartData())
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Surat Pengantar Hari Ini', $suratToday)
                ->chart($this->getSuratChartData())
                ->color('success'),

            Stat::make('Surat Pengantar Bulan Ini', $suratThisMonth)
                ->chart($this->getMonthlySuratChartData())
                ->color('info'),

        ];
    }

    // Methods for Surat model statistics
    protected function getTotalSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = surat_pengantar::whereDate('created_at', '<=', $date)->count();
        }
        return $chartData;
    }

    protected function getSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = surat_pengantar::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getMonthlySuratChartData(): array
    {
        $chartData = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $chartData[] = surat_pengantar::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getYearlySuratChartData(): array
    {
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::createFromDate(Carbon::now()->year, $i, 1);
            $chartData[] = surat_pengantar::whereMonth('created_at', $i)->count();
        }
        return $chartData;
    }

    protected function getAverageSuratPerDay(): float
    {
        $totalSurat = surat_pengantar::count();

        // Check if there are any records to avoid division by zero
        if ($totalSurat === 0) {
            return 0;
        }

        $firstRecord = surat_pengantar::orderBy('created_at')->first();

        // If there is no first record, return 0 to avoid errors
        if (!$firstRecord) {
            return 0;
        }

        $days = Carbon::now()->diffInDays($firstRecord->created_at) + 1;
        return round($totalSurat / $days, 2);
    }

  
}
