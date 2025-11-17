<?php

namespace App\Filament\Resources\NewsCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NewsCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Kategori')
                    ->sortable()
                    ->icon('heroicon-o-globe-asia-australia')
                    ->searchable()
                    ->description(fn($record) => $record->slug)
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->icon('heroicon-o-clipboard-document')
                    ->color('gray'),

                TextColumn::make('descriptions')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn($record) => $record->descriptions)
                    ->searchable()
                    ->toggleable()
                    ->wrap(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
            ])
            ->striped()
            ->deferLoading()
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status Aktif')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Nonaktif',
                    ])
                    ->placeholder('Semua Status'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->color('gray'),

                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->color('primary')->visible(auth()->user()->isAdmin()),

                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')->visible(auth()->user()->isAdmin()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
