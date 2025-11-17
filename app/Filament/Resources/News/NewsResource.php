<?php

namespace App\Filament\Resources\News;

use App\Filament\Resources\News\Pages\CreateNews;
use App\Filament\Resources\News\Pages\EditNews;
use App\Filament\Resources\News\Pages\ListNews;
use App\Filament\Resources\News\Pages\ViewNews;
use App\Filament\Resources\News\Schemas\NewsForm;
use App\Filament\Resources\News\Schemas\NewsInfolist;
use App\Filament\Resources\News\Tables\NewsTable;
use App\Models\News;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->isAdmin()) return $query;

        return $query->where('author_id', auth()->user()->author->id);
    }

    protected static string | UnitEnum | null $navigationGroup = 'News Content';

    protected static ?int $navigationSort = 1;

    public static function getFilteredQuery(): Builder
    {
        $query = static::getModel()::query()
            ->where('is_published', 1);

        if (!auth()->user()->isAdmin()) {
            $query->where('author_id', auth()->user()->author->id);
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getFilteredQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getFilteredQuery()->count();

        return $count > 10 ? 'warning' : 'success';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $count = static::getFilteredQuery()->count();

        return "{$count} News Published";
    }

    protected static ?string $recordTitleAttribute = 'short_title';

    public static function form(Schema $schema): Schema
    {
        return NewsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NewsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsTable::configure($table);
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
            'index' => ListNews::route('/'),
            'create' => CreateNews::route('/create'),
            'view' => ViewNews::route('/{record}'),
            'edit' => EditNews::route('/{record}/edit'),
        ];
    }
}
