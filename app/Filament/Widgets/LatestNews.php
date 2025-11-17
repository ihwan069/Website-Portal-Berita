<?php

namespace App\Filament\Widgets;

use App\Models\News as ModelsNews;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Database\Eloquent\Builder;
use News;

class LatestNews extends BaseTableWidget
{
    protected static ?string $heading = 'Latest News';

    protected function getTableQuery(): Builder
    {
        return ModelsNews::query()->latest()->limit(4);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => $this->getTableQuery())
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->limit(30)
                    ->tooltip(fn(ModelsNews $record): string => $record->title)
                    ->icon('heroicon-o-document-text'),

                TextColumn::make('author.user.name')
                    ->label('Author')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-user')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Published')
                    ->dateTime('d M Y • H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->since(),
            ])
            ->paginated(false)
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
