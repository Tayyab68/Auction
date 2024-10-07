<?php

namespace App\Listeners;

use App\Events\AuctionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\AuctionNotificationService;

class SendAuctionCreatedNotification implements ShouldQueue
{
    protected $notificationService;

    public function __construct(AuctionNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(AuctionCreated $event)
    {
        // Notify auction participants of the new auction.
        $this->notificationService->notifyParticipants($event->auction, 'New Auction Created', 'An auction has been created.');
    }
}
