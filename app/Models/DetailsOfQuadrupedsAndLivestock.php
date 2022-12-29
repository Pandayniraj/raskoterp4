<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsOfQuadrupedsAndLivestock extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'local_caste_number', 'household_id'];
}
