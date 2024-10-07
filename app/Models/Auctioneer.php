<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auctioneer extends Model
{
    public function auctioneerable() {
        return $this->morphTo();
    }

    public function auctions() {
        return $this->morphMany(Auction::class, 'auctioneer');
    }
}
