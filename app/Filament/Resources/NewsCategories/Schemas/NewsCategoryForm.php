<?php

namespace App\Filament\Resources\NewsCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->description('Isi detail kategori berita')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Kategori')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Teknologi, Politik, Olahraga')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->helperText('Judul kategori yang akan ditampilkan')
                            ->columnSpan(2),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->readOnly()
                            ->placeholder('otomatis-tergenerate')
                            ->helperText('URL-friendly version dari judul')
                            ->suffixIcon('heroicon-o-link'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('Pengaturan Tambahan')
                    ->description('Konfigurasi tambahan untuk kategori')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Nonaktifkan untuk menyembunyikan kategori'),

                        Textarea::make('descriptions')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->placeholder('Deskripsi singkat tentang kategori...')
                            ->helperText('Opsional: tambahkan deskripsi untuk SEO')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
