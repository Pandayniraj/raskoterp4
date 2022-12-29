<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    /**
     * @var array
     */
    protected $table = 'stock_adjustment';

    /**
     * @var array
     */
    protected $fillable = ['org_id','date', 'location_id', 'reason', 'status', 'ledgers_id', 'vat_type', 'subtotal', 'discount_percent', 'taxable_amount', 'tax_amount', 'total_amount', 'comments', 'entry_id'];

    public function productlocation()
    {
        return $this->belongsTo(\App\Models\ProductLocation::class, 'location_id');
    }

    public function adjustmentreason()
    {
        return $this->belongsTo(\App\Models\AdjustmentReason::class, 'reason');
    }
}
