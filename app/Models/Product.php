<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_no','control_plan_id','project_id','docs','description'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function controlPlan(){
        return $this->belongsTo(ControlPlan::class);
    }
}
