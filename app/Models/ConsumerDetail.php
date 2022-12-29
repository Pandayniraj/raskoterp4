<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerDetail extends Model
{
    use HasFactory;
    protected $table= 'pms_organizationmembers';
    protected $guarded = [];
    public $timestamps = false;
    public function org()
    {
        return $this->belongsTo(Consumer::class);
    }
    public function post(){
        return $this->belongsTo(Post::class, 'DesignationId', 'Id');
    }
}
