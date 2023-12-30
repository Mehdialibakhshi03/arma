<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $table = "markets";
    protected $guarded = [];

    public function SalesForm()
    {
        return $this->belongsTo(SalesOfferForm::class, 'commodity_id', 'id');
    }

    public function Status()
    {
        return $this->belongsTo(MarketStatus::class, 'status', 'id');
    }

    public function Bids()
    {
        return $this->hasMany(BidHistory::class, 'market_id');
    }
}
