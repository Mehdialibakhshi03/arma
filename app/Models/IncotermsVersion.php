<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncotermsVersion extends Model
{
    use HasFactory;

    protected $table = "incoterms_version";
    protected $guarded = [];
}
