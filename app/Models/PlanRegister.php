<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRegister extends Model
{
    use HasFactory;
    protected $table = 'pms_operation';
    protected $guarded = [];
    public $timestamps = false;
    public function area(){
        return $this->belongsTo(\App\Models\Area::class, 'subjectareaid', 'Id');
    }
    public function grant(){
        return $this->belongsTo(\App\Models\Grant::class, 'granttypeid', 'Id');
    }
    public function appropriation(){
        return $this->belongsTo(\App\Models\Appropriation::class, 'deploymenttypeid','Id');
    }
}
