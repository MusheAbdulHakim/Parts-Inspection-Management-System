<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','type','target','upper_limit','lower_limit','control_method',
        'calibration_id','inspection_tool_id','control_plan_id'
    ];

    public function controlPlan(){
        return $this->belongsTo(ControlPlan::class,'control_plan_id');
    }

    public function inspectionTool(){
        return $this->belongsTo(InspectionTool::class,'inspection_tool_id');
    }

    public function calibration(){
        return $this->belongsTo(Calibration::class,'calibration_id');
    }


}
