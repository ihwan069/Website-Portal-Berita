<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class NewsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Artikel')
                    ->description('Detail utama berita dan kategori')
                    ->icon('heroicon-o-newspaper')
                    ->schema([
                        ImageEntry::make('thumbnail')
                            ->label('Thumbnail Artikel')
                            ->disk('public')
                            ->imageheight(200)
                            ->imagewidth(300)
                            ->extraAttributes(['class' => 'border-2 border-gray-200'])
                            ->columnSpan(1),

                        Grid::make(3)
                            ->schema([
                                TextEntry::make('author.user.name')
                                    ->label('Penulis')
                                    ->icon('heroicon-o-user-circle')
                                    ->weight('medium')
                                    ->color('primary')
                                    ->badge(),

                                TextEntry::make('newsCategory.title')
                                    ->label('Kategori')
                                    ->icon('heroicon-o-tag')
                                    ->weight('medium')
                                    ->color('success')
                                    ->badge(),

                                IconEntry::make('is_published')
                                    ->label('Status')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-eye')
                                    ->falseIcon('heroicon-o-eye-slash')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ]),

                        IconEntry::make('is_featured')
                            ->label('Berita Unggulan')
                            ->boolean()
                            ->trueIcon('heroicon-o-check')
                            ->falseIcon('heroicon-o-x-mark')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        TextEntry::make('title')
                            ->label('Judul Artikel')
                            ->weight('bold')
                            ->size(TextSize::Large)
                            ->color('gray-900')
                            ->icon('heroicon-o-document-text')
                            ->columnSpanFull(),

                        TextEntry::make('slug')
                            ->label('Slug URL')
                            ->icon('heroicon-o-link')
                            ->color('blue-600')
                            ->copyable()
                            ->copyMessage('Slug disalin!')
                            ->columnSpanFull(),

                        TextEntry::make('published_at')
                            ->label('Jadwal Publikasi')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('d F Y • H:i')
                            ->color(fn($record) => $record->published_at && $record->published_at->isFuture() ? 'orange' : 'gray'),
                    ])
                    ->collapsible(),

                Section::make('Konten')
                    ->description('Preview artikel lengkap')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->schema([

                        TextEntry::make('content')
                            ->label('Konten Lengkap')
                            ->prose()
                            ->markdown()
                            ->placeholder('Tidak ada konten')
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'bg-white p-6 rounded-lg border border-gray-200']),
                    ])
                    ->collapsible(),

                Section::make('Pengaturan & SEO')
                    ->description('Opsi publikasi dan optimasi mesin pencari')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->icon('heroicon-o-plus-circle')
                                    ->dateTime('d M Y • H:i')
                                    ->color('gray'),

                                TextEntry::make('updated_at')
                                    ->label('Diupdate Pada')
                                    ->icon('heroicon-o-arrow-path')
                                    ->dateTime('d M Y • H:i')
                                    ->color('gray')
                                    ->helperText(fn($record) => $record->updated_at?->diffForHumans()),
                            ]),

                        TextEntry::make('meta_description')
                            ->label('Meta Description')
                            ->icon('heroicon-o-magnifying-glass')
                            ->placeholder('Tidak ada meta description')
                            ->prose()
                            ->color('gray-600')
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'bg-gray-50 px-3 py-2 rounded-lg border']),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Statistik')
                    ->description('Informasi tambahan tentang artikel')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('word_count')
                                    ->label('Jumlah Kata')
                                    ->icon('heroicon-o-document-text')
                                    ->color('blue')
                                    ->getStateUsing(fn($record) => str_word_count(strip_tags($record->content)) . ' kata'),

                                TextEntry::make('read_time')
                                    ->label('Waktu Baca')
                                    ->icon('heroicon-o-clock')
                                    ->color('green')
                                    ->getStateUsing(fn($record) => ceil(str_word_count(strip_tags($record->content)) / 200) . ' menit'),

                                TextEntry::make('character_count')
                                    ->label('Jumlah Karakter')
                                    ->icon('heroicon-o-tv')
                                    ->color('purple')
                                    ->getStateUsing(fn($record) => number_format(strlen(strip_tags($record->content))) . ' karakter'),

                                TextEntry::make('last_modified')
                                    ->label('Terakhir Diupdate')
                                    ->icon('heroicon-o-exclamation-circle')
                                    ->color('orange')
                                    ->getStateUsing(fn($record) => $record->updated_at->diffForHumans()),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
