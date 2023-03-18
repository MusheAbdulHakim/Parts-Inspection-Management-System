<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','target','upper_limit','lower_limit','description'
    ];
}
