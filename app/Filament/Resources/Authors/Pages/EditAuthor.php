<?php

namespace App\Filament\Resources\Authors\Pages;

use App\Filament\Resources\Authors\AuthorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAuthor extends EditRecord
{
    protected static string $resource = AuthorResource::class;

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
