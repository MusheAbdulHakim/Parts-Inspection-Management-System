<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    use HasFactory;


    protected $fillable = [
        'certificate','date_','from_','to_','inspection_tool_id','calib_id','description','status'
    ];

    public function inspectionTool(){
        return $this->belongsTo(InspectionTool::class);
    }

}
