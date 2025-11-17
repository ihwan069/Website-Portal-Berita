<?php

namespace App\Filament\Resources\Authors\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class AuthorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->disk('public')
                    ->imageSize(50)
                    ->circular()
                    ->grow(false)
                    ->extraImgAttributes([
                        'class' => 'rounded-2xl shadow-md border-2 border-white ring-1 ring-gray-200'
                    ])
                    ->toggleable(),

                TextColumn::make('user.name')
                    ->label('Author Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->color('gray-800')
                    ->description(fn($record) => '@' . $record->username)
                    ->wrap()
                    ->tooltip(fn($record) => $record->name)
                    ->icon('heroicon-o-user')
                    ->iconColor('primary'),

                TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable()
                    ->color('gray-500')
                    ->copyable()
                    ->copyMessage('Username copied!')
                    ->icon('heroicon-o-at-symbol'),

                TextColumn::make('bio')
                    ->label('Bio')
                    ->wrap()
                    ->limit(60)
                    ->tooltip(fn($record) => $record->bio)
                    ->color('gray-600')
                    ->icon('heroicon-o-document-text'),
            ])
            ->filters([
                Filter::make('has_avatar')
                    ->label('Has Avatar')
                    ->query(fn($query) => $query->whereNotNull('avatar')),

                Filter::make('has_bio')
                    ->label('Has Biography')
                    ->query(fn($query) => $query->whereNotNull('bio')->where('bio', '!=', '')),

                Filter::make('recently_joined')
                    ->label('Recently Joined')
                    ->query(fn($query) => $query->where('created_at', '>=', now()->subDays(30))),
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
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->deferLoading();
    }
}
