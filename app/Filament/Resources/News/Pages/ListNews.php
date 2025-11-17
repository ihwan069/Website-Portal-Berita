<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListNews extends ListRecords
{
    protected static string $resource = NewsResource::class;

    public function getBreadcrumb(): ?string
    {
        return 'News List';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add News')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
        ];
    }
}
