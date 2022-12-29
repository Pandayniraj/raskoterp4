<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAgreement extends Model
{
    use HasFactory;
    protected $table = 'planagreements';
    protected $fillable = [
        'prjrunning_committee',
        'agreementdate',
        'startdate',
        'completiondate',
        'householdnumber',
        'population',
        'remarks',
        'createdat',
        'updatedat',
        'operationid',

       
    ];
    public $timestamps = false;
}
