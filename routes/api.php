<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum', 'throttle:bids'])->group(function () {
    Route::get('/auctions', [AuctionController::class, 'index']);
    Route::post('/auctions', [AuctionController::class, 'store']);
    Route::get('/auctions/{id}', [AuctionController::class, 'show']);
    Route::post('/auctions/{id}/close', [AuctionController::class, 'close']);
    Route::get('/auctions/popular', [AuctionController::class, 'popular']);

    Route::post('/auctions/{id}/bids', [BidController::class, 'store']);
    Route::get('/auctions/{id}/bids', [BidController::class, 'index']);

    Route::get('/users/{id}/auctions', [UserController::class, 'userAuctions']);
    Route::get('/users/{id}/bids', [UserController::class, 'userBids']);
});

