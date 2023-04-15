<?php

namespace DigitalPulse\SlackLaravel\app\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class SlackService
{
    private static string $webhook;

    private static string $text;

    private static string $defaultHook = '';

    private static string $errorHook = '';

    private static string $deployHook = '';

    private static string $devHook = '';

    public static function send(string $subject, string $message, ?string $webhook = null): void
    {
        self::init($subject, $message, $webhook);

        Http::acceptJson()->post(self::$webhook, ['text' => self::$text]);
    }

    public static function deploy(string $subject, string $message): void
    {
        self::send($subject, $message, config('slack_laravel.deploy'));
    }

    public static function error(string $subject, string $message): void
    {
        self::send($subject, $message, config('slack_laravel.error'));
    }

    private static function init(string $subject, string $message, ?string $webhook = null): void
    {
        self::loadHooks();

        $webhook ??= self::$defaultHook;

        self::$webhook = App::isProduction()
            ? $webhook
            : self::$devHook;

        $channel = match ($webhook) {
            self::$defaultHook => 'DEFAULT',
            self::$deployHook => 'DEPLOY',
            self::$errorHook => 'ERROR',
            default => null,
        };

        if (!$channel) {
            return;
        }

        self::$text = App::isProduction()
            ? '*' . $subject . ':* ' . PHP_EOL . $message
            : '*' . $channel . ' — ' . $subject . ':* ' . PHP_EOL . $message;
    }

    private static function loadHooks(): void
    {
        self::$defaultHook = config('slack_laravel.default', '');
        self::$errorHook = config('slack_laravel.error', '');
        self::$deployHook = config('slack_laravel.deploy', '');
        self::$devHook = config('slack_laravel.dev', '');
    }
}
