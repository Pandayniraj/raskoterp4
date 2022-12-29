<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtensionDetail extends Model
{
    use HasFactory;

    protected $table = 'pms_operation_extension_details';

    protected $fillable = ['pms_operation_id', 'request_date', 'office_letter_date', 'completed_date', 'extension_reason'];
}
