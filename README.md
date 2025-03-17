<h1>Slack Laravel</h1>
<p>A simple package to send notifications to Slack channels.</p>

# Installation

<p>Simply run the following command to install:</p>

```sh
   composer require all-devs/slack-laravel
```

<p>Then publish the config file and adjust it as you need it:</p>

```sh
   php artisan vendor:publish --provider="AllDevs\SlackLaravel\app\Providers\SlackLaravelServiceProvider"
```

# How to use it

<p>By default, it supports 3 channels:</p>

1. `Default` channel: use the default webhook to send all common messages.
2. `Error` channel: use a webhook to send all errors of your application. 
3. `Dev` channel: use a local webhook that overrides all messages when the application is running locally.
4. `Deploy` channel: use a deploy webhook to send info about repo pull requests.

# Test
You can easily test the service using our console command `php artisan slack:test` and then follow the instructions.
