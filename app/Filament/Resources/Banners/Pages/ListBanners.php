<?php

namespace App\Filament\Resources\Banners\Pages;

use App\Filament\Resources\Banners\BannerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBanners extends ListRecords
{
    protected static string $resource = BannerResource::class;

    public function getBreadcrumb(): ?string
    {
        return 'Banners List';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Banner')
                ->icon('heroicon-o-photo')
                ->color('primary'),
        ];
    }
}
