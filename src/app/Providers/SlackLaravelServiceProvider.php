<?php

namespace DigitalPulse\SlackLaravel\app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use DigitalPulse\SlackLaravel\app\Console\Commands\TestSlackCommand;

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
