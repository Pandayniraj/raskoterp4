<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalUnit extends Model
{
    use HasFactory;
    protected $table = 'pms_unit';
    protected $guarded = [];
    public $timestamps = false;
}
