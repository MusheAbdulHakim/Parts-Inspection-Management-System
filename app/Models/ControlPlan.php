<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','feature_id','work_instruction_id'
    ];

    public function feature(){
        return $this->belongsTo(Feature::class);
    }

    public function workInstruction(){
        return $this->belongsTo(WorkInstruction::class);
    }
}
