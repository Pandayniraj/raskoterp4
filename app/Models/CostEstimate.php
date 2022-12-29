<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostEstimate extends Model
{
    use HasFactory;
    protected $table = 'costestimate';
    protected $fillable = [
        'grantamt',
        'othergrant',
        'partnershipamt',
        'partnershiporg',
        'cashshare',
        'totalcontingency',
        'contingencyper',
        'contingencyamt',
        'otherdeducper',
        'otherdeducamt',
        'amtbyoffice',
        'labordonation',
        'totalcost',
        'operationid',
    ];
    public $timestamps = false;
}
