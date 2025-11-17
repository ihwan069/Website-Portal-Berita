<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Actions\Action;
use Filament\Schemas\Schema;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Author Identity')
                    ->description('Basic author information')
                    ->icon('heroicon-o-identification')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Author Avatar')
                            ->image()
                            ->disk('public')
                            ->directory('authors/avatars')
                            ->required()
                            ->imagePreviewHeight('200')
                            ->panelAspectRatio('1:1')
                            ->panelLayout('integrated')
                            ->uploadingMessage('Uploading avatar...')
                            ->uploadProgressIndicatorPosition('center')
                            ->removeUploadedFileButtonPosition('center')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->helperText('Recommended: Square image, JPG/PNG, max 2MB')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'This avatar will represent the author')
                            ->extraAttributes(['class' => 'border-2 border-dashed border-blue-200 rounded-2xl p-6 bg-gradient-to-br from-blue-50 to-white hover:border-blue-300 transition-colors'])
                            ->avatar()
                            ->alignCenter(),
                    ])
                    ->extraAttributes(['class' => 'rounded-2xl shadow-sm border border-gray-200']),

                // Middle Column - Personal Details
                Section::make('Personal Details')
                    ->description('Author name and credentials')
                    ->icon('heroicon-o-user-circle')
                    ->columnSpan(1)
                    ->schema([
                        Select::make('user_id')
                            ->label('Full Name')
                            ->relationship('user', 'name', modifyQueryUsing: function ($query) {
                                $query->where('role', 'author');
                            })
                            ->required()
                            ->hint('Author full name')
                            ->prefixIcon('heroicon-o-user')
                            ->helperText('This name will be displayed publicly')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih author'),

                        TextInput::make('username')
                            ->label('Username')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., johndoe, jane_author')
                            ->prefixIcon('heroicon-o-at-symbol')
                            ->hint('Unique username')
                            ->helperText('This will be used for author profile URL')
                            ->extraInputAttributes(['class' => 'font-mono bg-gray-50 rounded-lg'])
                            ->suffixAction(
                                Action::make('generateUsername')
                                    ->icon('heroicon-o-sparkles')
                                    ->action(function ($set, $get) {
                                        $name = $get('name');
                                        if ($name) {
                                            $username = strtolower(str_replace(' ', '_', $name));
                                            $set('username', $username);
                                        }
                                    })
                            ),
                    ])
                    ->extraAttributes(['class' => 'rounded-2xl shadow-sm border border-gray-200']),

                Section::make('Biography')
                    ->description('Author background and story')
                    ->icon('heroicon-o-book-open')
                    ->columnSpan(1)
                    ->schema([
                        Textarea::make('bio')
                            ->label('Author Biography')
                            ->rows(8)
                            ->maxLength(1000)
                            ->placeholder('Tell us about the author\'s background, achievements, and writing style...')
                            ->helperText('Write a compelling biography to attract readers. Maximum 1000 characters.')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'This bio will appear on author profile pages')
                            ->extraInputAttributes(['class' => 'resize-none leading-relaxed'])
                            ->extraAttributes(['class' => 'bg-white rounded-xl border border-gray-300 focus-within:border-blue-500 transition-colors']),
                    ])
            ]);
    }
}
