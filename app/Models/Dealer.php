<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'dealer_code' => 'string',
    ];
    protected $primaryKey = "dealer_code";
}
