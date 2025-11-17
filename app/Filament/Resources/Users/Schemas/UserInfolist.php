<?php

namespace App\Filament\Resources\Users\Schemas;

use Faker\Core\Color;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil Penulis')
                    ->description('Informasi dari tabel authors')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        ImageEntry::make('author.avatar')
                            ->label('Foto Profil')
                            ->disk('public')
                            ->circular()
                            ->imageHeight(150)
                            ->placeholder(fn($record) => asset('images/default-avatar.png')),

                        TextEntry::make('author.username')
                            ->label('Username Penulis')
                            ->icon('heroicon-o-at-symbol')
                            ->badge()
                            ->color('info')
                            ->placeholder('Belum diatur'),

                        TextEntry::make('author.bio')
                            ->label('Bio Penulis')
                            ->icon('heroicon-o-pencil-square')
                            ->placeholder('Belum ada bio...')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn() => auth()->user()->isAuthor())
                    ->columns(2)
                    ->collapsible(),

                Section::make('Profile Pengguna')
                    ->description('Informasi dasar dan identitas pengguna')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nama Lengkap')
                                    ->icon('heroicon-o-user')
                                    ->weight('bold')
                                    ->size(TextSize::Large)
                                    ->color('gray-900')
                                    ->columnSpan(1),

                                TextEntry::make('email_verified_at')
                                    ->label('Status Verifikasi')
                                    ->icon(fn($state) => $state ? 'heroicon-o-check-badge' : 'heroicon-o-x-circle')
                                    ->color(fn($state) => $state ? 'success' : 'danger')
                                    ->formatStateUsing(function ($state) {
                                        if (is_null($state)) {
                                            return 'Belum Verifikasi';
                                        }

                                        if ($state instanceof \Carbon\Carbon) {
                                            return 'Terverifikasi - ' . $state->format('d M Y');
                                        }

                                        return 'Status Tidak Diketahui';
                                    })
                                    ->placeholder('Belum Verifikasi')
                                    ->columnSpan(1),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('email')
                                    ->label('Alamat Email')
                                    ->icon('heroicon-o-envelope')
                                    ->color('secondary')
                                    ->copyable()
                                    ->copyMessage('Email disalin!')
                                    ->badge()
                                    ->columnSpan(1),

                                TextEntry::make('id')
                                    ->label('User ID')
                                    ->icon('heroicon-o-finger-print')
                                    ->color('gray-500')
                                    ->copyable()
                                    ->copyMessage('ID disalin!')
                                    ->weight('medium')
                                    ->columnSpan(1),
                            ]),

                        TextEntry::make('created_at')
                            ->label('Bergabung Sejak')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('d F Y')
                            ->color('gray-600')
                            ->columnSpanFull(),
                    ])->collapsible(),

                Section::make('Informasi Akun')
                    ->description('Detail timeline dan metadata akun')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->icon('heroicon-o-plus-circle')
                                    ->dateTime('d M Y • H:i')
                                    ->color('gray')
                                    ->helperText(fn($record) => 'Dibuat ' . $record->created_at->diffForHumans()),

                                TextEntry::make('updated_at')
                                    ->label('Diupdate Pada')
                                    ->icon('heroicon-o-arrow-path')
                                    ->dateTime('d M Y • H:i')
                                    ->color('gray')
                                    ->helperText(fn($record) => 'Diupdate ' . $record->updated_at->diffForHumans()),
                            ]),
                    ]),

                Section::make('Keamanan')
                    ->description('Status keamanan dan informasi akses')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('account_age')
                                    ->label('Usia Akun')
                                    ->icon('heroicon-o-cake')
                                    ->color('info')
                                    ->getStateUsing(fn($record) => $record->created_at->diffForHumans())
                                    ->badge(),

                                TextEntry::make('days_since_verification')
                                    ->label('Sudah Diverifikasi')
                                    ->icon('heroicon-o-clock')
                                    ->color(fn($record) => $record->email_verified_at ? 'success' : 'danger')
                                    ->getStateUsing(fn($record) => $record->email_verified_at ? $record->email_verified_at->diffForHumans() : 'Belum')
                                    ->placeholder('Belum diverifikasi')
                                    ->columnSpan(1),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('password_status')
                                    ->label('Status Password')
                                    ->icon('heroicon-o-shield-check')
                                    ->color('success')
                                    ->getStateUsing(fn($record) => 'Aman')
                                    ->badge()
                                    ->columnSpan(1),

                                TextEntry::make('last_activity')
                                    ->label('Aktivitas Terakhir')
                                    ->icon('heroicon-o-fire')
                                    ->color('primary')
                                    ->getStateUsing(fn($record) => $record->updated_at->diffForHumans())
                                    ->badge()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
