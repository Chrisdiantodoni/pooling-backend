<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenor extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'tenor_uuid';

    protected $guarded = [];
}
