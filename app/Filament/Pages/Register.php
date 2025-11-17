<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\Author;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Filament\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;


class Register extends BaseRegister
{
    public function getHeading(): string | Htmlable
    {
        return 'Registrasi Author IhwNews';
    }

    public function getSubheading(): string | Htmlable | null
    {
        if (! filament()->hasLogin()) {
            return null;
        }

        return new HtmlString('Silahkan lengkapi data untuk melanjutkan.' . $this->loginAction->toHtml());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('ex. Ihwan Adli')
                    ->prefixIcon('heroicon-o-user')
                    ->autocomplete('off'),

                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('ex. ihwanadli')
                    ->hintIcon('heroicon-o-information-circle', 'Username harus unique')
                    ->prefixIcon('heroicon-o-at-symbol')
                    ->unique(Author::class)
                    ->autocomplete('off'),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(User::class)
                    ->required()
                    ->maxLength(100)
                    ->placeholder('email@example.com')
                    ->prefixIcon('heroicon-o-envelope')
                    ->autocomplete('off'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->hint('Minimal 8 karakter')
                    ->revealable()
                    ->autocomplete('new-password'),

                TextInput::make('passwordConfirmation')
                    ->label('Konfirmasi Password')
                    ->password()
                    ->same('password')
                    ->required()
                    ->revealable()
                    ->dehydrated(false),
            ])
            ->statePath('data');
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title('Terlalu Banyak Percobaan')
                ->body('Coba lagi dalam ' . $exception->secondsUntilAvailable . ' detik')
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'author',
        ]);

        $author = Author::create([
            'user_id' => $user->id,
            'username' => $data['username'],
        ]);

        event(new Registered($user));

        $this->form->fill();

        Notification::make()
            ->title('Registration Success')
            ->success()
            ->send();

        return app(RegistrationResponse::class);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getBackHomeAction(),
            $this->getRegisterFormAction(),
        ];
    }


    public function getRegisterFormAction(): Action
    {
        return Action::make('register')
            ->label('Sign Up')
            ->icon('heroicon-o-user-plus')
            ->submit('register');
    }

    public function getBackHomeAction(): Action
    {
        return Action::make('home')
            ->label('back to home')
            ->url('/')
            ->link()
            ->icon('heroicon-o-arrow-left')
            ->color('gray');
    }
}
