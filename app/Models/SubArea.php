<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubArea extends Model
{
    use HasFactory;
    protected $table = 'pms_subjecttype';
    protected $guarded = [];
    public $timestamps = false;

    public function area()
    {
        return $this->belongsTo(\App\Models\Area::class, 'SubjectAreaId', 'Id');
    }
}
