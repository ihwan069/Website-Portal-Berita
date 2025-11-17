<?php

namespace App\Filament\Resources\NewsCategories\Pages;

use App\Filament\Resources\NewsCategories\NewsCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNewsCategory extends ViewRecord
{
    protected static string $resource = NewsCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->visible(auth()->user()->isAdmin()),
                
            DeleteAction::make()
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->visible(auth()->user()->isAdmin()),
        ];
    }
}
