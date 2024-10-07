<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = ['user_id', 'item_id', 'auctioneer_id', 'start_time', 'end_time', 'is_active'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function bids() {
        return $this->hasMany(Bid::class);
    }

    public function auctioneer() {
        return $this->morphTo();
    }
}

