<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Audit as Audit;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Entryitem;
use App\Models\Lead;
use App\Models\MasterComments;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Orders as Order;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Role as Permission;
use App\Models\StockMove;
use App\User;
use Auth;
use DB;
use Flash;
use Illuminate\Http\Request;

/**
 * THIS CONTROLLER IS USED AS PRODUCT CONTROLLER.
 */
class PurchaseController extends Controller
{
    /**
     * @var Client
     */
    private $purchaseorder;

    /**
     * @var Permission
     */
    private $permission;

    /**
     * @param Client $bug
     * @param Permission $permission
     * @param User $user
     */
    public function __construct(Permission $permission, PurchaseOrder $purchaseorder)
    {
        parent::__construct();
        $this->permission = $permission;
        $this->purchaseorder = $purchaseorder;
    }

    /**
     * @return \Illuminate\View\View
     */
   public function index()
    {

        $filterdate = function ($query)  {

            $start_date = \Request::get('start_date');

            $end_date = \Request::get('end_date');

            if($start_date && $end_date){

                return $query->where('bill_date','>=',$start_date)
                        ->where('bill_date','<=',$end_date);
            }

        };
        $filterByPayment = function ($query)  {

            $payment= \Request::get('payment');
            $pay_status = \Request::get('pay_status');
            if($pay_status == 'Pending'){

                return $query->where('payment_status','Pending')
                        ->orWhereNull('payment_status')
                        ->orWhere('payment_status','');

            }elseif($pay_status == 'Partial'){

               return $query->where('payment_status','Partial');

            }elseif($pay_status == 'Paid'){

               return $query->where('payment_status','Paid');
            }

            if($payment == 'pending_partial'){

                return $query->whereIn('payment_status',['Pending','Partial',""])
                        ->orWhereNull('payment_status');

            }

        };

        $filterSupplier = function($query){

            $supplier = \Request::get('supplier_id');
            if($supplier){

                return $query->where('supplier_id',$supplier);
            }

        };

        $filterCurrency = function($query){

            $currency = \Request::get('currency');

            if($currency){

                return $query->where('currency',$currency);
            }

        };


        if (\Request::get('type') && \Request::get('type') == 'purchase_orders') {
            $orders = PurchaseOrder::where('purchase_type', 'purchase_orders')
                ->where('org_id', \Auth::user()->org_id)
                ->where(function($query) use ($filterdate){

                    return $filterdate($query);

                })
                ->where(function($query) use ($filterSupplier){

                    return $filterSupplier($query);

                })->where(function($query) use ($filterCurrency){

                    return $filterCurrency($query);

                })
                ->where(function($query) use ($filterByPayment){

                    return $filterByPayment($query);

                })
                ->orderBy('id', 'DESC');
        } elseif (\Request::get('type') && \Request::get('type') == 'request') {
            $orders = PurchaseOrder::where('purchase_type', 'request')
                ->where('org_id', \Auth::user()->org_id)
                ->where(function($query) use ($filterdate){
                    return $filterdate($query);
                })
                  ->where(function($query) use ($filterSupplier){

                    return $filterSupplier($query);

                })->where(function($query) use ($filterCurrency){

                    return $filterCurrency($query);

                })->where(function($query) use ($filterByPayment){

                    return $filterByPayment($query);

                })
                ->orderBy('id', 'DESC');
        } elseif (\Request::get('type') && \Request::get('type') == 'bills') {
            $orders = PurchaseOrder::where('purchase_type', 'bills')
                ->where('org_id', \Auth::user()->org_id)
                ->where(function($query) use ($filterdate){
                    return $filterdate($query);
                })
                  ->where(function($query) use ($filterSupplier){

                    return $filterSupplier($query);

                })->where(function($query) use ($filterCurrency){

                    return $filterCurrency($query);

                })->where(function($query) use ($filterByPayment){

                    return $filterByPayment($query);

                })
                ->orderBy('id', 'DESC');
        } else {
            $orders = PurchaseOrder::orderBy('id', 'desc')
                ->where('org_id', \Auth::user()->org_id)
                ->where(function($query) use ($filterdate){
                    return $filterdate($query);
                })
                  ->where(function($query) use ($filterSupplier){

                    return $filterSupplier($query);

                })->where(function($query) use ($filterByPayment){

                    return $filterByPayment($query);

                })
                ->where(function($query) use ($filterCurrency){

                    return $filterCurrency($query);

                });
        }

        if(\Request::get('search') && \Request::get('search') == 'true'){

            $orders =  $orders->get();


        }else{

            $orders =  $orders->paginate(40);
        }

        $page_title = ' Purchase Orders';
        $page_description = 'Manage Purchase Orders';
        $suppliers = Client::where('relation_type','supplier')->pluck('name','id')->all();
        $currency = \App\Models\Country::whereEnabled('1')->pluck('currency_name','currency_code as id')->all();


        return view('admin.purchase.index', compact('orders','currency', 'page_title', 'page_description','suppliers'));
    }


    /**
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $ord = $this->purchaseorder->find($id);
        $page_title = 'Purchase';
        $page_description = 'View Purchase';
        $orderDetails = PurchaseOrderDetail::where('order_no', $ord->id)->get();
        //dd($orderDetails);
        $imagepath = \Auth::user()->organization->logo;
        // dd($imagepath);

        return view('admin.purchase.show', compact('ord', 'imagepath', 'page_title', 'page_description', 'orderDetails'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page_title = 'Purchase Orders';
        $page_description = 'Add Purchase Orders';
        $order = null;
        $orderDetail = null;

        $users = \App\User::where('enabled', '1')->where('org_id', \Auth::user()->org_id)->pluck('first_name', 'id');

        $order_count = DB::table('purch_orders')->count();

        $prod_unit = \App\Models\ProductsUnit::all();

        if (\Request::get('type') == 'assets') {
            $products = Product::select('id', 'name')->where('type','!=','service')->where('is_fixed_assets', '1')->get();
        } else {
            $products = Product::select('id', 'name')->where('type','!=','service')->where('is_fixed_assets', '0')->get();
        }

        if ($order_count > 0) {
            $orderReference = DB::table('purch_orders')->select('reference')->orderBy('id', 'DESC')->first();
            $ref = explode('-', $orderReference->reference);

            $order_count = (int) $ref[1];
        } else {
            $order_count = 0;
        }

        $productlocation = \App\Models\ProductLocation::pluck('location_name', 'id')->all();
        $clients = Client::select('id', 'name', 'location', 'vat')
            ->where('relation_type', 'supplier')
            ->orderBy('id', 'DESC')->get();

        $paid_through = \App\Models\COALedgers::where(
            'group_id',
            \FinanceHelper::get_ledger_id('CASH_EQUIVALENTS')
        )->get();
        $projects = \App\Models\Projects::pluck('name', 'id')->all();
        $fiscal_years = \App\Models\Fiscalyear::pluck('fiscal_year as name', 'id')->all();
        //$currency = \DB::select("`select * from countries order by -display_order DESC`");
        $currency = \App\Models\Country::select('*')->whereEnabled('1')->orderByDesc('id')->get();
        //dd($currency);

        return view('admin.purchase.create', compact('page_title', 'productlocation', 'users', 'order_count', 'page_description', 'order', 'orderDetail', 'products', 'clients', 'prod_unit', 'projects', 'paid_through', 'fiscal_years','currency'));
    }

    private function convertdate($date)
    {
        $cal = new \App\Helpers\NepaliCalendar();
        $converted = explode('-', $date);
        $converted = $cal->nep_to_eng($converted[0], $converted[1], $converted[2]);
        $converted_date = $converted['year'] . '-' . $converted['month'] . '-' . $converted['date'];

        return $converted_date;
    }
 public function store(Request $request)
    {
       \DB::beginTransaction();

        $order_attributes = $request->all();

        if ($request->fiscal_year && $request->fiscal_year != '' && \Auth::user()->hasRole('admins')) {
            $fiscal_year = \App\Models\Fiscalyear::findOrFail($request->fiscal_year);
        } else {
            $fiscal_year = \App\Models\Fiscalyear::where('current_year', '1')->first();
        }
        $order_attributes['org_id'] = \Auth::user()->org_id;
        $order_attributes['supplier_id'] = $request->customer_id;
        $order_attributes['tax_amount'] = $request->taxable_tax;
        $order_attributes['total'] = $request->final_total;
        $order_attributes['ledger_id'] = (\App\Models\Client::find($request->customer_id))->ledger_id ?? null;
        $order_attributes['fiscal_year'] = $fiscal_year->fiscal_year;
        $order_attributes['fiscal_year_id'] = $fiscal_year->id;
        $purchaseorder = PurchaseOrder::create($order_attributes);

        $order_no = $purchaseorder->id;

        $product_id = $request->product_id;
        //dd($product_ids);
        $price = $request->price;
        $quantity = $request->quantity;
        $tax = $request->tax;
        $tax_amount = $request->tax_amount;
        $total = $request->total;
        $isBills = false;
        if (\Request::get('purchase_type') == 'bills' || \Request::get('purchase_type') == 'assets') {
            $isBills = true;
            $this->updateEntries($purchaseorder->id);
        }
        foreach ($product_id as $key => $value) {
            if ($value != '') {
                $detail = new PurchaseOrderDetail();
                $detail->suplier_id = $request->customer_id;
                $detail->order_no = $order_no;
                $detail->product_id = $product_id[$key];
                $detail->unit_price = $price[$key];
                $detail->qty_invoiced = $quantity[$key];
                $detail->quantity_ordered = $quantity[$key];
                $detail->quantity_recieved = $quantity[$key];
                $detail->tax_type_id = $tax[$key] ?? null;
                $detail->total = $total[$key];
                $detail->units = $request->units[$key];
                $detail->is_inventory = 1;
                $detail->tax_type = $request->tax_type[$key];
                $detail->tax_amount = $request->tax_amount[$key];
                $detail->dis_amount = $request->dis_amount[$key];
                $detail->save();
//                if($isBills){
//                    // stockMove information
//                    $stockMove = new StockMove();
//                    $stockMove->stock_id = $product_id[$key];
//                    $stockMove->trans_type = PURCHINVOICE;
//                    $stockMove->tran_date = \Carbon\Carbon::now();
//                    $stockMove->user_id = \Auth::user()->id;
//                    $stockMove->reference = 'store_in_' . $order_no;
//                    $stockMove->transaction_reference_id = $order_no;
//                    $stockMove->location = $request->into_stock_location;
//                    $stockMove->qty = $quantity[$key];
//                    $stockMove->price = $price[$key];
//                    $stockMove->save();
//                }

            }
        }

        // Custom items
        $tax_id_custom = $request->custom_tax_amount;
        $custom_items_name = $request->custom_items_name;
        $custom_items_rate = $request->custom_items_rate;
        $custom_items_qty = $request->custom_items_qty;
        $custom_items_price = $request->custom_items_price;
        $custom_tax_amount = $request->custom_tax_amount;
        $custom_total = $request->custom_total;

        foreach ($custom_items_name ?? [] as $key => $value) {
            if ($value != '') {
                $detail = new PurchaseOrderDetail();
                $detail->suplier_id = $request->customer_id;
                $detail->order_no = $order_no;
                $detail->description = $custom_items_name[$key];
                $detail->unit_price = $custom_items_price[$key];
                $detail->qty_invoiced = $custom_items_qty[$key];
                $detail->quantity_ordered = $custom_items_qty[$key];
                $detail->quantity_recieved = $custom_items_qty[$key];
                $detail->tax_type_id = $tax_id_custom[$key];
                $detail->units = $request->custome_unit[$key];

                $detail->tax_type = $request->custom_tax_type[$key];
                $detail->tax_amount = $request->custom_tax_amount[$key];
                $detail->dis_amount = $request->custom_dis_amount[$key];

                // $detail->tax_amount = $custom_tax_amount[$key];
                $detail->total = $custom_total[$key];
                // $detail->date = date('Y-m-d H:i:s');
                $detail->is_inventory = 0;
                //  dd($detail);
                $detail->save();
            }
        }



        /*
                LEDGER SHOULD UPDATE ONLY AFTER PURCHASE CONFIRMATION
                 //ENTRY FOR Total AMOUNT
                $entry = \App\Models\Entry::create([
                    'tag_id'=>'20',
                    'entrytype_id'=>'6',
                    'number'=>$invoice->id,
                    'org_id'=>\Auth::user()->org_id,
                    'user_id'=>\Auth::user()->id,
                    'date'=>date('Y-m-d'),
                    'dr_total'=>$request->final_total,
                    'cr_total'=>$request->final_total,
                    'source' => 'Auto Purchase'
                ]);

                $supplier = \App\Models\Client::find($purchaseorder->supplier_id);


                //send total to sales ledger
                $entry_item = \App\Models\Entryitem::create([
                    'entry_id'=>$entry->id,
                    'dc'=>'D',
                    'ledger_id'=> '41', //purchase Ledger
                    'amount'=>$request->final_total,
                    'narration'=>'Purchase being made'
                ]);
                //send amount before tax to customer ledger
                $entry_item = \App\Models\Entryitem::create([
                    'entry_id'=>$entry->id,
                    'dc'=>'C',
                    'ledger_id'=>$supplier->ledger_id,
                    'amount'=>$request->taxable_amount,
                    'narration'=>'Purchase being made'
                ]);

                //send the taxable amount to SALES TAX LEDGER
                $entry_item = \App\Models\Entryitem::create([
                    'entry_id'=>$entry->id,
                    'dc'=>'C',
                    'ledger_id'=> '32', //Purchase Tax Ledger
                    'amount'=>$request->taxable_tax,
                    'narration'=>'Tax to pay'
                ]);

              **/

        Flash::success('Purchase Order created Successfully.');

        if (\Request::get('purchase_type') && \Request::get('purchase_type') == 'purchase_orders') {
            $type = 'purchase_orders';
        } elseif (\Request::get('purchase_type') && \Request::get('purchase_type') == 'request') {
            $type = 'request';
        } elseif (\Request::get('purchase_type') && \Request::get('purchase_type') == 'bills') {
            $type = 'bills';
        } elseif (\Request::get('purchase_type') && \Request::get('purchase_type') == 'assets') {
            $type = 'assets';
        } else {
            Flash::warning('Purchase Type Could Not detected');
            $type = 'purchase_orders';
        }
        \DB::commit();
        // $this->ConfirmPurchase($purchaseorder,true);
        //dd("DO");

        return redirect('/admin/purchase?type=' . $type);
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = 'Purchase';
        $page_description = 'Edit Purchase';
        $order = PurchaseOrder::where('id', $id)->first();
        if(!$order->isEditable()){
            abort(403);
        }


        $orderDetails = PurchaseOrderDetail::where('order_no', $id)->get();

        if (\Request::get('type') == 'assets') {
            $products = Product::select('id', 'name')->where('type','!=','service')->where('is_fixed_assets', '1')->get();
        } else {
            $products = Product::select('id', 'name')->where('type','!=','service')->where('is_fixed_assets', '0')->get();
        }

        $clients = Client::select('id', 'name', 'location', 'vat')
            ->where('relation_type', 'supplier')
            ->orderBy('id', 'DESC')->get();
        //$clients = Lead::select('id', 'name', 'organization')->orderBy('id', DESC)->get();
        $users = \App\User::where('enabled', '1')->where('org_id', \Auth::user()->org_id)->pluck('first_name', 'id');

        $productlocation = \App\Models\ProductLocation::pluck('location_name', 'id')->all();
        $prod_unit = \App\Models\ProductsUnit::all();

        $projects = \App\Models\Projects::pluck('name', 'id')->all();
        $paid_through = \App\Models\COALedgers::where(
            'group_id',
            \FinanceHelper::get_ledger_id('CASH_EQUIVALENTS')
        )->get();
        $fiscal_years = \App\Models\Fiscalyear::pluck('fiscal_year as name', 'id')->all();
        $currency = \App\Models\Country::select('*')->whereEnabled('1')->orderByDesc('id')->get();
        return view('admin.purchase.edit', compact('page_title', 'users', 'page_description', 'productlocation', 'order', 'orderDetails', 'products', 'clients', 'prod_unit', 'projects', 'paid_through', 'fiscal_years','currency'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        if (\Request::get('purchase_type') == 'bills' || \Request::get('purchase_type') == 'assets') {
            $this->validate($request, [
                'customer_id' => 'required',
                'purchase_type' => 'required',
            ]);
        }

        $purchaseorder = PurchaseOrder::find($id);

        if ($purchaseorder->isEditable()) {
            $order_attributes = $request->all();
            if (\Auth::user()->hasRole('admins')) {
                $fiscal_year = \App\Models\Fiscalyear::findOrFail($request->fiscal_year);
                $order_attributes['fiscal_year'] = $fiscal_year->fiscal_year;
                $order_attributes['fiscal_year_id'] = $fiscal_year->id;
                //dd($order_attributes);
            }

            if ($request->datetype == 'nep') {
                $order_attributes['bill_date'] = $this->convertdate($order_attributes['bill_date']);
                $order_attributes['due_date'] = $this->convertdate($order_attributes['due_date']);
            }

            $order_attributes['org_id'] = \Auth::user()->org_id;
            $order_attributes['supplier_id'] = $request->customer_id;
            $order_attributes['tax_amount'] = $request->taxable_tax;
            $order_attributes['total'] = $request->final_total;
            $order_attributes['ledger_id'] = (\App\Models\Client::find($request->customer_id))
                ->ledger_id ?? null;


            $purchaseorder->update($order_attributes);

            $purchasedetails = PurchaseOrderDetail::where('order_no', $purchaseorder->id)->get();

//            foreach ($purchasedetails as $pd) {
//                $stockmove = StockMove::where('trans_type', PURCHINVOICE)->where('stock_id', $pd->product_id)->where('reference', 'store_in_' . $purchaseorder->id)->delete();
//            }
            //dd($stockmove);

            $purchasedetails = PurchaseOrderDetail::where('order_no', $purchaseorder->id)->delete();

            PurchaseOrderDetail::where('order_no', $purchaseorder->id)->delete();

            $product_id = $request->product_id;

            $price = $request->price;
            $quantity = $request->quantity;
            $tax = $request->tax;
            $tax_amount = $request->tax_amount;
            $total = $request->total;
            // dd($request->order_id);
            $isBills = false;
            if (\Request::get('purchase_type') == 'bills' || \Request::get('purchase_type') == 'assets') {
                $isBills = true;
                $this->updateEntries($id);
            }
            foreach ($product_id as $key => $value) {
                if ($value != '') {
                    $detail = new PurchaseOrderDetail();
                    $detail->suplier_id = $request->customer_id;
                    $detail->order_no = $request->order_no;
                    $detail->product_id = $product_id[$key];
                    $detail->unit_price = $price[$key];
                    $detail->qty_invoiced = $quantity[$key];
                    $detail->quantity_ordered = $quantity[$key];
                    $detail->quantity_recieved = $quantity[$key];
                    $detail->tax_type_id = $tax[$key] ?? null;
                    $detail->units = $request->units[$key];
                    $detail->total = $total[$key];
                    $detail->tax_type = $request->tax_type[$key];
                    $detail->tax_amount = $request->tax_amount[$key];
                    $detail->dis_amount = $request->dis_amount[$key];

                    $detail->is_inventory = 1;
                    // $detail->date = date('Y-m-d H:i:s');
                    $detail->save();
//                    if($isBills){
//                        // stockMove information
//                        $stockMove = new StockMove();
//                        $stockMove->stock_id = $product_id[$key];
//                        $stockMove->trans_type = PURCHINVOICE;
//                        $stockMove->tran_date = \Carbon\Carbon::now();
//                        $stockMove->user_id = \Auth::user()->id;
//                        $stockMove->reference = 'store_in_' . $request->order_no;
//                        $stockMove->transaction_reference_id = $request->order_no;
//                        $stockMove->qty = $quantity[$key];
//                        $stockMove->location = $request->into_stock_location;
//                        $stockMove->price = $price[$key];
//                        $stockMove->save();
//                    }

                }
            }

            $description_custom = $request->description_custom;

            $price_custom = $request->price_custom;
            $quantity_custom = $request->quantity_custom;
            $tax_custom = $request->tax_custom;
            $tax_amount_custom = $request->tax_amount_custom;
            $total_custom = $request->total_custom;

            foreach ($description_custom ?? [] as $key => $value) {
                if ($value != '') {
                    $detail = new PurchaseOrderDetail();
                    $detail->suplier_id = $request->customer_id;
                    $detail->order_no = $request->order_no;
                    $detail->description = $description_custom[$key];
                    $detail->unit_price = $price_custom[$key];
                    $detail->qty_invoiced = $quantity_custom[$key];
                    $detail->quantity_ordered = $quantity_custom[$key];
                    $detail->quantity_recieved = $quantity_custom[$key];
                    $detail->units = $request->custome_unit[$key];
                    $detail->tax_type_id = $tax_custom[$key];

                    $detail->dis_amount = $request->custom_dis_amount[$key];
                    $detail->tax_type = $request->custome_tax_type[$key];

                    $detail->tax_amount = $request->custome_tax_amount[$key];

                    $detail->total = $total_custom[$key];
                    $detail->is_inventory = 0;
                    //$detail->date = date('Y-m-d H:i:s');
                    //  dd($detail);

                    $detail->save();
                }
            }

            if ($request->product_id_new != null) {

                // dd($request->description_new);
                $product_id_new = $request->product_id_new;
                $ticket_new = $request->ticket_new;
                $price_new = $request->price_new;
                $quantity_new = $request->quantity_new;
                $flight_date_new = $request->flight_date_new;
                $tax_new = $request->tax_new;
                $tax_amount_new = $request->tax_amount_new;
                $total_new = $request->total_new;

                foreach ($product_id_new as $key => $value) {
                    $detail = new PurchaseOrderDetail();
                    $detail->suplier_id = $request->customer_id;
                    $detail->order_no = $request->order_no;
                    $detail->product_id = $product_id_new[$key];
                    $detail->unit_price = $price_new[$key];
                    $detail->qty_invoiced = $quantity_new[$key];
                    $detail->quantity_ordered = $quantity_new[$key];
                    $detail->quantity_recieved = $quantity_new[$key];
                    $detail->tax_type_id = $tax_new[$key];
                    $detail->units = $request->units_new[$key];
                    $detail->total = $total_new[$key];
                    $detail->tax_type = $request->tax_type_new[$key];
                    $detail->tax_amount = $request->tax_amount_new[$key];
                    $detail->dis_amount = $request->dis_amount_new[$key];
                    $detail->is_inventory = 1;
                    //$detail->date = date('Y-m-d H:i:s');

                    // dd($detail);
                    $detail->save();
//                    if($isBills){
//                        // stockMove information
//                        $stockMove = new StockMove();
//                        $stockMove->stock_id = $product_id_new[$key];
//                        $stockMove->trans_type = PURCHINVOICE;
//                        $stockMove->tran_date = \Carbon\Carbon::now();
//                        $stockMove->user_id = \Auth::user()->id;
//                        $stockMove->reference = 'store_in_' . $request->order_no;
//                        $stockMove->transaction_reference_id = $request->order_no;
//                        $stockMove->qty = $quantity_new[$key];
//                        $stockMove->price = $price_new[$key];
//                        $stockMove->location = $request->into_stock_location;
//                        $stockMove->save();
//                    }
                }
            }

            // Custom items Start
            $custom_items_name_new = $request->custom_items_name_new;
            $custom_ticket_new = $request->custom_ticket_new;
            $custom_items_price_new = $request->custom_items_price_new;
            $custom_items_qty_new = $request->custom_items_qty_new;
            $custom_flight_date_new = $request->custom_flight_date_new;
            $tax_id_custom_new = $request->tax_id_custom_new;
            $custom_tax_amount_new = $request->custom_tax_amount_new;
            $custom_total_new = $request->custom_total_new;

            if (!empty($custom_items_name_new)) {
                foreach ($custom_items_name_new as $key => $value) {
                    $detail = new PurchaseOrderDetail();
                    $detail->suplier_id = $request->customer_id;
                    $detail->order_no = $request->order_no;
                    $detail->description = $custom_items_name_new[$key];
                    $detail->unit_price = $custom_items_price_new[$key];
                    $detail->qty_invoiced = $custom_items_qty_new[$key];
                    $detail->quantity_ordered = $custom_items_qty_new[$key];
                    $detail->quantity_recieved = $custom_items_qty_new[$key];
                    $detail->tax_type_id = $tax_id_custom_new[$key];
                    $detail->total = $custom_total_new[$key];
                    $detail->units = $request->custom_units_new[$key];

                    $detail->tax_type = $request->custom_tax_type_new[$key];
                    $detail->tax_amount = $request->custom_tax_amount_new[$key];

                    $detail->dis_amount = $request->custom_dis_amount_new[$key];
                    $detail->is_inventory = 0;
                    //$detail->date = date('Y-m-d H:i:s');
                    $detail->save();
                }
            }


            Flash::success('Purchase updated Successfully.');

            if (\Request::get('purchase_type') && \Request::get('purchase_type') == 'purchase_orders') {
                $type = 'purchase_orders';
            } elseif (\Request::get('purchase_type') && \Request::get('purchase_type') == 'request') {
                $type = 'request';
            } elseif (\Request::get('purchase_type') && \Request::get('purchase_type') == 'bills') {
                $type = 'bills';
            } elseif (\Request::get('purchase_type') && \Request::get('purchase_type') == 'assets') {
                $type = 'assets';
            } else {
                $type = 'purchase_orders';
            }
            DB::commit();

            return redirect()->back();
        } else {
            Flash::success('Error in updating Purchase.');
        }
        DB::commit();

        return \Redirect::back()->withInput(\Request::all());
    }
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $purchaseorder = $this->purchaseorder->find($id);
        $purchasedetails = PurchaseOrderDetail::where('order_no', $purchaseorder->id)->get();

        if (!$purchaseorder->isdeletable()) {
            abort(403);
        }

        $purchaseorder->delete();
        PurchaseOrderDetail::where('order_no', $id)->delete();

        foreach ($purchasedetails as $pd) {
            $stockmove = StockMove::where('trans_type', PURCHINVOICE)->where('stock_id', $pd->product_id)->where('reference', 'store_in_' . $purchaseorder->id)->delete();
        }

        if ($purchaseorder->entry_id != '') {
            $entries = \App\Models\Entry::find($purchaseorder->entry_id);
            \App\Models\Entryitem::where('entry_id', $entries->id)->delete();
            \App\Models\Entry::find($purchaseorder->entry_id)->delete();
        }

        MasterComments::where('type', 'orders')->where('master_id', $id)->delete();

        Flash::success(' successfully deleted.');

        if (\Request::get('type')) {
            return redirect('/admin/purchase?type=' . \Request::get('type'));
        }

        return redirect('/admin/purchase?type=purchase_orders');
    }

    public function getProductDetailAjax($productId)
    {
        $product = Course::select('id', 'name', 'price', 'cost')->where('id', $productId)->first();

        return ['data' => json_encode($product)];
    }

    /**
     * Delete Confirm.
     *
     * @param   int   $id
     * @return  View
     */
    public function getModalDelete($id)
    {
        $error = null;

        $purchaseorder = $this->purchaseorder->find($id);

        if (!$purchaseorder->isdeletable()) {
            abort(403);
        }

        $modal_title = 'Delete Purchase';

        $purchaseorder = $this->purchaseorder->find($id);
        if (\Request::get('type')) {
            $modal_route = route('admin.purchase.delete', ['orderId' => $purchaseorder->id]) . '?type=' . \Request::get('type');
        } else {
            $modal_route = route('admin.purchase.delete', ['orderId' => $purchaseorder->id]);
        }

        $modal_body = 'Are you sure you want to delete this purchase order?';

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));
    }

    public function printInvoice($id)
    {
        $ord = $this->purchaseorder->find($id);
        $orderDetails = PurchaseOrderDetail::where('order_no', $id)->get();
        //dd($orderDetails);
        $imagepath = \Auth::user()->organization->logo;

        return view('admin.purchase.print', compact('ord', 'imagepath', 'orderDetails'));
    }

    public function generatePDF($id)
    {
        $ord = $this->purchaseorder->find($id);
        $orderDetails = PurchaseOrderDetail::where('order_no', $id)->get();
        $imagepath = \Auth::user()->organization->logo;

        $pdf = \PDF::loadView('admin.purchase.generateInvoicePDF', compact('ord', 'imagepath', 'orderDetails'));
        $file = $id . '_' . str_replace(' ', '_', $ord->client->name) . '.pdf';

        if (\File::exists('reports/' . $file)) {
            \File::Delete('reports/' . $file);
        }

        return $pdf->download($file);
    }

    public function sendMail($id)
    {
        $ord = $this->purchaseorder->find($id);
        $orderDetails = PurchaseOrderDetail::where('order_no', $id)->get();
        $imagepath = \Auth::user()->organization->logo;
        $pdf = \PDF::loadView('admin.purchase.generateInvoicePDF', compact('ord', 'imagepath', 'orderDetails'));
        try {
            $from = env('APP_EMAIL');
            $to = $ord->client->email;
            $file = $id . '_' . str_replace(' ', '_', $ord->client->name) . '.pdf';
            $mail = \Mail::send(
                'admin.purchase.email',
                compact('data'),
                function ($message) use ($ord, $from, $to, $pdf, $file) {
                    $message->subject('Purchase Info - ' . ucfirst($ord->purchase_type) . ' ' . date('Y-m-d'));
                    $message->from($from, env('APP_COMPANY'));
                    $message->to($to, '');
                    $message->attachData($pdf->output(), $file);
                }
            );
            Flash::success('Mail sucessfully sent');
        } catch (\Exception $e) {
            echo $e;
            Flash::error('Error in sending mails : Invaild Email');
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return array|static[]
     */
    public function searchByName(Request $request)
    {
        $return_arr = null;

        $query = $request->input('query');

        $orders = $this->orders->pushCriteria(new ordersWhereDisplayNameLike($query))->all();

        foreach ($orders as $orders) {
            $id = $orders->id;
            $name = $orders->name;
            $email = $orders->email;

            $entry_arr = ['id' => $id, 'text' => "$name ($email)"];
            $return_arr[] = $entry_arr;
        }

        return $return_arr;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getInfo(Request $request)
    {
        $id = $request->input('id');
        $orders = $this->orders->find($id);

        return $orders;
    }

    public function get_client()
    {
        $term = strtolower(\Request::get('term'));
        $contacts = ClientModel::select('id', 'name')->where('name', 'LIKE', '%' . $term . '%')->groupBy('name')->take(5)->get();
        $return_array = [];

        foreach ($contacts as $v) {
            if (strpos(strtolower($v->name), $term) !== false) {
                $return_array[] = ['value' => $v->name, 'id' => $v->id];
            }
        }

        return \Response::json($return_array);
    }

    /**
     * Check reference no if exists.
     */
    public function referenceValidation(Request $request)
    {
        $data = [];
        $ref = $request['ref'];
        $result = DB::table('purch_orders')->where('reference', $ref)->first();

        if (count($result) > 0) {
            $data['status_no'] = 1;
        } else {
            $data['status_no'] = 0;
        }

        return json_encode($data);
    }

    public function PurchasePayment()
    {
        $page_title = 'Purchase Payment List';
        $page_description = 'Listing of all purchase Payments';

        $payment_list = \App\Models\Payment::orderBy('id', 'desc')
                        ->whereNotNull('purchase_id')->get()->groupBy('purchase_id');

        $purchaseToPay = PurchaseOrder::whereIn('payment_status',['Pending','Partial'])

                ->orWhereNull('payment_status')
                ->get();


        return view('admin.purchase.allpurchaselist', compact('page_title', 'page_description', 'payment_list','purchaseToPay'));
    }

    public function PurchasePaymentPdf()
    {
        $payment_list = \App\Models\Payment::orderBy('id', 'desc')->whereNotNull('purchase_id')->get();
        $pdf = \PDF::loadView('admin.purchase.purchasepaymentpdf', compact('payment_list'));
        $file = 'purchase_payment' . date('_Y_m_d') . '.pdf';

        if (\File::exists('reports/' . $file)) {
            \File::Delete('reports/' . $file);
        }

        return $pdf->download($file);
    }

    public function addtoStockMoves($order_id){
        $order = PurchaseOrder::find($order_id);

        $ordersDetails = \App\Models\PurchaseOrderDetail::where('order_no',$order_id)
                        ->get();

        foreach ($ordersDetails as $key => $value) {

            $stockMove = new StockMove();
            $stockMove->order_no = $order_id;
            $stockMove->stock_id = $value->product_id;
            $stockMove->trans_type = PURCHINVOICE;
            $stockMove->tran_date = \Carbon\Carbon::now();
            $stockMove->user_id = \Auth::user()->id;
            $stockMove->reference = 'store_in_' . $order_id;
            $stockMove->transaction_reference_id = $order_id;
            $stockMove->location = $order->into_stock_location;
            $stockMove->qty = $value->quantity_ordered;
            $stockMove->price = $value->unit_price;
            $stockMove->save();
        }
        return false;
    }

    public function ConfirmPurchase($id, $direct_create_bill = false)
    {

        if ($direct_create_bill) {
            $confirm_purchase = $id;
        } else {
            $confirm_purchase = $this->purchaseorder->find($id);
        }
        //dd($confirm_purchase);
        if (!$confirm_purchase->ledger_id) {
            Flash::warning('Please select the legder id');

            return \Redirect::back();
        }

        $confirm_purchase->update([
            'purchase_type' => 'bills',
            'status' => 'Billed',
        ]);
        $this->addtoStockMoves($id);
        $this->updateEntries($confirm_purchase->id);

        Flash::success('Successfully updated !!');

        return \Redirect::back();
    }

    public function ConfirmPostToPO($id, $direct_create_bill = false)
    {
        $confirm_purchase = $this->purchaseorder->find($id);
        $confirm_purchase->update([
            'purchase_type' => 'purchase_orders',
        ]);

        Flash::success('Successfully posted to Purchase Order !!');

        return \Redirect::back();
    }

    public function ConfirmPurchaseModel($id)
    {
        $error = null;
        $purchaseorder = $this->purchaseorder->find($id);

        // if (!$attraction->isdeletable())
        // {
        //     abort(403);
        // }
        $modal_title = 'Confirm';
        $modal_body = 'Are you sure that you want to  convert this order with ID: ' . $purchaseorder->id . 'to bill?';
        $modal_route = route('admin.confirm-purchase', $purchaseorder->id);

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));
    }

    public function getPanNUM($id)
    {
        $get_vat_no = \App\Models\Client::find($id);

        return response()->json(['pan_no' => $get_vat_no->vat,'physical_address'=>$get_vat_no->physical_address]);
    }

   public function PurchaseBook(Request $request)
    {
        $page_title = 'Admin | purchasebook';
        $op = \Request::get('op');

        $fiscal_year = (\App\Models\Fiscalyear::where('current_year', '1')->first())->fiscal_year;
        if (\Request::has('filter')) {
            if ($request->filter == 'nep') {                 //for nepali ?
                $startdate = $request->nepstartdate;
                $enddate = $request->nependdate;
                $cal = new \App\Helpers\NepaliCalendar();
                $startdate = $cal->nep_to_eng_digit_conversion($startdate);
                $date = $cal->nep_to_eng($startdate[0], $startdate[1], $startdate[2]);
                $startdate = $date['year'] . '-' . $date['month'] . '-' . $date['date'];
                $enddate = $cal->nep_to_eng_digit_conversion($enddate);
                $date = $cal->nep_to_eng($enddate[0], $enddate[1], $enddate[2]);
                $enddate = $date['year'] . '-' . $date['month'] . '-' . $date['date'];
            } else {
                $startdate = $request->engstartdate;
                $enddate = $request->engenddate;
            }
            if ($op == 'pdf') {
                $purchase_book = \App\Models\PurchaseOrder::where('bill_date', '>=', $startdate)
                    ->where('bill_date', '<=', $enddate)
                    ->where('purchase_type', 'bills')
                    ->get();
                $pdf = \PDF::loadView('pdf.filteredpurchase', compact('purchase_book', 'fiscal_year', 'startdate', 'enddate'));
                $file = 'Report_salebook_filtered' . date('_Y_m_d') . '.pdf';
                if (\File::exists('reports/' . $file)) {
                    \File::Delete('reports/' . $file);
                }

                return $pdf->download($file);
            }
            if ($op == 'excel') {
                $data = DB::select("select purch_orders.id as SN , purch_orders.bill_no as 'Bill Num', clients.name as 'Supplier’s Name',clients.vat as 'Supl. PAN Number','' as 'Total Purchase','' as 'Non Tax Purchase','' as 'Exp. Purchase','' as Discount ,purch_orders.taxable_amount as Amount,purch_orders.tax_amount as 'Tax(Rs)' from purch_orders LEFT JOIN clients ON clients.id = purch_orders.supplier_id where purch_orders.ord_date >= '$startdate' AND purch_orders.ord_date <= '$enddate' AND purch_orders.purchase_type ='bills' ");
                $data = json_decode(json_encode($data), true);

                return \Excel::download(new \App\Exports\ExcelExport($data), 'purchase.csv');
            }
            $purchase_book = \App\Models\PurchaseOrder::with('return_bills')->where('purchase_type', 'bills')
                ->where('bill_date', '>=', $startdate)
                ->where('bill_date', '<=', $enddate)
                ->paginate(50);
        } else {
            if ($op == 'pdf') {
                $purchase_book = \App\Models\PurchaseOrder::where('purchase_type', 'bills')->get();
                $pdf = \PDF::loadView('pdf.filteredpurchase', compact('purchase_book', 'fiscal_year'));
                $file = 'Report_salebook_filtered' . date('_Y_m_d') . '.pdf';
                if (\File::exists('reports/' . $file)) {
                    \File::Delete('reports/' . $file);
                }

                return $pdf->download($file);
            }
            if ($op == 'excel') {
                $data = DB::select("select purch_orders.id as SN , purch_orders.bill_no as 'Bill Num', clients.name as 'Supplier’s Name',clients.vat as 'Supl. PAN Number',purch_orders.total as 'Total Purchase',purch_orders.non_taxable_amount as 'Non Tax Purchase','' as 'Exp. Purchase',purch_orders.discount_amount as Discount ,purch_orders.taxable_amount as Amount,purch_orders.tax_amount as 'Tax(Rs)' from purch_orders LEFT JOIN clients ON clients.id = purch_orders.supplier_id where purch_orders.purchase_type ='bills' ");
                $data = json_decode(json_encode($data), true);

                return \Excel::download(new \App\Exports\ExcelExport($data, false), 'purchase.csv');
            }

            $purchase_book = \App\Models\PurchaseOrder::with('return_bills')->where('purchase_type', 'bills')->paginate(50);

        }

        return view('admin.purchase-book.index', compact('purchase_book', 'page_title', 'fiscal_year'));
    }

    public function PurchaseBookByMonths($month)
    {
        $page_title = 'Admin | purchasebook';
        $fiscal_year = (\App\Models\Fiscalyear::where('current_year', '1')->first())->fiscal_year;
        $fiscal_y = substr($fiscal_year, 0, 4);
        $cal = new \App\Helpers\NepaliCalendar();
        $days_list = $cal->bs;
        if ($month < 4) {
            $year = $fiscal_y + 1;
        } else {
            $year = $fiscal_y;
        }

        $year_array = $days_list[$year - 2000];
        $start = $cal->nep_to_eng($year, $month, 1);
        $end = $cal->nep_to_eng($year, $month, $year_array[(int) $month]);
        $startdate = $start['year'] . '-' . $start['month'] . '-' . $start['date'];
        $enddate = $end['year'] . '-' . $end['month'] . '-' . $end['date'];
        if (\Request::has('op')) {
            $op = \Request::get('op');
            $months = (int) $month;
            if ($op == 'pdf') {
                $purchase_book = \App\Models\PurchaseOrder::where('bill_date', '>=', $startdate)
                    ->where('bill_date', '<=', $enddate)
                    ->where('purchase_type', 'bills')
                    ->get();
                $pdf = \PDF::loadView('pdf.filteredpurchase', compact('purchase_book', 'fiscal_year'));
                $file = 'Report_salebook_filtered' . date('_Y_m_d') . '.pdf';
                if (\File::exists('reports/' . $file)) {
                    \File::Delete('reports/' . $file);
                }

                return $pdf->download($file);
            }
            if ($op == 'excel') {
                $data = DB::select("select purch_orders.id as SN , purch_orders.bill_no as 'Bill Num', clients.name as 'Supplier’s Name',clients.vat as 'Supl. PAN Number',purch_orders.total as 'Total Purchase',purch_orders.non_taxable_amount as 'Non Tax Purchase','' as 'Exp. Purchase',purch_orders.discount_amount as Discount ,purch_orders.taxable_amount as Amount,purch_orders.tax_amount as 'Tax(Rs)' from purch_orders LEFT JOIN clients ON clients.id = purch_orders.supplier_id where purch_orders.ord_date >= '$startdate' AND purch_orders.ord_date <= '$enddate' AND purch_orders.purchase_type ='bills' ");
                $data = json_decode(json_encode($data), true);

                return \Excel::download(new \App\Exports\ExcelExport($data), 'purchase.csv');
            }
        }
        $purchase_book = \App\Models\PurchaseOrder::where('purchase_type', 'bills')
            ->where('bill_date', '>=', $startdate)
            ->where('bill_date', '<=', $enddate)
            ->paginate(50);

        return view('admin.purchase-book.index', compact('purchase_book', 'page_title', 'fiscal_year'));
    }
    private function createproductentries($purchaseorder, $entry)
    {
        $products = \App\Models\PurchaseOrderDetail::where('order_no', $purchaseorder->id)->where('is_inventory', '1')->get();
        \App\Models\Entryitem::where('entry_id', $entry->id)->where('dc', 'D')
            ->where('ledger_id', '!=', \FinanceHelper::get_ledger_id('PURCHASE_TAX_PAYABLE'))
            ->delete();
        try {
            foreach ($products as $key => $prod) {
                $cash_amount = new \App\Models\Entryitem();
                $cash_amount->entry_id = $entry->id;
                $cash_amount->user_id = \Auth::user()->id;
                $cash_amount->org_id = \Auth::user()->org_id;
                $cash_amount->dc = 'D';
                $cash_amount->ledger_id = $prod->product->ledger_id; // Purchase ledger if selected or ledgers from .env

                $cash_amount->amount = $prod->total;
                $cash_amount->narration = 'Actual Cost';
                $cash_amount->save();
            }
        } catch (\Exception $e) {
        }

        //dd("OK");
    }
    private function updateEntries($orderId)
    {
        $purchaseorder = $this->purchaseorder->find($orderId);
        $totalAmountBeforeTax = $purchaseorder->taxable_amount + $purchaseorder->non_taxable_amount;
        if ($purchaseorder->supplier_type == 'cash_equivalent') {
            $supplier_ledger_id = $purchaseorder->supplier_id; //supplier_directly coems from ledgers
        } else {
            $supplier_ledger_id = \App\Models\Client::find($purchaseorder->supplier_id)->ledger_id;
        }
        if ($purchaseorder->entry_id && $purchaseorder->entry_id != '0') { //update the ledgers
            $attributes['entrytype_id'] = '16'; //Receipt
            $attributes['tag_id'] = '20'; //Material cost
            $attributes['user_id'] = \Auth::user()->id;
            $attributes['org_id'] = \Auth::user()->org_id;
            $attributes['number'] = \FinanceHelper::get_last_entry_number($attributes['entrytype_id']);
            $attributes['date'] = $purchaseorder->bill_date;
            $attributes['dr_total'] = $purchaseorder->total;
            $attributes['cr_total'] = $purchaseorder->total;
            $attributes['source'] = 'AUTO_PURCHASE_ORDER';
            $attributes['project_id'] = $purchaseorder->project_id;
            $attributes['currency'] = $purchaseorder->currency;
            $entry = \App\Models\Entry::find($purchaseorder->entry_id);
            $attributes['fiscal_year_id'] = $purchaseorder->fiscal_year_id;

            $entry->update($attributes);
            Entryitem::where('entry_id',$entry->id)->delete();

//            // Creddited to Customer or Interest or eq ledger
//            $sub_amount = \App\Models\Entryitem::where('entry_id', $purchaseorder->entry_id)->where('dc', 'C')->first();
//            $sub_amount->entry_id = $entry->id;
//            $sub_amount->user_id = \Auth::user()->id;
//            $sub_amount->org_id = \Auth::user()->org_id;
//            $sub_amount->dc = 'C';
//            $sub_amount->ledger_id = \App\Models\Client::find($purchaseorder->supplier_id)->ledger_id; //Client ledger
//            $sub_amount->amount = $purchaseorder->total;
//            $sub_amount->narration = 'Amount to pay to supplier'; //$request->user_id
//            //dd($sub_amount);
//            $sub_amount->update();
//
//            // Debitte to Bank or cash account that we are already in
//            if ($purchaseorder->purchase_type == 'assets') {
//                $this->createproductentries($purchaseorder, $entry);
//            } else {
//                $cash_amount = \App\Models\Entryitem::where('entry_id', $purchaseorder->entry_id)->where('dc', 'D')
//                    ->where('ledger_id', \FinanceHelper::get_ledger_id('PURCHASE_LEDGER_ID'))->first();
//                $cash_amount->entry_id = $entry->id;
//                $cash_amount->user_id = \Auth::user()->id;
//                $cash_amount->org_id = \Auth::user()->org_id;
//                $cash_amount->dc = 'D';
//                $cash_amount->ledger_id = \FinanceHelper::get_ledger_id('PURCHASE_LEDGER_ID'); // Purchase ledger if selected or ledgers from .env
//                $cash_amount->amount = $totalAmountBeforeTax;
//                $cash_amount->narration = 'Actual Cost';
//                $cash_amount->update();
//            }
//
//            //send to purchase tax ledger
//            $tax_amount = \App\Models\Entryitem::where('entry_id', $purchaseorder->entry_id)->where('dc', 'D')
//                ->where('ledger_id', \FinanceHelper::get_ledger_id('PURCHASE_TAX_PAYABLE'))->first();
//            $tax_amount->entry_id = $entry->id;
//            $tax_amount->user_id = \Auth::user()->id;
//            $tax_amount->org_id = \Auth::user()->org_id;
//            $tax_amount->dc = 'D';
//            $tax_amount->ledger_id = \FinanceHelper::get_ledger_id('PURCHASE_TAX_PAYABLE'); // Purchase ledger if selected or ledgers from .env
//            $tax_amount->amount = $purchaseorder->tax_amount;
//            $tax_amount->narration = 'Vendor Tax amount';
//            $tax_amount->update();
        } else {
            // dd( \App\Models\Client::find($purchaseorder->supplier_id));
            //create the new entry items
            $attributes['entrytype_id'] = '16'; //Receipt
            $attributes['tag_id'] = '20'; //Revenue
            $attributes['user_id'] = \Auth::user()->id;
            $attributes['org_id'] = \Auth::user()->org_id;
            $attributes['number'] = \FinanceHelper::get_last_entry_number($attributes['entrytype_id']);
            $attributes['date'] = $purchaseorder->bill_date;
            $attributes['dr_total'] = $purchaseorder->total;
            $attributes['cr_total'] = $purchaseorder->total;
            $attributes['project_id'] = $purchaseorder->project_id;
            $attributes['source'] = 'AUTO_PURCHASE_ORDER';
            $attributes['fiscal_year_id'] = $purchaseorder->fiscal_year_id;
            $attributes['currency'] = $purchaseorder->currency;
            $entry = \App\Models\Entry::create($attributes);

        }
        // Creddited to Customer or Interest or eq ledger
        $sub_amount = new \App\Models\Entryitem();
        $sub_amount->entry_id = $entry->id;
        $sub_amount->user_id = \Auth::user()->id;
        $sub_amount->org_id = \Auth::user()->org_id;
        $sub_amount->dc = 'C';
        $sub_amount->ledger_id = \App\Models\Client::find($purchaseorder->supplier_id)->ledger_id; //Client ledger
        $sub_amount->amount = $purchaseorder->total;
        $sub_amount->narration = 'Amount to pay to supplier'; //$request->user_id
        //dd($sub_amount);
        $sub_amount->save();

        // Debitte to Bank or cash account that we are already in
        if ($purchaseorder->purchase_type == 'assets') {
            $this->createproductentries($purchaseorder, $entry);
        } else {
            $cash_amount = new \App\Models\Entryitem();
            $cash_amount->entry_id = $entry->id;
            $cash_amount->user_id = \Auth::user()->id;
            $cash_amount->org_id = \Auth::user()->org_id;
            $cash_amount->dc = 'D';
            $cash_amount->ledger_id = \FinanceHelper::get_ledger_id('PURCHASE_LEDGER_ID'); // Purchase ledger if selected or ledgers from .env
            $cash_amount->amount = $totalAmountBeforeTax;
            $cash_amount->narration = 'Actual Cost';
            $cash_amount->save();
        }
        $tax_amount = new \App\Models\Entryitem();
        $tax_amount->entry_id = $entry->id;
        $tax_amount->user_id = \Auth::user()->id;
        $tax_amount->org_id = \Auth::user()->org_id;
        $tax_amount->dc = 'D';
        $tax_amount->ledger_id = \FinanceHelper::get_ledger_id('PURCHASE_TAX_PAYABLE'); // Puchase ledger if selected or ledgers from .env
        $tax_amount->amount = $purchaseorder->tax_amount;
        $tax_amount->narration = 'Vendor Tax Amount';
        $tax_amount->save();


        //now update entry_id in income row
        $purchaseorder->update(['entry_id' => $entry->id]);


        return 0;
    }







}
