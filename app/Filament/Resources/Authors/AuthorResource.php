<?php

namespace App\Filament\Resources\Authors;

use App\Filament\Resources\Authors\Pages\CreateAuthor;
use App\Filament\Resources\Authors\Pages\EditAuthor;
use App\Filament\Resources\Authors\Pages\ListAuthors;
use App\Filament\Resources\Authors\Pages\ViewAuthor;
use App\Filament\Resources\Authors\Schemas\AuthorForm;
use App\Filament\Resources\Authors\Schemas\AuthorInfolist;
use App\Filament\Resources\Authors\Tables\AuthorsTable;
use App\Models\Author;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'News Content';

    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function canCreate(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereHas('user', function ($query) {
            $query->where('role', 'author');
        })->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::whereHas('user', function ($query) {
            $query->where('role', 'author');
        })->count() > 10 ? 'warning' : 'success';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return static::getModel()::whereHas('user', function ($query) {
            $query->where('role', 'author');
        })->count() . ' Authors';
    }

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'username';

    public static function form(Schema $schema): Schema
    {
        return AuthorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuthorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuthorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuthors::route('/'),
            'create' => CreateAuthor::route('/create'),
            'view' => ViewAuthor::route('/{record}'),
            'edit' => EditAuthor::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            });
    }
}
