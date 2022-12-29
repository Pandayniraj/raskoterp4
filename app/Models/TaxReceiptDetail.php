<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxReceiptDetail extends Model
{


    /**
     * @var array
     */
    protected $table='tax_receipt_details';
    
    protected $fillable = ['tax_receipt_id', 'symbol_no','description', 'used_as', 'amount','received_via','check_no'];

}
