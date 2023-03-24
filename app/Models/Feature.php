<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','type','target','upper_limit','lower_limit','control_method','bool',
        'calibration_id','control_tool_id'
    ];

    public function controlTool(){
        return $this->belongsTo(InspectionTool::class,'control_tool_id');
    }

    public function calibration(){
        return $this->belongsTo(Calibration::class);
    }


}
