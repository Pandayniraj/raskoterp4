<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    /**
     * @var array
     */

    protected $table = 'purch_orders';

    /**
     * @var array
     */
    protected $fillable = ['user_id','org_id','purchase_type','due_date','supplier_id','comments', 'ord_date', 'reference','total','into_stock_location','subtotal','discount_percent','taxable_amount','tax_amount','status','vat_type','pan_no','payment_status','ledger_id','bill_no','fiscal_year','is_renewal','fiscal_year_id','entry_id','bill_date','delivery_date','project_id','supplier_type','discount_type','currency','non_taxable_amount','discount_amount'];


    public function user()
    {
        return $this->belongsTo('\App\User');
    }

      public function client()
    {
        if($this->supplier_type == 'cash_equivalent'){
            return $this->belongsTo('\App\Models\COALedgers','supplier_id');
        }else{
            return $this->belongsTo('\App\Models\Client','supplier_id');
        }
      
    }

    public function lead()
    {
        return $this->belongsTo('\App\Models\Lead','client_id');
    }
    public function organization()
    {
        return $this->belongsTo('\App\Models\organization');
    }

    public function unit()
    {
        return $this->belongsTo('\App\Models\ProductsUnit','product_unit');
    }

    public function get_fiscal_year(){
         return $this->belongsTo('\App\Models\Fiscalyear','fiscal_year_id','id');
    }

    public function entry()
    {
        return $this->belongsTo(\App\Models\Entry::class, 'entry_id');
    }

     public function return_bills()
    {
        return $this->hasMany(\App\Models\SupplierReturn::class, 'purchase_bill_no', 'id');
    }

    /**
     * @return bool
     */
    public function isEditable()
    {
        // Protect the admins and users Intakes from editing changes
        // if ( ('admins' == $this->name) || ('users' == $this->name) ) {
        //     return false;
        // }
        if(\Auth::user()->hasRole('admins') || \Auth::user()->id == $this->user_id ){
            return true;
        }


        return false;
    }

    /**
     * @return bool
     */
    public function isDeletable()
    {
        // Protect the admins and users Intakes from deletion
        if ( ('admins' == $this->name) || ('users' == $this->name) ) {
            return false;
        }

        return true;
    }


    public function hasPerm(Permission $perm)
    {
        // perm 'basic-authenticated' is always checked.
        if ('basic-authenticated' == $perm->name) {
            return true;
        }
        // Return true if the Intake has is assigned the given permission.
        if ( $this->perms()->where('id' , $perm->id)->first() ) {
            return true;
        }
        // Otherwise
        return false;
    }



    public function product_details(){


        return $this->hasMany(\App\Models\PurchaseOrderDetail::class, 'order_no', 'id');
    }



}
