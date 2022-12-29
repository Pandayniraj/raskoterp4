<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanTransfer extends Model
{
    use HasFactory;
    protected $table = 'pms_plantransfer';
    protected $guarded = [];
    public $timestamps = false;
    public function planregister(){
        return $this->belongsTo(\App\Models\PlanRegister::class, 'PlanFromId', 'Id');
    }
}
