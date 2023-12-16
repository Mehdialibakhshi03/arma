<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOfferForm extends Model
{
    use HasFactory;
    protected $table='sales_offer_form';
    protected $guarded=['_token','id'];
}
