<?php

namespace MHMartinez\SlackLaravel\app\Providers;

use App\Console\Commands\TestSlackCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class SlackLaravelServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel): void
    {
        $this->publishes([
            __DIR__ . '/../../config/slack_laravel.php' => config_path('slack_laravel.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TestSlackCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/slack_laravel.php', 'slack_laravel'
        );
    }
}
