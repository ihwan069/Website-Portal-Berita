<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getBreadcrumb(): ?string
    {
        return 'Users List';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add User')
                ->color('primary')
                ->icon('heroicon-o-user-plus')
                ->visible(fn() => auth()->user()->isAdmin()),
        ];
    }
}
