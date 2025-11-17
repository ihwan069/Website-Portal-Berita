<?php

namespace App\Filament\Resources\NewsCategories\Pages;

use App\Filament\Resources\NewsCategories\NewsCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNewsCategories extends ListRecords
{
    protected static string $resource = NewsCategoryResource::class;

    public function getBreadcrumb(): ?string
    {
        return 'News Categories List';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add NewsCategory')
                ->icon('heroicon-o-squares-plus')
                ->color('primary')->visible(auth()->user()->isAdmin()),
        ];
    }
}
