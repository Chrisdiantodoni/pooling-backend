<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'promotion_uuid';

    protected $guarded = [];

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_promotions', 'promotion_uuid', 'area_uuid');
    }
}
