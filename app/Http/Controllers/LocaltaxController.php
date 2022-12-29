<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use App\Models\Taxreceipt;
use App\Models\TaxReceiptDetail;
use App\Models\StockMove;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * THIS CONTROLLER IS USED AS PRODUCT CONTROLLER.
 */
class LocaltaxController extends Controller
{
    public function index()
    {
        $localtaxs = \App\Models\Taxreceipt::orderBy('id', 'desc')->get();

        $page_title = 'स्थानीय कर रसिद';
        $page_description = 'सूचीहरू';

        return view('admin.localtax.index', compact('page_title', 'page_description', 'localtaxs'));
    }

    public function create()
    {
        $page_title = 'व्यवस्थापक | स्थानीय कर | सिर्जना गर्नुहोस्';
        $page_description = 'स्थानीय कर सिर्जना गर्न';
        $products = \App\Models\Product::select('id', 'name')->get();
        $units = \App\Models\ProductsUnit::select('id', 'name')->get();
        $authority = \App\User::select('id', 'username')->get();


        return view('admin.localtax.create', compact('page_title', 'page_description', 'products','units','authority'));
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes['user_id']=\auth()->user()->id;
        \DB::beginTransaction();
        $localtax = Taxreceipt::create($attributes);

        $symbol_no = $request->symbol_no;
        $description = $request->description;
        $used_as = $request->used_as;
        $amount = $request->amount;
        $unit = $request->unit;
        $check_no = $request->check_no;

        foreach ($symbol_no as $key => $value) {
            if ($symbol_no[$key] != 0) {
                $detail = new TaxReceiptDetail();
                $detail->tax_receipt_id = $localtax->id;
                $detail->symbol_no = $symbol_no[$key];
                $detail->description = $description[$key];
                $detail->used_as = $used_as[$key];
                $detail->amount = $amount[$key];
                $detail->received_via = $unit[$key];
                $detail->check_no = $check_no[$key];
                $detail->save();
            }
        }
        \DB::commit();

        Flash::success('Localtax created Successfully');

        return redirect('/admin/localtax');
    }

    public function show(Request $request, $id)
    {
        $page_title = 'व्यवस्थापक | स्थानीय कर | विस्तार';
        $page_description = '';

        $localtax = Taxreceipt::find($id);
        $requisitiondetail = Requisition_Detail::where('requisition_id', $localtax->id)->get();

        $users = \App\User::where('enabled', '1')->pluck('username', 'id')->all();
        $products = \App\Models\Product::select('id', 'name')->get();
        $locations = \App\Models\ProductLocation::pluck('location_name', 'id')->all();

        return view('admin.localtax.show', compact('page_title', 'page_description', 'locationstocktransfer', 'locationstocktransferdetail', 'users', 'products', 'locations'));
    }


    public function approve($id)
    {

        $localtax = Taxreceipt::find($id);

        $localtax->update(['approved_by'=>\auth()->user()->id]);

        Flash::success('localtax Approved Successfully');

        return redirect('/admin/localtax');
    }

    public function edit(Request $request, $id)
    {
        $page_title = 'व्यवस्थापक | स्थानीय कर | सम्पादन गर्नुहोस्';
        $page_description = '';
        
        $localtax = Taxreceipt::find($id);
        $localtaxdetail = TaxreceiptDetail::where('tax_receipt_id', $localtax->id)->get();

        $products = \App\Models\Product::select('id', 'name')->get();
        $units = \App\Models\ProductsUnit::select('id', 'name')->get();
        $authority = \App\User::select('id', 'username')->get();

        return view('admin.localtax.edit', compact('page_title', 'page_description', 'localtax', 'localtaxdetail', 'products','units','authority'));
    }

    public function print($id)
    {
        $ord = Requisition::find($id);
        $orderDetails = Requisition_Detail::where('requisition_id', $id)->get();

        $imagepath = Auth::user()->organization->logo;

        return view('admin.localtax.print', compact('ord', 'imagepath', 'orderDetails', 'print_no'));
    }

    public function pdf($id)
    {
        $ord = Requisition::find($id);
        $orderDetails = Requisition_Detail::where('requisition_id', $id)->get();
        $imagepath = Auth::user()->organization->logo;

        $pdf = \PDF::loadview('admin.localtax.pdf', compact('ord', 'imagepath', 'orderDetails'));
        $file = 'stocktransfer-'.$id.'.pdf';

        if (File::exists('reports/'.$file)) {
            File::Delete('reports/'.$file);
        }

        return $pdf->download($file);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->all();

        \DB::beginTransaction();
        $localtax = Taxreceipt::find($id)->update($attributes);

        $localtaxdetails = TaxreceiptDetail::where('tax_receipt_id', $id)->get();
        TaxreceiptDetail::where('tax_receipt_id', $id)->delete();

        $symbol_no = $request->symbol_no;
        $description = $request->description;
        $used_as = $request->used_as;
        $amount = $request->amount;
        $unit = $request->unit;
        $check_no = $request->check_no;

        foreach ($symbol_no as $key => $value) {
            if ($symbol_no[$key] != 0) {
                $detail = new TaxReceiptDetail();
                $detail->tax_receipt_id = $id;
                $detail->symbol_no = $symbol_no[$key];
                $detail->description = $description[$key];
                $detail->used_as = $used_as[$key];
                $detail->amount = $amount[$key];
                $detail->received_via = $unit[$key];
                $detail->check_no = $check_no[$key];
                $detail->save();
            }
        }
        \DB::commit();

        Flash::success('localtax Updated Succesfully.');

        return redirect('/admin/localtax');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $requisition = Requisition::find($id);

        $transfers_detail = Requisition_Detail::where('requisition_id', $id)->get();

//        foreach ($transfers_detail as $td) {
//            StockMove::where('trans_type', STOCKMOVEIN)->where('stock_id', $td->product_id)->where('reference', 'store_in_'.$id)->delete();
//            StockMove::where('trans_type', STOCKMOVEOUT)->where('reference', 'store_out_'.$id)->where('stock_id', $td->product_id)->delete();
//        }

        $requisition->delete();

        Requisition_Detail::where('requisition_id', $id)->delete();

        Flash::success('localtax successfully deleted');

        return redirect('/admin/localtax');
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

        $requisition = Requisition::find($id);

        $modal_title = 'Delete Requisition';

        $modal_route = route('admin.localtax.delete', ['id' => $requisition->id]);

        $modal_body = 'Are you sure that you want to delete Requisition'.$requisition->id.' with the number? This operation is irreversible';

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));
    }

    public function getStockUnit(Request $request)
    {
        $product_id = $request->product_id;
        $unit=Product::find($product_id)->product_unit;
        $stock=\TaskHelper::getTranslations($product_id);

        return ['unit' => $unit,'stock'=>$stock];
    }
}
