<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAboutField extends Model
{
    use HasFactory;

    protected $fillable = ['household_id', 'name', 'yearly_production_in_kg', 'cultivated_area', 'unit_of_area'];
}
