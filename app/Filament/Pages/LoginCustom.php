<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Filament\Auth\Pages\Login as BaseLogin;

class LoginCustom extends BaseLogin
{
    public function getHeading(): string | Htmlable
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return __('filament-panels::auth/pages/login.multi_factor.heading');
        }

        return __('Selamat Datang di IhwNews');
    }

    public function getSubheading(): string | Htmlable | null
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return __('filament-panels::auth/pages/login.multi_factor.subheading');
        }

        if (! filament()->hasRegistration()) {
            return null;
        }

        return new HtmlString(__('Silahkan masuk untuk mengelola akun Anda') . ' ' . $this->registerAction->toHtml());
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Email or Username')
            ->required()
            ->autocomplete('off')
            ->autofocus()
            ->prefixIcon('heroicon-o-user-circle')
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Password')
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="3"> {{ __(\'filament-panels::auth/pages/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('off')
            ->prefixIcon('heroicon-o-lock-closed')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        // login untuk menggunakan email atau username
        $login = $data['login'];

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return [
                'email' => $login,
                'password' => $data['password'],
            ];
        }

        $user = User::whereHas('author', function ($q) use ($login) {
            $q->where('username', $login);
        })->first();

        if (!$user) {
            return [
                'email' => 'invalid@example.com',
                'password' => $data['password'],
            ];
        }

        return [
            'email' => $user->email,
            'password' => $data['password'],
        ];
    }

    // menampilkan pesan error custom jika gagal login
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('Password atau Username salah. Silahkan coba lagi.'),
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getBackToHomeAction(),
            $this->getAuthenticateFormAction(),
        ];
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label('Sign In')
            ->icon('heroicon-o-arrow-right-end-on-rectangle')
            ->submit('authenticate');
    }

    public function getBackToHomeAction(): Action
    {
        return Action::make('home')
            ->label('back to home')
            ->url('/')
            ->link()
            ->icon('heroicon-o-arrow-left')
            ->color('gray');
    }
}
