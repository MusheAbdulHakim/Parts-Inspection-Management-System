<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionTool extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','tool_id'];


    public function calibration(){
        return $this->hasMany(Calibration::class);
    }


}
