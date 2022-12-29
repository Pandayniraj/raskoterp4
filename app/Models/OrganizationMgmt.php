<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationMgmt extends Model
{
    use HasFactory;
    protected $table = 'pms_company';
    protected $guarded = [];
    public $timestamps = false;
}
