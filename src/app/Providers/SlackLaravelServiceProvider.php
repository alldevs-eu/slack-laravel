<?php

namespace MHMartinez\SlackLaravel\app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class SlackLaravelServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel): void
    {
        $this->publishes([
            __DIR__ . '/../../config/slack_laravel.php' => config_path('slack_laravel.php'),
        ], 'config');
    }
}
