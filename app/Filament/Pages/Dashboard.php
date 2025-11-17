<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminChart;
use App\Filament\Widgets\StatsDashboard;
use Filament\Pages\Page;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        if (auth()->user()->role === 'author') {
            return [
                \App\Filament\Widgets\StatsAuthorDashboard::class,
                \App\Filament\Widgets\AuthorNewsChart::class,
                \App\Filament\Widgets\LatesAuthortNews::class,
            ];
        }

        return [
            // AccountWidget::class,
            // FilamentInfoWidget::class,
            \App\Filament\Widgets\StatsDashboard::class,
            \App\Filament\Widgets\AdminChart::class,
            \App\Filament\Widgets\LatestNews::class,
        ];
    }
}
