<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Author;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun Pengguna')
                    ->description('Detail dasar untuk akun pengguna baru')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nama lengkap pengguna')
                            ->helperText('Nama lengkap yang akan ditampilkan')
                            ->prefixIcon('heroicon-o-user')
                            ->columnSpan(2),

                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh@email.com')
                            ->helperText('Email yang digunakan untuk login')
                            ->prefixIcon('heroicon-o-envelope')
                            ->columnSpan(2),

                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Admin',
                                'author' => 'Author',
                            ])->default('author')
                            ->prefixIcon('heroicon-o-arrow-path-rounded-square')
                            ->placeholder('Pilih role anda')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2)
                            ->visible(fn() => auth()->user()->isAdmin()),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                            ->minLength(8)
                            ->placeholder('Minimal 8 karakter')
                            ->helperText('Isikan untuk password baru')
                            ->revealable()
                            ->prefixIcon('heroicon-o-lock-closed')
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Profil Penulis')
                    ->description('Informasi tambahan untuk akun author')
                    ->icon('heroicon-o-user')
                    ->relationship('author')
                    ->schema([
                        TextInput::make('username')
                            ->label('Username')
                            ->unique(Author::class, 'username', ignoreRecord: true)
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-users')
                            ->placeholder('Masukkan username unik'),

                        FileUpload::make('avatar')
                            ->label('Foto Profil')
                            ->disk('public')
                            ->directory('authors/avatars')
                            ->image()
                            ->imageEditor()
                            ->avatar(),

                        Textarea::make('bio')
                            ->label('Bio Singkat')
                            ->rows(3)
                            ->placeholder('Tulis sedikit tentang diri Anda')
                            ->maxLength(1000)
                            ->helperText('Tuliskan biograpi anda. Maximum 1000 char.')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Bio ini akan ditampilkan dihalaman author')
                            ->columnSpanFull(),

                    ])
                    ->columns(2)
                    ->visible(function ($livewire) {
                        // tampil hanya jika dalam mode edit dan user adalah author
                        return $livewire instanceof \Filament\Resources\Pages\EditRecord
                            && auth()->check()
                            && auth()->user()->isAuthor();
                    }),


                Section::make('Pengaturan Verifikasi')
                    ->description('Kelola status verifikasi email pengguna')
                    ->icon('heroicon-o-check-badge')
                    ->schema([
                        Toggle::make('email_verified_at')
                            ->label('Email Terverifikasi')
                            ->helperText('Aktifkan untuk memverifikasi email pengguna. Nonaktifkan untuk membatalkan verifikasi.')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Status verifikasi mempengaruhi akses pengguna ke fitur tertentu')
                            ->onColor('success')
                            ->offColor('gray')
                            ->onIcon('heroicon-o-check-badge')
                            ->offIcon('heroicon-o-x-mark')
                            ->dehydrated(false)
                            ->afterStateHydrated(function ($component, $state) {
                                $component->state($state !== null);
                            })
                            ->dehydrateStateUsing(function ($state) {
                                return $state ? now() : null;
                            })
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->visible(fn() => auth()->user()->isAdmin()),

                Section::make('Informasi Tambahan')
                    ->description('Detail teknis dan metadata')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Placeholder::make('created_info')
                            ->label('Status Pembuatan')
                            ->content('Akun akan dibuat dengan data yang telah diisi di atas')
                            ->icon('heroicon-o-plus-circle')
                            ->columnSpanFull(),

                        Placeholder::make('verification_info')
                            ->label('Status Verifikasi')
                            ->content(function ($get) {
                                return $get('verify_email')
                                    ? 'Email akan terverifikasi otomatis'
                                    : 'Email belum terverifikasi';
                            })
                            ->icon(function ($get) {
                                return $get('verify_email')
                                    ? 'heroicon-o-check-badge'
                                    : 'heroicon-o-clock';
                            })
                            ->color(function ($get) {
                                return $get('verify_email')
                                    ? 'success'
                                    : 'warning';
                            })
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->visible(fn() => auth()->user()->isAdmin()),
            ]);
    }
}
