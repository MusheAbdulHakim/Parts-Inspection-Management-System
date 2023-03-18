<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinaryFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','bool','description'
    ];
}
