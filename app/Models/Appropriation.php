<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appropriation extends Model
{
    use HasFactory;
    protected $table = 'pms_deploymenttype';
    protected $guarded = [];
    public $timestamps = false;
}
