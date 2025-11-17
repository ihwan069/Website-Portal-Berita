<?php

namespace App\Filament\Resources\NewsCategories\Pages;

use App\Filament\Resources\NewsCategories\NewsCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNewsCategory extends EditRecord
{
    protected static string $resource = NewsCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('View')
                ->icon('heroicon-o-eye')
                ->color('gray'),

            DeleteAction::make()
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }
}
