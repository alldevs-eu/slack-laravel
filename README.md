<h1>Slack Laravel</h1>
<p>A simple package to send notifications to Slack channels.</p>

# Instalation

<p>Simply run the following command to install:</p>

```sh
   composer require maurohmartinez/slack-laravel
```

<p>Then publish the config file and adjust it as you need it:</p>

```sh
   php artisan vendor:publish --provider="MHMartinez\SlackLaravel\app\Providers\SlackLaravelServiceProvider"
```

# How to use it

<p>By default, it supports 3 channels:</p>

1. `Default` channel: use the default webhook to send all common messages.
2. `Error` channel: use a webhook to send all errors of your application. 
3. `Dev` channel: use a local webhook that overrides all messages when the application is running locally.

# Test
You can easily test the service using our console command `php artisan slack:test` and then follow the instructions.
