<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('author.avatar')
                    ->label('Avatar')
                    ->circular()
                    ->imageSize(40)
                    ->disk('public')
                    ->placeholder('Belum ada Photo')
                    ->visible(fn() => auth()->user()->isAuthor()),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',
                        'author' => 'success',
                        default => 'gray',
                    })
                    ->visible(fn() => auth()->user()->isAdmin()),

                TextColumn::make('author.username')
                    ->label('Username')
                    ->searchable()
                    ->placeholder('-')
                    ->badge()
                    ->color('info'),


                // muncul di halaman login sebagai author
                TextColumn::make('author.bio')
                    ->label('Bio')
                    ->limit(40)
                    ->wrap()
                    ->placeholder('-')
                    ->visible(fn() => auth()->user()->isAuthor()),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),

            ])
            ->filters([])
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->color('gray'),

                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),

                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->visible(fn() => auth()->user()->isAdmin()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
