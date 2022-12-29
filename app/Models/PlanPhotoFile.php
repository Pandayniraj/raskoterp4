<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPhotoFile extends Model
{
    use HasFactory;

    protected $table = 'pms_operation_plan_photo_file';

    protected $fillable = ['pms_operation_id', 'photo_or_file', 'photo_file_details'];
}
