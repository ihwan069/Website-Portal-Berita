<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Widgets\ChartWidget;

class AuthorNewsChart extends ChartWidget
{
    protected ?string $heading = 'Author News Chart';

    protected function getData(): array
    {
        $authorId = auth()->user()->author->id;
        $rawData = News::where('author_id', $authorId)
            ->selectRaw('COUNT(*) as total, MONTH(published_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = range(1, 12);

        $chartData = [];
        $chartLabels = [];

        foreach ($months as $month) {
            $chartData[] = $rawData[$month] ?? 0;

            $chartLabels[] = date('F', mktime(0, 0, 0, $month, 1));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah News',
                    'data' => $chartData,
                ],
            ],
            'labels' => $chartLabels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
