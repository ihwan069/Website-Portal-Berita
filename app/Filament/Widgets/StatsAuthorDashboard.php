<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Banner;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAuthorDashboard extends StatsOverviewWidget
{

    protected function getStats(): array
    {
        $categoryCount = NewsCategory::count();

        $user = auth()->user();

        $author_id = $user->author->id;
        $newsCount = News::where('author_id', $author_id)->count();
        $name = $user->name;

        $publishedNews = News::where('author_id', $author_id)
            ->where('is_published', true)
            ->count();

        return [
            Stat::make("Total News - $name", $newsCount . " News")
                ->description('All the news that is written')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('danger')
                ->chart([
                    $newsCount - 5,
                    $newsCount - 2,
                    $newsCount,
                    $newsCount + 2,
                    $newsCount + 7,
                    $newsCount
                ])
                ->extraAttributes([
                    'class' => 'hover:scale-[1.02] transition-transform duration-300',
                ]),

            Stat::make('News Published', $publishedNews . ' Published')
                ->description('News that has been published')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([
                    $publishedNews - 2,
                    $publishedNews - 3,
                    $publishedNews,
                    $publishedNews + 4,
                    $publishedNews + 2,
                    $publishedNews
                ])
                ->extraAttributes([
                    'class' => 'hover:scale-[1.02] transition-transform duration-300',
                ]),

            Stat::make('Categories', $categoryCount . ' Categories')
                ->description('Available categories for news')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('info')
                ->chart([
                    $categoryCount - 2,
                    $categoryCount - 3,
                    $categoryCount,
                    $categoryCount + 4,
                    $categoryCount + 2,
                    $categoryCount
                ])
                ->extraAttributes([
                    'class' => 'hover:scale-[1.02] transition-transform duration-300',
                ]),
        ];
    }
}
