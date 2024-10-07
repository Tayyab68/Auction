<?php

namespace App\Policies;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuctionPolicy
{
    use HandlesAuthorization;

    // Policy to allow only auction owner or auctioneer to close the auction
    public function close(User $user, Auction $auction)
    {
        // Only the auction owner or the auctioneer can close the auction
        return $user->id === $auction->user_id || $auction->auctioneer_id === $user->id;
    }
}
