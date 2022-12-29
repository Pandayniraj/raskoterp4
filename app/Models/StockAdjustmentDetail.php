<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class StockAdjustmentDetail extends Model
{
    /**
     * @var array
     */
    protected $table = 'stock_adjustment_details';

    /**
     * @var array
     */
    protected $fillable = ['adjustment_id', 'product_id', 'price', 'qty', 'unit', 'total'];

    public function Project()
    {
        return $this->belongsTo(\App\Models\Projects::class);
    }
}
