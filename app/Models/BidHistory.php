<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidHistory extends Model
{
    use HasFactory;

    protected $table = "bidhistories";
    protected $guarded = [];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Market(){
        return $this->belongsTo(Market::class);
    }
}
