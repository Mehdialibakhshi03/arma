<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingTerm extends Model
{
    use HasFactory;
    protected $table="shipping_terms";
    protected $guarded=[];
}
