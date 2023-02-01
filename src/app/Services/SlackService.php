<?php

namespace MHMartinez\SlackLaravel\app\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use MHMartinez\SlackLaravel\app\Exceptions\SlackException;

class SlackService
{
    private static string $webhook;

    private static string $text;

    private static string $defaultHook;

    private static string $errorHook;

    private static string $devHook;

    public static function send(string $subject, string $message, ?string $webhook = null): void
    {
        self::init($subject, $message, $webhook);

        Http::acceptJson()->post(self::$webhook, ['text' => self::$text]);
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

        $channel = $webhook === self::$defaultHook ? 'DEFAULT' : 'ERROR';

        self::$text = App::isProduction()
            ? '*' . $subject . ':* ' . PHP_EOL . $message
            : '*' . $channel . ' — ' . $subject . ':* ' . PHP_EOL . $message;
    }

    /**
     * @throws SlackException
     */
    private static function loadHooks(): void
    {
        if (self::areHooksValid()) {
            return;
        }

        self::$defaultHook = config('slack_laravel.default');
        self::$errorHook = config('slack_laravel.error');
        self::$devHook = config('slack_laravel.dev');

        if (self::areHooksValid()) {
            throw new SlackException('Hooks are not properly defined');
        }
    }

    private static function areHooksValid(): bool
    {
        return filter_var(self::$defaultHook, FILTER_VALIDATE_URL)
            && filter_var(self::$errorHook, FILTER_VALIDATE_URL)
            && filter_var(self::$devHook, FILTER_VALIDATE_URL);
    }
}
