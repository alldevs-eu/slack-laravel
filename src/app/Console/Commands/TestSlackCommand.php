<?php

namespace MHMartinez\SlackLaravel\app\Console\Commands;

use Illuminate\Console\Command;
use MHMartinez\SlackLaravel\app\Services\SlackService;

class TestSlackCommand extends Command
{
    protected $signature = 'slack:test';

    protected $description = 'Send a test message on slack.';

    public function handle(): void
    {
        $type = $this->askWithCompletion('Where do you want to send this test message?', ['default', 'error']);
        $msg = $this->ask('Type your message...');
        $method  = $type === 'default' ? 'send' : 'error';

        SlackService::$method('Test message', $msg);
    }
}
