<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];
    protected $primaryKey = 'motorcycle_uuid';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function dealers()
    {
        return $this->belongsToMany(Dealer::class, 'dealer_motorcycles', 'motorcycle_uuid', 'dealer_code');
    }
}
