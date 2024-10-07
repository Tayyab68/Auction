<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'starting_price'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function auction() {
        return $this->hasOne(Auction::class);
    }
}

