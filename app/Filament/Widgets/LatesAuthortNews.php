<?php

namespace App\Filament\Widgets;

use App\Models\News as ModelsNews;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use News;

class LatesAuthortNews extends TableWidget
{
    protected static ?string $heading = "Latest News by You";

    protected function getTableQuery(): Builder
    {
        return ModelsNews::query()->where('author_id', auth()->user()->author->id)->latest()->limit(4);
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
