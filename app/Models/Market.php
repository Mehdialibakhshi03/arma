<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $table = "markets";
    protected $guarded = [];

    public function FormValue()
    {
        return $this->belongsTo(FormValue::class, 'form_value_id', 'id');
    }
}
