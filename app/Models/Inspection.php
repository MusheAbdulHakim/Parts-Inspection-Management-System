<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'partnumber','user_id','batch_no','quantity','measure_values','extra_data'
    ];

    protected $casts = [
        'measure_values' => 'array',
        'extra_data' => 'array'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
