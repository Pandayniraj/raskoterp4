<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitiesMgmt extends Model
{
    use HasFactory;
    protected $table = 'subjectsubtype';
    protected $guarded = [];
    public $timestamps = false;
    public function area()
    {
        return $this->belongsTo(\App\Models\Area::class, 'SubjectAreaId', 'Id');
    }
    public function subarea(){
        return $this->belongsTo(\App\Models\SubArea::class, 'SubjectTypeId', 'Id');
    }

}
