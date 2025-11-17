<?php

namespace App\Filament\Resources\NewsCategories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->description('Detail informasi kategori berita')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Judul Kategori')
                            ->weight('bold')
                            ->size('Large'),

                        TextEntry::make('slug')
                            ->label('Slug URL')
                            ->icon('heroicon-o-link')
                            ->color('gray'),

                        TextEntry::make('descriptions')
                            ->label('Deskripsi')
                            ->placeholder('Tidak ada deskripsi')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->columns(2),

                Section::make('Status & Metadata')
                    ->description('Informasi status dan waktu')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        IconEntry::make('is_active')
                            ->label('Status Aktif')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d F Y • H:i')
                            ->icon('heroicon-o-calendar')
                            ->color('gray'),

                        TextEntry::make('updated_at')
                            ->label('Diupdate Pada')
                            ->dateTime('d F Y • H:i')
                            ->icon('heroicon-o-arrow-path')
                            ->color('gray'),
                    ])
                    ->columns(3),
            ]);
    }
}
