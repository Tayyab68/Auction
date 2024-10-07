<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Events\BidPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BidController extends Controller
{
    public function index($auctionId)
    {
        $bids = Bid::where('auction_id', $auctionId)->with('user')->get();
        return response()->json($bids);
    }

    public function store(Request $request, $auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'bid_amount' => 'required|numeric|min:1',
        ]);

        // Ensure the auction is still active
        if (!$auction->is_active) {
            return response()->json(['message' => 'Auction is closed.'], 400);
        }

        // Ensure the user is not the auction owner
        if ($auction->user_id == Auth::id()) {
            return response()->json(['message' => 'You cannot bid on your own auction.'], 403);
        }

        // Create the bid
        $bid = Bid::create([
            'auction_id' => $auctionId,
            'user_id' => Auth::id(),
            'bid_amount' => $validatedData['bid_amount'],
        ]);

        // Cache the highest bid
        $highestBid = Bid::where('auction_id', $auctionId)->orderBy('bid_amount', 'desc')->first();
        Cache::put('auction_' . $auctionId . '_highest_bid', $highestBid, now()->addMinutes(5));

        // Fire the BidPlaced event
        BidPlaced::dispatch($bid);

        return response()->json($bid, 201);
    }
}
