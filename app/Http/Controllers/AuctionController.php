<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Events\AuctionCreated;
use App\Events\AuctionWon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::where('is_active', true)->with('bids', 'item')->get();
        return response()->json($auctions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $auction = Auction::create([
            'user_id' => Auth::id(),
            'item_id' => $validatedData['item_id'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'is_active' => true,
        ]);

        // Fire the AuctionCreated event
        AuctionCreated::dispatch($auction);

        return response()->json($auction, 201);
    }

    public function show($id)
    {
        $auction = Auction::with('bids', 'item')->findOrFail($id);
        return response()->json($auction);
    }

    public function close($id)
    {
        // Fetch the auction along with its bids
        $auction = Auction::with('bids')->findOrFail($id);

        // Use the 'close' policy to authorize the user
        $this->authorize('close', $auction);

        // Find the highest bid
        $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();

        // Close the auction
        $auction->is_active = false;
        $auction->save();

        // Fire the AuctionWon event if there's a highest bid
        if ($highestBid) {
            AuctionWon::dispatch($auction, $highestBid->user);
        }

        return response()->json(['message' => 'Auction closed successfully'], 200);
    }

    public function popular()
    {
        $popularAuctions = Cache::remember('popular_auctions', 60, function () {
            return Auction::withCount('bids')
                ->having('bids_count', '>', 10)
                ->orderBy('bids_count', 'desc')
                ->get();
        });

        return response()->json($popularAuctions);
    }
}
