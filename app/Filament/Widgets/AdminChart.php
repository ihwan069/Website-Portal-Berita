<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Widgets\ChartWidget;

class AdminChart extends ChartWidget
{
    protected ?string $heading = 'News Creation Over Last 6 Months';

    protected function getData(): array
    {
        $data = [];
        $months = [];

        // 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M');

            $data[] = News::whereMonth('published_at', $month->month)
                ->whereYear('published_at', $month->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'News Created',
                    'data' => $data,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
