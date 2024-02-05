<?php

declare(strict_types=1);

namespace App\Providers;

use App;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Crea una instancia de Monolog
        $monolog = new Logger('custom');

        // Crea un controlador de flujo (handler) con un formato personalizado
        $streamHandler = new StreamHandler(storage_path('logs/laravel.log'), Logger::DEBUG);
        $streamHandler->setFormatter(new LineFormatter("[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n", 'Y-m-d H:i:s.u'));

        // Agrega el controlador de flujo al logger
        $monolog->pushHandler($streamHandler);

        // Obtén la instancia del Logger de Laravel
        $laravelLogger = app('log');

        // Limpia cualquier controlador de flujo existente
        $laravelLogger->getHandlers();

        // Agrega el controlador de flujo personalizado al Logger de Laravel
        $laravelLogger->pushHandler($streamHandler);

        // Establece el logger personalizado en la aplicación
        app()->instance('log', $laravelLogger);
        if (App::isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
            'pink' => Color::Pink,
            'blue' => Color::Blue,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
