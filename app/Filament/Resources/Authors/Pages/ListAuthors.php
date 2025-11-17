<?php

namespace App\Filament\Resources\Authors\Pages;

use App\Filament\Resources\Authors\AuthorResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;

    public function getBreadcrumb(): ?string
    {
        return 'News Authors List';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Author')
                ->icon('heroicon-o-user-plus')
                ->color('primary'),
        ];
    }
}
