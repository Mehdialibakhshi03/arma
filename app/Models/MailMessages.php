<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailMessages extends Model
{
    use HasFactory;

    protected $table = "mail";
    protected $guarded = [];
}
