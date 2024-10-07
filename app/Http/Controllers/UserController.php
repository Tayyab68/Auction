<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userAuctions($userId)
    {
        $user = User::findOrFail($userId);
        $auctions = $user->auctions()->with('bids', 'item')->get();

        return response()->json($auctions);
    }

    public function userBids($userId)
    {
        $user = User::findOrFail($userId);
        $bids = $user->bids()->with('auction.item')->get();

        return response()->json($bids);
    }
}
