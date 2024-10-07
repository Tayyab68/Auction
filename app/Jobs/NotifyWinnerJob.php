<?php

namespace App\Jobs;

use App\Models\Auction;
use App\Models\User;
use App\Services\AuctionNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyWinnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $winner;
    protected $auction;

    /**
     * Create a new job instance.
     */
    public function __construct(User $winner, Auction $auction)
    {
        $this->winner = $winner;
        $this->auction = $auction;
    }

    /**
     * Execute the job.
     */
    public function handle(AuctionNotificationService $notificationService)
    {
        // Use the service to notify the auction winner
        $notificationService->notifyWinner($this->winner, $this->auction);
    }
}
