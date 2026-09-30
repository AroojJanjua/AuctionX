<?php

namespace App\Providers;
 
use App\Mail\Transport\MailtrapApiTransport;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;
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
         Mail::extend('mailtrap', function (array $config = []){
            return new MailtrapApiTransport(
                $config['api_key'] ?? config('services.mailtrap.api_key')
            );
        });
        Event::listen(Registered::class, SendEmailVerificationNotification::class);
    }
}
