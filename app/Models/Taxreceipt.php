<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxreceipt extends Model
{
    /**
     * @var array
     */

    /**
     * @var array
     */
    protected $table='tax_receipts';
    protected $fillable = ['receipt_no','electronic_trans_no','customer_name',' pan_no','officer_name','designation','officer_code_number','date','total_amount','fiscal_year_id','entered_by','remarks'];

    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id','departments_id');
    }

    public function destination()
    {
        return $this->belongsTo(\App\Models\ProductLocation::class, 'destination_id');
    }
   


}
