<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuctionNotificationService;

class AuctionNotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('auction.notification', function () {
            return new AuctionNotificationService();
        });
    }

    public function boot()
    {
        // No need to boot anything in this case.
    }
}
