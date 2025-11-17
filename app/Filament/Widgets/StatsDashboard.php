<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Banner;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $newsCounts = News::count();
        $userCount = User::count();
        $categoryCount = NewsCategory::count();

        return [
            Stat::make('Total Users', $userCount . ' Users')
                ->description('Jumlah seluruh pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([
                    $userCount - 5,
                    $userCount - 2,
                    $userCount,
                    $userCount + 3,
                    $userCount + 5,
                    $userCount
                ])
                ->extraAttributes([
                    'class' => 'hover:scale-[1.02] transition-transform duration-300',
                ]),

            Stat::make('Total NewsCategories', $categoryCount . ' NewsCategories')
                ->description('Kategori berita tersedia')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('warning')
                ->chart([
                    $categoryCount - 2,
                    $categoryCount - 1,
                    $categoryCount,
                    $categoryCount + 1,
                    $categoryCount + 2
                ])
                ->extraAttributes([
                    'class' => 'hover:scale-[1.02] transition-transform duration-300',
                ]),

            Stat::make('Total News', $newsCounts . ' News')
                ->description('Berita yang telah diterbitkan')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('danger')
                ->chart([
                    $newsCounts - 5,
                    $newsCounts - 2,
                    $newsCounts,
                    $newsCounts + 2,
                    $newsCounts + 7,
                    $newsCounts
                ])
                ->extraAttributes([
                    'class' => 'hover:scale-[1.02] transition-transform duration-300',
                ]),
        ];
    }
}
