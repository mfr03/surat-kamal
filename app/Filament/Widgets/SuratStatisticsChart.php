<?php

namespace App\Filament\Widgets;
use App\Models\surat_pengantar;
use Filament\Widgets\ChartWidget;

class SuratStatisticsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
           'datasets' => [
                [
                    'label' => 'Surat Statistics',
                    'data' => [
                        'Total Surat Terbuat' => surat_pengantar::count(),
                        'Surat Hari Ini' => surat_pengantar::whereDate('created_at', today())->count(),
                    ],
                    'backgroundColor' => ['#3490dc', '#f6993f'],
                ],
            ],
            'labels' => ['Total Surat Terbuat', 'Surat Hari Ini'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
