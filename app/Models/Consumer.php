<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    use HasFactory;
    protected $table = 'pms_organization';
    protected $guarded = ['Id'];
    public $timestamps = false;
    public function orgdetail()
    {
        return $this->hasMany(ConsumerDetail::class, 'OrganizationId', 'Id');
    }
}
