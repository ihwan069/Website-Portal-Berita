<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNews extends ViewRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil-square')
                ->color('primary'),

            DeleteAction::make()
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }
}
