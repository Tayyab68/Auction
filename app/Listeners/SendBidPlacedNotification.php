<?php

namespace App\Listeners;

use App\Events\BidPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\AuctionNotificationService;

class SendBidPlacedNotification implements ShouldQueue
{
    protected $notificationService;

    public function __construct(AuctionNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(BidPlaced $event)
    {
        // Notify all participants about a new bid.
        $this->notificationService->notifyParticipants($event->bid->auction, 'New Bid Placed', 'A new bid has been placed on the auction.');
    }
}
