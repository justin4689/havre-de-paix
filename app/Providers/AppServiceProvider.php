<?php

namespace App\Providers;

use App\Mail\Transport\HostingerMailTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mail::extend('hostinger', function (array $config = []) {
            return new HostingerMailTransport(
                token: (string) ($config['token'] ?? ''),
                mailboxId: (string) ($config['mailbox_id'] ?? ''),
                timeout: (int) ($config['timeout'] ?? 10),
            );
        });
    }
}
