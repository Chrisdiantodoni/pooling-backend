<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function motorcycles()
    {
        return $this->belongsToMany(Motorcycle::class, 'dealer_motorcycles', 'dealer_code', 'motorcycle_id');
    }
}
