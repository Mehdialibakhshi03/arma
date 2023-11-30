<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketStatus extends Model
{
    use HasFactory;

    protected $table = "market_status";
    protected $guarded = [];
}
