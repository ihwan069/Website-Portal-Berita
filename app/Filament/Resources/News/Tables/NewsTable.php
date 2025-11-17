<?php

namespace App\Filament\Resources\News\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->imageSize(50)
                    ->imageWidth(100)
                    ->imageHeight(60)
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->weight('bold')
                    ->description(fn($record) => Str::limit($record->slug, 30))
                    ->tooltip(fn($record) => $record->title)
                    ->url(fn($record) => $record->is_published ? route('news.show', $record->slug) : null)
                    ->openUrlInNewTab()
                    ->color(fn($record) => $record->is_published ? 'primary' : 'gray'),

                TextColumn::make('author.user.name')
                    ->label('Penulis')
                    ->sortable()
                    ->toggleable()
                    ->icon('heroicon-o-user')
                    ->description(fn($record) => '@' . $record->author->username),

                TextColumn::make('newsCategory.title')
                    ->label('Kategori')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->toggleable(),

                IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->tooltip(fn($record) => $record->is_published ? 'di publish' : 'belum dipublish')
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label('Terbit')
                    ->dateTime('d M Y • H:i')
                    ->sortable()
                    ->toggleable()
                    ->color(fn($record) => $record->published_at && $record->published_at->isFuture() ? 'warning' : 'gray')
                    ->description(
                        fn($record) => $record->published_at
                            ? \Carbon\Carbon::parse($record->published_at)->diffForHumans()
                            : 'Draft'
                    )
                    ->tooltip(fn($record) => $record->published_at ? $record->published_at->format('l, d F Y H:i') : 'Belum dijadwalkan'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_featured')
                    ->label('Fitur Unggulan')
                    ->tooltip(fn($record) => $record->is_featured ? 'Matikan' : 'Aktifkan')
                    ->visible(fn() => auth()->user()->isAdmin()),
            ])
            ->striped()
            ->deferLoading()

            ->filters([
                // SelectFilter::make('author_id')
                //     ->relationship('author', 'name')
                //     ->searchable()
                //     ->preload()
                //     ->label('Filter Penulis'),

                SelectFilter::make('news_category_id')
                    ->relationship('newsCategory', 'title')
                    ->searchable()
                    ->preload()
                    ->label('Filter Kategori'),

                TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->placeholder('Semua Status')
                    ->trueLabel('Published')
                    ->falseLabel('Draft'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->color('gray'),

                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),

                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
