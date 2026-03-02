<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse;
use App\Listeners\HandleFailedLogin;
use App\Listeners\ResetFailedLoginAttempts;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
        $this->app->singleton(RegisterResponseContract::class, \App\Http\Responses\RegisterResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzar HTTPS cuando se usa Expose/ngrok
        if (request()->header('X-Forwarded-Proto') === 'https' || request()->header('X-Forwarded-Host')) {
            URL::forceScheme('https');
        }

        // Registrar listeners de login
        Event::listen(Failed::class, HandleFailedLogin::class);
        Event::listen(Login::class, ResetFailedLoginAttempts::class);

        // Personalizar el correo de restablecimiento de contraseña en español
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            $expireMinutes = config('auth.passwords.users.expire');

            return (new MailMessage)
                ->subject('Restablecer contraseña')
                ->greeting('¡Hola!')
                ->line('Estás recibiendo este correo porque se solicitó un restablecimiento de contraseña para tu cuenta.')
                ->action('Restablecer contraseña', $url)
                ->line("Este enlace de restablecimiento expirará en {$expireMinutes} minutos.")
                ->line('Si no solicitaste un restablecimiento de contraseña, no es necesario realizar ninguna acción.')
                ->salutation('Saludos, '.config('app.name'));
        });

        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
