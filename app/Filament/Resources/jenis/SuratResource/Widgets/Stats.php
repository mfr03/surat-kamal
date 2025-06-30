<?php

namespace App\Filament\Resources\SuratResource\Widgets;
use Filament\Widgets\Widget;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\surat_keterangan_kelahiran;
use App\Models\Surat;
use Carbon\Carbon;

class Stats extends BaseWidget
{
    protected function getStats(): array
    {
        // Statistics for Surat model
        $totalSurat = Surat::count();
        $suratToday = Surat::whereDate('created_at', today())->count();
        $suratThisMonth = Surat::whereMonth('created_at', Carbon::now()->month)->count();
        $suratThisYear = Surat::whereYear('created_at', Carbon::now()->year)->count();
        $averageSuratPerDay = $this->getAverageSuratPerDay();

        // Statistics for surat_keterangan_kelahiran model
        $totalKelahiran = surat_keterangan_kelahiran::count();
        $kelahiranToday = surat_keterangan_kelahiran::whereDate('created_at', today())->count();
        $kelahiranThisMonth = surat_keterangan_kelahiran::whereMonth('created_at', Carbon::now()->month)->count();
        $kelahiranThisYear = surat_keterangan_kelahiran::whereYear('created_at', Carbon::now()->year)->count();
        $averageKelahiranPerDay = $this->getAverageKelahiranPerDay();

        return [
            // Stats for Surat model
            Stat::make('Total Surat Terbuat', $totalSurat)
                ->chart($this->getTotalSuratChartData())
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Surat Hari Ini', $suratToday)
                ->chart($this->getSuratChartData())
                ->color('success'),

            Stat::make('Surat Bulan Ini', $suratThisMonth)
                ->chart($this->getMonthlySuratChartData())
                ->color('info'),

            // Stats for surat_keterangan_kelahiran model
            Stat::make('Total Kelahiran Terbuat', $totalKelahiran)
                ->chart($this->getTotalKelahiranChartData())
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Kelahiran Hari Ini', $kelahiranToday)
                ->chart($this->getKelahiranChartData())
                ->color('success'),

            Stat::make('Kelahiran Bulan Ini', $kelahiranThisMonth)
                ->chart($this->getMonthlyKelahiranChartData())
                ->color('info'),
        ];
    }

    // Methods for Surat model statistics
    protected function getTotalSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = Surat::whereDate('created_at', '<=', $date)->count();
        }
        return $chartData;
    }

    protected function getSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = Surat::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getMonthlySuratChartData(): array
    {
        $chartData = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $chartData[] = Surat::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getYearlySuratChartData(): array
    {
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::createFromDate(Carbon::now()->year, $i, 1);
            $chartData[] = Surat::whereMonth('created_at', $i)->count();
        }
        return $chartData;
    }

    protected function getAverageSuratPerDay(): float
    {
        $totalSurat = Surat::count();

        // Check if there are any records to avoid division by zero
        if ($totalSurat === 0) {
            return 0;
        }

        $firstRecord = Surat::orderBy('created_at')->first();

        // If there is no first record, return 0 to avoid errors
        if (!$firstRecord) {
            return 0;
        }

        $days = Carbon::now()->diffInDays($firstRecord->created_at) + 1;
        return round($totalSurat / $days, 2);
    }

    // Methods for surat_keterangan_kelahiran model statistics
    protected function getTotalKelahiranChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = surat_keterangan_kelahiran::whereDate('created_at', '<=', $date)->count();
        }
        return $chartData;
    }

    protected function getKelahiranChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = surat_keterangan_kelahiran::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getMonthlyKelahiranChartData(): array
    {
        $chartData = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $chartData[] = surat_keterangan_kelahiran::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getYearlyKelahiranChartData(): array
    {
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::createFromDate(Carbon::now()->year, $i, 1);
            $chartData[] = surat_keterangan_kelahiran::whereMonth('created_at', $i)->count();
        }
        return $chartData;
    }

    protected function getAverageKelahiranPerDay(): float
    {
        $totalKelahiran = surat_keterangan_kelahiran::count();

        // Check if there are any records to avoid division by zero
        if ($totalKelahiran === 0) {
            return 0;
        }

        $firstRecord = surat_keterangan_kelahiran::orderBy('created_at')->first();

        // If there is no first record, return 0 to avoid errors
        if (!$firstRecord) {
            return 0;
        }

        $days = Carbon::now()->diffInDays($firstRecord->created_at) + 1;
        return round($totalKelahiran / $days, 2);
    }
}
