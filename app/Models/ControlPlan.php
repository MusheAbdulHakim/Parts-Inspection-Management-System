<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','number_feature_id','binary_feature_id',
        'gauge_feature_id','work_instruction_id'
    ];

    public function numberFeature(){
        return $this->belongsTo(NumberFeature::class);
    }

    public function binaryFeature(){
        return $this->belongsTo(BinaryFeature::class);
    }

    public function gaugeFeature(){
        return $this->belongsTo(GaugeFeature::class);
    }

    public function workInstruction(){
        return $this->belongsTo(WorkInstruction::class);
    }
}
