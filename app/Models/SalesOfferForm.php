<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOfferForm extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'sales_offer_form';
    protected $guarded = ['_token', 'id'];

    public function Status()
    {
        return $this->belongsTo(FormStatus::class,'status','id');
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
