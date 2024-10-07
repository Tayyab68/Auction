<?php

namespace App\Listeners;

use App\Events\AuctionWon;
use App\Jobs\NotifyWinnerJob;

class SendAuctionWonNotification
{
    /**
     * Handle the event.
     */
    public function handle(AuctionWon $event)
    {
        // Dispatch the job to notify the winner in the background
        NotifyWinnerJob::dispatch($event->winner, $event->auction);
    }
}
