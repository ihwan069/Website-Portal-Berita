<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use PHPUnit\Framework\Attributes\Small;

class AuthorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Author Profile')
                    ->description('Personal information and biography')
                    ->icon('heroicon-o-user')
                    ->columnSpan(1)
                    ->schema([
                        ImageEntry::make('avatar')
                            ->label('')
                            ->disk('public')
                            ->imageSize(200)
                            ->circular()
                            ->tooltip(fn($record) => '@' . $record->username)
                            ->extraImgAttributes([
                                'class' => 'rounded-2xl shadow-lg border-4 border-white ring-2 ring-gray-200'
                            ])
                            ->alignCenter()
                            ->columnSpanFull(),

                        TextEntry::make('user.name')
                            ->label('Author Name')
                            ->color('gray-800')
                            ->weight(FontWeight::Bold)
                            ->icon('heroicon-o-user-circle')
                            ->columnSpanFull(),

                    ])
                    ->extraAttributes(['class' => 'rounded-2xl shadow-sm border border-gray-200 bg-white']),

                Section::make('Biography')
                    ->description('Author background and information')
                    ->icon('heroicon-o-document-text')
                    ->columnSpan(2)
                    ->schema([
                        TextEntry::make('bio')
                            ->label('')
                            ->color('gray-700')
                            ->wrap()
                            ->prose()
                            ->markdown()
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-gray-50 to-white rounded-2xl p-6 border-l-4 border-blue-500 text-justify leading-relaxed'
                            ])
                            ->columnSpanFull(),

                        // Additional Info bisa ditambah di sini
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Member Since')
                                    ->dateTime('d F Y')
                                    ->color('gray-500')
                                    ->icon('heroicon-o-calendar')
                                    ->size('Small')
                                    ->columnSpan(1),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->since()
                                    ->color('gray-500')
                                    ->icon('heroicon-o-clock')
                                    ->size('small')
                                    ->columnSpan(1),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->extraAttributes(['class' => 'rounded-2xl shadow-sm border border-gray-200 bg-white']),
            ]);
    }
}
