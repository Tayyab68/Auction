<?php

namespace App\Providers;

use App\Events\BidPlaced;
use App\Events\AuctionWon;
use App\Events\AuctionCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendBidPlacedNotification;
use App\Listeners\SendAuctionWonNotification;
use App\Listeners\SendAuctionCreatedNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AuctionCreated::class => [SendAuctionCreatedNotification::class],
        BidPlaced::class => [SendBidPlacedNotification::class],
        AuctionWon::class => [SendAuctionWonNotification::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
