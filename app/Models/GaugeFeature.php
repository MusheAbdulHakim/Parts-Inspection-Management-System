<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaugeFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','bool','description'
    ];
}

