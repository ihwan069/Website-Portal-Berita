<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pilih Berita')
                    ->schema([
                        Select::make('news_id')
                            ->label('Pilih Berita')
                            ->relationship('news', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih salah satu berita')
                    ])
                    ->columns(1),
            ]);
    }
}
