<?php

namespace App\Filament\Resources\News\Schemas;

use App\Models\Author;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use League\CommonMark\Normalizer\SlugNormalizer;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Artikel')
                    ->description('Detail utama berita dan kategori')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('author_id')
                                    ->label('Penulis')
                                    ->relationship('author.user', 'name', modifyQueryUsing: function ($query) {
                                        $query->where('role', 'author');
                                    })
                                    ->options(function () {
                                        $user = auth()->user();
                                        if ($user->isAdmin()) {
                                            return Author::with('user')
                                                ->get()
                                                ->pluck('user.name', 'id');
                                        } elseif ($user->author) {
                                            return [
                                                $user->author->id => $user->author->user->name
                                            ];
                                        }
                                        return [];
                                    })
                                    ->default(function () {
                                        $user = auth()->user();
                                        return $user->author ? $user->author->id : null;
                                    })
                                    ->disabled(fn() => !auth()->user()->isAdmin())

                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->dehydrated()
                                    ->helperText('Pilih penulis artikel')
                                    ->columnSpan(1),

                                Select::make('news_category_id')
                                    ->label('Kategori Berita')
                                    ->relationship('newsCategory', 'title')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->live()
                                    ->helperText('Pilih kategori artikel')
                                    ->columnSpan(1),
                            ]),

                        TextInput::make('title')
                            ->label('Judul Artikel')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan judul artikel yang menarik...')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->helperText('Judul akan otomatis generate slug')
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->readOnly()
                            ->helperText('Slug otomatis digenerate dari judul')
                            ->suffixIcon('heroicon-o-link')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Pengaturan Tambahan')
                    ->description('Opsi publikasi dan SEO')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_published')
                                    ->label('Publikasi')
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->inline(false)
                                    ->helperText('Publikasikan artikel sekarang?'),

                                Toggle::make('is_featured')
                                    ->label('Fitur Unggulan')
                                    ->default(false)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->inline(false)
                                    ->helperText('Berita unggulan?')
                                    ->visible(fn() => auth()->user()->isAdmin()),
                            ]),

                        DateTimePicker::make('published_at')
                            ->label('Jadwal Publikasi')
                            ->default(now())
                            ->helperText('Atur jadwal publikasi otomatis'),

                        TextInput::make('meta_description')
                            ->label('Deskripsi Meta')
                            ->maxLength(160)
                            ->helperText('Deskripsi isi (maks 160 karakter)')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Konten & Media')
                    ->description('Thumbnail dan isi artikel')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail Artikel')
                            ->image()
                            ->required()
                            ->disk('public')
                            ->directory('news/thumbnails')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth(800)
                            ->imageResizeTargetHeight(450)
                            ->panelLayout('grid')
                            ->helperText('Recomendation: Rasio 16:9, maksimal 5MB')
                            ->previewable(true)
                            ->downloadable()
                            ->openable(),

                        RichEditor::make('content')
                            ->label('Konten Artikel')
                            ->required()
                            ->fileAttachmentsDirectory('news/attachments')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->helperText('Tulis konten artikel lengkap di sini')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
