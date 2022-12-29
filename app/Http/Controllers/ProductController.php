<?php

namespace App\Http\Controllers;

use App\Models\Audit as Audit;
use App\Models\Product as Course;
use App\Models\Role as Permission;
use App\Models\StockAdjustmentDetail;
use App\Models\StockMove;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * THIS CONTROLLER IS USED AS PRODUCT CONTROLLER.
 */
class ProductController extends Controller
{
    /**
     * @var Course
     */
    private $course;

    /**
     * @var Permission
     */
    private $permission;

    /**
     * @param Course $course
     * @param Permission $permission
     * @param User $user
     */
    public function __construct(Course $course, Permission $permission)
    {
        parent::__construct();
        $this->course = $course;
        $this->permission = $permission;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-index'));

        $courses = $this->course->select('products.*')->where(function ($query) {
            $terms = \Request::get('term');
            if ($terms)
                return $query->where('products.name', 'LIKE', '%' . $terms . '%');
        })->where(function($query){

            $product_cat = \Request::get('product_cat');

            if($product_cat){

                return $query->where('product_categories.id',$product_cat);
            }


        })->where(function($query){

            if(\Request::get('alert_qty') == 'neg'){
                $posCountStock = \App\Models\StockMove::select('stock_id',\DB::raw('SUM(product_stock_moves.qty) as qty'))
                                ->groupBy('stock_id')
                                ->get();
                $posCountStock = $posCountStock->where('qty','>','0')->pluck('stock_id')->toArray();


                return $query->whereNotIn('products.id',$posCountStock)
                        ->where('type','trading');
            }

        })
        ->leftjoin('product_categories','products.category_id','=','product_categories.id')
        ->orderBy('id', 'desc')
            ->where('products.org_id',auth()->user()->org_id)
        ->groupBy('id')
        ->paginate(30);

        $page_title = 'Products & Inventory';

        $page_description = trans('admin/courses/general.page.index.description');


        $productCategory = \App\Models\ProductCategory::pluck('name','id');
        //dd($transations);

        return view('admin.products.index', compact('courses', 'page_title', 'page_description','productCategory'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $course = $this->course->find($id);

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-show', ['name' => $course->name]));

        $page_title = trans('admin/courses/general.page.show.title'); // "Admin | Course | Show";
        $page_description = trans('admin/courses/general.page.show.description'); // "Displaying course: :name";

        return view('admin.products.show', compact('course', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('admin/courses/general.page.create.title'); // "Admin | Course | Create";
        $page_description = trans('admin/courses/general.page.create.description'); // "Creating a new course";

        $course = new \App\Models\Product();
        $perms = $this->permission->all();
        $categories = \App\Models\ProductCategory::orderBy('name', 'ASC')->where('org_id', Auth::user()->org_id)->pluck('name', 'id');

        $product_unit = \App\Models\ProductsUnit::pluck('name', 'id');
        $supplier = \App\Models\Client::where('relation_type', 'supplier')->pluck('name', 'id');

        //dd($product_unit);
        if (\Request::ajax()) {
            return view('admin.products.modals.create', compact('course', 'perms', 'categories', 'product_unit', 'supplier'));
        }

        return view('admin.products.create', compact('course', 'perms', 'page_title', 'page_description', 'categories', 'product_unit', 'supplier'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if (\Request::ajax()) {
            $validator = \Validator::make($request->all(), [
                'name'  => 'required|unique:products',
            ]);
            if ($validator->fails()) {
                return ['error' => $validator->errors()];
            }
        }
        $this->validate($request, ['name'  => 'required|unique:products',]);

        $attributes = $request->all();
        $attributes['org_id'] = Auth::user()->org_id;


        if ($request->file('product_image')) {
            $stamp = time();
            $file = $request->file('product_image');
            $destinationPath = public_path() . '/products/';
            if (!\File::isDirectory($destinationPath)) {
                \File::makeDirectory($destinationPath, 0777, true, true);
            }
            $filename = $file->getClientOriginalName();
            $request->file('product_image')->move($destinationPath, $stamp . '_' . $filename);
            $attributes['product_image'] = $stamp . '_' . $filename;
        }

        // dd($attributes);

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-store', ['name' => $attributes['name']]));

        $course = $this->course->create($attributes);

        if ($request->is_fixed_assets) {
            $this->postledgers($course);
        }
        if (\Request::ajax()) {
            return ['status' => 'success', 'lastcreated' => $course];
        }
        Flash::success(trans('admin/courses/general.status.created')); // 'Course successfully created');

        return redirect('/admin/products');
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $course = $this->course->find($id);
        $categories = \App\Models\ProductCategory::orderBy('name', 'ASC')->where('org_id', Auth::user()->org_id)->pluck('name', 'id');

        //dd($categories);

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-edit', ['name' => $course->name]));

        $page_title = trans('admin/courses/general.page.edit.title'); // "Admin | Course | Edit";
        $page_description = trans('admin/courses/general.page.edit.description', ['name' => $course->name]); // "Editing course";

        $transations = \App\Models\StockMove::where('product_stock_moves.stock_id', $id)
            ->leftjoin('products', 'products.id', '=', 'product_stock_moves.stock_id')
            ->leftjoin('product_location', 'product_location.id', '=', 'product_stock_moves.location')
            ->select('product_stock_moves.*', 'products.name', 'product_location.location_name')
            ->orderBy('product_stock_moves.tran_date', 'DESC')
            ->get()
            ->groupBy('trans_type');





        $locData = DB::table('product_location')->get();

        $loc = DB::table('product_location')->get();

        $loc_name = [];
        foreach ($loc as $value) {
            $loc_name[$value->id] = $value->location_name;
        }

        $loc_name = $loc_name;

        if (!$course->isEditable() && !$course->canChangePermissions()) {
            abort(403);
        }

        $product_unit = \App\Models\ProductsUnit::pluck('name', 'id');
        $product_model = \App\Models\ProductModel::where('product_id', $id)->get();
        $product_serial_num = [];
        $supplier = \App\Models\Client::where('relation_type', 'supplier')->pluck('name', 'id');

        return view('admin.products.edit', compact('course', 'product_unit', 'page_title', 'locData', 'loc_name', 'page_description', 'transations', 'categories', 'product_serial_num', 'product_model', 'supplier'));
    }

    private function postledgers($products)
    {
        if (!$products->ledger_id) {
            $ledger_id = \TaskHelper::PostLedgers(
                $products->name,
                \FinanceHelper::get_ledger_id('FIXED_ASSETS_LEDGER')
            );
            $products->update(['ledger_id' => $ledger_id]);
        }
    }

    public function stocks_by_location()
    {
        $page_title = 'Stock Feeds';
        $page_description = 'counts';

        $location = \App\Models\ProductLocation::pluck('location_name', 'id')->all();

        //dd($location);

        return view('admin.products.stocksbylocation', compact('page_title', 'page_description', 'location'));
    }

    public function stocks_by_location_post(Request $request)
    {
        $page_title = 'Stock By Location';
        $page_description = 'counts';

        $transations = DB::table('product_stock_moves')
            // ->where('product_stock_moves.stock_id',$id)
            ->leftjoin('products', 'products.id', '=', 'product_stock_moves.stock_id')
            ->leftjoin('product_location', 'product_location.id', '=', 'product_stock_moves.location')
            ->select('product_stock_moves.*', 'products.name', 'product_location.location_name')
            ->orderBy('product_stock_moves.tran_date', 'DESC')
            ->where('location', $request->location_id)
            ->get();

        $current_location = $request->location_id;

        $location = \App\Models\ProductLocation::pluck('location_name', 'id')->all();

        return view('admin.products.stocksbylocation', compact('page_title', 'page_description', 'location', 'transations', 'location', 'current_location'));
    }

    public function stocks_count()
    {
        $page_title = 'Stock Feeds';
        $page_description = 'counts';

        $transations = DB::table('product_stock_moves')
            // ->where('product_stock_moves.stock_id',$id)
            ->leftjoin('products', 'products.id', '=', 'product_stock_moves.stock_id')
            ->leftjoin('product_location', 'product_location.id', '=', 'product_stock_moves.location')
            ->select('product_stock_moves.*', 'products.name', 'product_location.location_name', 'products.id as pid')
            ->orderBy('product_stock_moves.tran_date', 'DESC')
            ->paginate(20);

        return view('admin.products.stockscount', compact('page_title', 'page_description', 'transations'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name'          => 'required|unique:products,name,' . $id,]);
        $course = $this->course->find($id);

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-update', ['name' => $course->name]));

        $attributes = $request->all();
        $attributes['org_id'] = Auth::user()->org_id;




        if ($request->file('product_image')) {
            $stamp = time();
            $destinationPath = public_path() . '/products/';
            //file_upload
            $file = \Request::file('product_image');
            if (!\File::isDirectory($destinationPath)) {
                \File::makeDirectory($destinationPath, 0777, true, true);
            }
            //base_path() is proj root in laravel
            $filename = $file->getClientOriginalName();
            \Request::file('product_image')->move($destinationPath, $stamp . $filename);

            //create second image as big image and delete original
            $image = \Image::make($destinationPath . $stamp . $filename)
                ->save($destinationPath . $stamp . $filename);

            $attributes['product_image'] = $stamp . $filename;
        }

        if ($course->isEditable()) {
            $course->update($attributes);
            if ($request->is_fixed_assets) {
                $this->postledgers($course);
            }
        }

        Flash::success(trans('admin/courses/general.status.updated')); // 'Course successfully updated');

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $course = $this->course->find($id);

        if (!$course->isdeletable()) {
            abort(403);
        }

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-destroy', ['name' => $course->name]));

        $course->delete($id);
        \App\Models\ProductModel::where('product_id', $id)->delete();
        \App\Models\ProductSerialNumber::where('product_id', $id)->delete();
        Flash::success(trans('admin/courses/general.status.deleted')); // 'Course successfully deleted');

        return redirect('/admin/products');
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

        $course = $this->course->find($id);

        if (!$course->isdeletable()) {
            abort(403);
        }

        $modal_title = trans('admin/courses/dialog.delete-confirm.title');

        $course = $this->course->find($id);
        $modal_route = route('admin.products.delete', ['courseId' => $course->id]);

        $modal_body = trans('admin/courses/dialog.delete-confirm.body', ['id' => $course->id, 'name' => $course->name]);

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enable($id)
    {
        $course = $this->course->find($id);

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-enable', ['name' => $course->name]));

        $course->enabled = true;
        $course->save();

        Flash::success(trans('admin/courses/general.status.enabled'));

        return redirect('/admin/products');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disable($id)
    {
        //TODO: Should we protect 'admins', 'users'??

        $course = $this->course->find($id);

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-disabled', ['name' => $course->name]));

        $course->enabled = false;
        $course->save();

        Flash::success(trans('admin/courses/general.status.disabled'));

        return redirect('/admin/products');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function enableSelected(Request $request)
    {
        $chkCourses = $request->input('chkCourse');

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-enabled-selected'), $chkCourses);

        if (isset($chkCourses)) {
            foreach ($chkCourses as $course_id) {
                $course = $this->course->find($course_id);
                $course->enabled = true;
                $course->save();
            }
            Flash::success(trans('admin/courses/general.status.global-enabled'));
        } else {
            Flash::warning(trans('admin/courses/general.status.no-course-selected'));
        }

        return redirect('/admin/products');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function disableSelected(Request $request)
    {
        //TODO: Should we protect 'admins', 'users'??

        $chkCourses = $request->input('chkCourse');

        Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-disabled-selected'), $chkCourses);

        if (isset($chkCourses)) {
            foreach ($chkCourses as $course_id) {
                $course = $this->course->find($course_id);
                $course->enabled = false;
                $course->save();
            }
            Flash::success(trans('admin/courses/general.status.global-disabled'));
        } else {
            Flash::warning(trans('admin/courses/general.status.no-course-selected'));
        }

        return redirect('/admin/products');
    }

    /**
     * @param Request $request
     * @return array|static[]
     */
    public function searchByName(Request $request)
    {
        $return_arr = null;

        $query = $request->input('query');

        $courses = $this->course->where('name', 'LIKE', '%' . $query . '%')->get();
        foreach ($courses as $course) {
            $id = $course->id;
            $name = $course->name;
            $email = $course->email;

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
        $course = $this->course->find($id);

        return $course;
    }

    public function stock_adjustment()
    {
        $page_title = 'Stock Adjustment';
        $page_description = 'Add stock or remove stocks fr example damaged or others';

        $stockadjustment = \App\Models\StockAdjustment::where('org_id',\auth()->user()->org_id)->orderBy('id', 'desc')->get();

        return view('admin.products.adjust.adjust', compact('page_title', 'page_description', 'stockadjustment'));
    }

    public function stock_adjustment_create()
    {
        $page_title = 'Stock Adjustment Create';
        $page_description = 'Add stock or remove stocks fr example damaged or others';

        $location = \App\Models\ProductLocation::pluck('location_name', 'id')->all();

        $account_ledgers = \App\Models\COALedgers::where('group_id', env('COST_OF_GOODS_SOLD'))->pluck('name', 'id')->all();

        $units = \App\Models\ProductsUnit::select('id', 'name', 'symbol')->get();
        $products = \App\Models\Product::where('enabled', '1')->get();

        $reasons = \App\Models\AdjustmentReason::pluck('name', 'id')->all();

        return view('admin.products.adjust.create', compact('page_title', 'page_description', 'location', 'account_ledgers', 'units', 'products', 'reasons'));
    }

    public function stock_adjustment_store(Request $request)
    {

         DB::beginTransaction();
        $attributes = $request->all();

        $attributes['tax_amount'] = $request->taxable_tax;
        $attributes['total_amount'] = $request->final_total;
        $attributes['date'] = \Carbon\Carbon::now();
        $attributes['org_id'] = \auth()->user()->org_id;

        $stock_adjustment = \App\Models\StockAdjustment::create($attributes);

        $product_id = $request->product_id;
        $price = $request->price;
        $quantity = $request->quantity;
        $tax_amount = $request->tax_amount;
        $total = $request->total;
        $units = $request->units;

        $total_qty=0;
        foreach ($quantity as $qty){
            $total_qty+=$qty;
        }
        $stockmaster = new \App\Models\StockMaster();
        $stockmaster->stock_entry_id = 1;
        $stockmaster->tran_date = $stock_adjustment->date;
        $stockmaster->modules = "Stock Adjustments";
        $stockmaster->comment =  " From Stock Adjustment";
        $stockmaster->total_value = $stock_adjustment->total_amount;
        $stockmaster->total_qty = $total_qty;
        $stockmaster->store_id = $stock_adjustment->location_id;
        $stockmaster->reason_id = $request->reason;
        $stockmaster->module_id = $stock_adjustment->id;
        $stockmaster->active = 1;
        $stockmaster->org_id = auth()->user()->org_id;
        $stockmaster->save();

        foreach ($product_id as $key => $value) {
            if ($value != '') {
                $detail = new \App\Models\StockAdjustmentDetail();
                $detail->adjustment_id = $stock_adjustment->id;
                $detail->product_id = $product_id[$key];
                $detail->price = $price[$key];
                $detail->qty = $quantity[$key];
                $detail->total = $total[$key];
                $detail->unit = $units[$key];
                $detail->save();

                $request_reason = \App\Models\AdjustmentReason::find($request->reason);

                if ($request_reason) {
                    $stockMove = new StockMove();
                    $stockMove->stock_id = $product_id[$key];
                    $stockMove->master_id = $stockmaster->id;
                    $stockMove->order_no = $stock_adjustment->id;
                    $stockMove->tran_date = \Carbon\Carbon::now();
                    $stockMove->user_id = Auth::user()->id;

                    $stockMove->trans_type = $request_reason->trans_type;
                    $stockMove->reference = $request_reason->name . '_' . $stock_adjustment->id;
                    if ($request_reason->reason_type == 'positive') {
                        $stockMove->qty = $quantity[$key];
                    } else {
                        $stockMove->qty = '-' . $quantity[$key];
                    }

                    $stockMove->transaction_reference_id = $stock_adjustment->id;
                    $stockMove->location = $request->location_id;
                    $stockMove->org_id = auth()->user()->org_id;

                    $stockMove->price = $price[$key];
                    $stockMove->save();
                }
            }
        }

        $this->updateEntries($stock_adjustment->id);
         DB::commit();
        Flash::success('Stock Adjustment Done Successfully');

        return redirect('/admin/product/stock_adjustment');
    }

    public function stock_adjustment_edit($id)
    {

        // dd($id);

        $page_title = 'Stock Adjustment Edit';
        $page_description = 'Add stock or remove stocks fr example damaged or others';

        $stock_adjustment = \App\Models\StockAdjustment::find($id);

        $stock_adjustment_details = \App\Models\StockAdjustmentDetail::where('adjustment_id', $stock_adjustment->id)->get();
        //dd($stock_adjustment_details);

        $location = \App\Models\ProductLocation::pluck('location_name', 'id')->all();

        $account_ledgers = \App\Models\COALedgers::where('group_id', env('COST_OF_GOODS_SOLD'))->pluck('name', 'id')->all();

        $units = \App\Models\ProductsUnit::select('id', 'name', 'symbol')->get();
        $products = \App\Models\Product::where('enabled', '1')->get();

        $reasons = \App\Models\AdjustmentReason::pluck('name', 'id')->all();

        return view('admin.products.adjust.edit', compact('page_title', 'page_description', 'location', 'account_ledgers', 'units', 'products', 'stock_adjustment', 'stock_adjustment_details', 'reasons'));
    }

    public function stock_adjustment_update(Request $request, $id)
    {
         DB::beginTransaction();
        $old_reason_name = \App\Models\StockAdjustment::find($id)->adjustmentreason->name;

        $old_trans_type = \App\Models\StockAdjustment::find($id)->adjustmentreason->trans_type;

        $attributes = $request->all();
        $attributes['tax_amount'] = $request->taxable_tax;
        $attributes['total_amount'] = $request->final_total;

        $stock_adjustment = \App\Models\StockAdjustment::find($id)->update($attributes);

        $purchasedetails = StockAdjustmentDetail::where('adjustment_id', $id)->get();

        foreach ($purchasedetails as $pd) {
            $stockmove = \App\Models\StockMove::where('stock_id', $pd->product_id)->where('order_no', $id)->where('trans_type', $old_trans_type)->where('reference', $old_reason_name . '_' . $id)->delete();
        }

        \App\Models\StockAdjustmentDetail::where('adjustment_id', $id)->delete();

        $product_id = $request->product_id;
        $price = $request->price;
        $quantity = $request->quantity;
        $tax_amount = $request->tax_amount;
        $total = $request->total;
        $units = $request->units;

        $total_qty=0;
        foreach ($quantity as $qty){
            $total_qty+=$qty;
        }

        $stockmaster_attr['stock_entry_id'] = 1;
        $stockmaster_attr['modules'] = "Stock Adjustments";
        $stockmaster_attr['comment'] =  " From Stock Adjustment";
        $stockmaster_attr['total_value'] = $stock_adjustment->total_amount;
        $stockmaster_attr['total_qty'] = $total_qty;
        $stockmaster_attr['store_id'] = $stock_adjustment->location_id;
        $stockmaster_attr['reason_id'] = $request->reason;
        $stockmaster_attr['module_id'] = $stock_adjustment->id;
        $stockmaster_attr['active'] = 1;

        $stockmaster=\App\Models\StockMaster::where('modules','Stock Adjustments')
            ->where('module_id',$id)->first();
//        dd($stock_adjustment);
        $stockmaster->update($stockmaster_attr);
        StockMove::where('master_id',$stockmaster->id)->delete();

        foreach ($product_id as $key => $value) {
            if ($value != '') {
                $detail = new \App\Models\StockAdjustmentDetail();
                $detail->adjustment_id = $id;
                $detail->product_id = $product_id[$key];
                $detail->price = $price[$key];
                $detail->qty = $quantity[$key];
                $detail->total = $total[$key];
                $detail->unit = $units[$key];
                $detail->save();

                $request_reason = \App\Models\AdjustmentReason::find($request->reason);

                if ($request_reason) {
                    $stockMove = new StockMove();
                    $stockMove->stock_id = $product_id[$key];
                    $stockMove->order_no = $id;
                    $stockMove->tran_date = \Carbon\Carbon::now();
                    $stockMove->user_id = Auth::user()->id;

                    $stockMove->trans_type = $request_reason->trans_type;
                    $stockMove->reference = $request_reason->name . '_' . $id;
                    if ($request_reason->reason_type == 'positive') {
                        $stockMove->qty = $quantity[$key];
                    } else {
                        $stockMove->qty = '-' . $quantity[$key];
                    }

                    $stockMove->transaction_reference_id = $id;
                    $stockMove->location = $request->location_id;
                    $stockMove->org_id = auth()->user()->org_id;

                    $stockMove->price = $price[$key];
                    $stockMove->save();
                }
            }
        }

        $product_id_new = $request->product_id_new;
        $price_new = $request->price_new;
        $quantity_new = $request->quantity_new;
        $tax_amount_new = $request->tax_amount_new;
        $total_new = $request->total_new;
        $units_new = $request->units_new;

        foreach ($product_id_new ?? [] as $key => $value) {
            if ($value != '') {
                $detail = new \App\Models\StockAdjustmentDetail();
                $detail->adjustment_id = $id;
                $detail->product_id = $product_id_new[$key];
                $detail->price = $price_new[$key];
                $detail->qty = $quantity_new[$key];
                $detail->total = $total_new[$key];
                $detail->unit = $units_new[$key];
                $detail->save();

                $request_reason = \App\Models\AdjustmentReason::find($request->reason);

                if ($request_reason) {
                    $stockMove = new StockMove();
                    $stockMove->stock_id = $product_id_new[$key];
                    $stockMove->order_no = $id;
                    $stockMove->tran_date = \Carbon\Carbon::now();
                    $stockMove->user_id = Auth::user()->id;

                    $stockMove->trans_type = $request_reason->trans_type;
                    $stockMove->reference = $request_reason->name . '_' . $id;

                    if ($request_reason->reason_type == 'positive') {
                        $stockMove->qty = $quantity_new[$key];
                    } else {
                        $stockMove->qty = '-' . $quantity_new[$key];
                    }

                    $stockMove->transaction_reference_id = $id;
                    $stockMove->location = $request->location_id;
                    $stockMove->org_id = auth()->user()->org_id;

                    $stockMove->price = $price[$key];
                    $stockMove->save();
                }
            }
        }

        $this->updateEntries($id);
         DB::commit();
        Flash::success('Stock Adjustment Updated Successfully');

        return redirect('/admin/product/stock_adjustment');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function stock_adjustment_destroy($id)
    {

        //dd($id);

        $old_reason_name = \App\Models\StockAdjustment::find($id)->adjustmentreason->name;

        $old_trans_type = \App\Models\StockAdjustment::find($id)->adjustmentreason->trans_type;

        $stock_adjustment = \App\Models\StockAdjustment::find($id)->delete();

        $purchasedetails = StockAdjustmentDetail::where('adjustment_id', $id)->get();

        foreach ($purchasedetails as $pd) {
            $stockmove = \App\Models\StockMove::where('stock_id', $pd->product_id)->where('order_no', $id)->where('trans_type', $old_trans_type)->where('reference', $old_reason_name . '_' . $id)->delete();
        }

        \App\Models\StockAdjustmentDetail::where('adjustment_id', $id)->delete();

        Flash::success('Stock Adjustment Destroyed');

        return redirect('/admin/product/stock_adjustment');
    }

    /**
     * Delete Confirm.
     *
     * @param   int   $id
     * @return  View
     */
    public function stock_adjustment_getModalDelete($id)
    {
        $error = null;

        $modal_title = 'Want to delete Stock Adjustment';

        $stock_adjustment = \App\Models\StockAdjustment::find($id);

        $stock_adjustment_details = \App\Models\StockAdjustmentDetail::where('adjustment_id', $stock_adjustment->id)->get();

        $modal_route = route('admin.products.stock_adjustment.delete', ['id' => $stock_adjustment->id]);

        $modal_body = 'Are you Sure to Delete This?';

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));
    }

    private function updateEntries($orderId)
    {
        $purchaseorder = \App\Models\StockAdjustment::find($orderId);

        //dd($purchaseorder);

        $reason = \App\Models\AdjustmentReason::find($purchaseorder->reason);
        if ($purchaseorder->entry_id && $purchaseorder->entry_id != '0') { //update the ledgers
            $attributes['entrytype_id'] = \FinanceHelper::get_entry_type_id('journal'); //Adjustment
            $attributes['tag_id'] = '2'; //Adjustment
            $attributes['user_id'] = Auth::user()->id;
            $attributes['org_id'] = Auth::user()->org_id;
            $attributes['number'] = $purchaseorder->id;
            $attributes['date'] = \Carbon\Carbon::today();
            $attributes['dr_total'] = $purchaseorder->total_amount;
            $attributes['cr_total'] = $purchaseorder->total_amount;
            $attributes['source'] = strtoupper($reason->name);
            $entry = \App\Models\Entry::find($purchaseorder->entry_id);
            $entry->update($attributes);

            // Creddited to Customer or Interest or eq ledger

            if ($reason->reason_type == 'negative') {
                $sub_amount = \App\Models\Entryitem::where('entry_id', $purchaseorder->entry_id)->where('dc', 'C')->first();
                $sub_amount->entry_id = $entry->id;
                $sub_amount->user_id = Auth::user()->id;
                $sub_amount->org_id = Auth::user()->org_id;
                $sub_amount->dc = 'C';
                $sub_amount->ledger_id = env('ADJUSTMENT_INVENTORY'); //Inventory ledger
                $sub_amount->amount = $purchaseorder->total_amount;
                $sub_amount->narration = $reason->name; //$request->user_id
                //dd($sub_amount);
                $sub_amount->update();

                // Debitte to Bank or cash account that we are already in
                $cash_amount = \App\Models\Entryitem::where('entry_id', $purchaseorder->entry_id)->where('dc', 'D')->first();
                $cash_amount->entry_id = $entry->id;
                $cash_amount->user_id = Auth::user()->id;
                $cash_amount->org_id = Auth::user()->org_id;
                $cash_amount->dc = 'D';
                $cash_amount->ledger_id = $purchaseorder->ledgers_id; // Purchase ledger if selected or ledgers from .env
                // dd($cash_amount);
                $cash_amount->amount = $purchaseorder->total_amount;
                $cash_amount->narration = $reason->name;
                $cash_amount->update();
            } else {
                $sub_amount = \App\Models\Entryitem::where('entry_id', $purchaseorder->entry_id)->where('dc', 'D')->first();
                $sub_amount->entry_id = $entry->id;
                $sub_amount->user_id = Auth::user()->id;
                $sub_amount->org_id = Auth::user()->org_id;
                $sub_amount->dc = 'D';
                $sub_amount->ledger_id = env('ADJUSTMENT_INVENTORY'); //Inventory ledger
                $sub_amount->amount = $purchaseorder->total_amount;
                $sub_amount->narration = $reason->name; //$request->user_id
                //dd($sub_amount);
                $sub_amount->update();

                // Debitte to Bank or cash account that we are already in
                $cash_amount = \App\Models\Entryitem::where('entry_id', $purchaseorder->entry_id)->where('dc', 'C')->first();
                $cash_amount->entry_id = $entry->id;
                $cash_amount->user_id = Auth::user()->id;
                $cash_amount->org_id = Auth::user()->org_id;
                $cash_amount->dc = 'C';
                $cash_amount->ledger_id = $purchaseorder->ledgers_id; // Purchase ledger if selected or ledgers from .env
                // dd($cash_amount);
                $cash_amount->amount = $purchaseorder->total_amount;
                $cash_amount->narration = $reason->name;
                $cash_amount->update();
            }
        } else {
            //create the new entry items
            $attributes['entrytype_id'] = \FinanceHelper::get_entry_type_id('journal'); //Adjustment
            $attributes['tag_id'] = '2'; //Adjustment
            $attributes['user_id'] = Auth::user()->id;
            $attributes['org_id'] = Auth::user()->org_id;
            $attributes['number'] = \FinanceHelper::get_last_entry_number($attributes['entrytype_id']);
            $attributes['date'] = \Carbon\Carbon::today();
            $attributes['dr_total'] = $purchaseorder->total_amount;
            $attributes['cr_total'] = $purchaseorder->total_amount;
            $attributes['source'] = strtoupper($reason->name);
            $attributes['fiscal_year_id'] = \FinanceHelper::cur_fisc_yr()->id;
            $entry = \App\Models\Entry::create($attributes);

            if ($reason->reason_type == 'negative') {
                // Creddited to Customer or Interest or eq ledger
                $sub_amount = new \App\Models\Entryitem();
                $sub_amount->entry_id = $entry->id;
                $sub_amount->user_id = Auth::user()->id;
                $sub_amount->org_id = Auth::user()->org_id;
                $sub_amount->dc = 'C';
                $sub_amount->ledger_id = env('ADJUSTMENT_INVENTORY'); //Client ledger
                $sub_amount->amount = $purchaseorder->total_amount;
                $sub_amount->narration = $reason->name; //$request->user_id
                //dd($sub_amount);
                $sub_amount->save();

                // Debitte to Bank or cash account that we are already in

                $cash_amount = new \App\Models\Entryitem();
                $cash_amount->entry_id = $entry->id;
                $cash_amount->user_id = Auth::user()->id;
                $cash_amount->org_id = Auth::user()->org_id;
                $cash_amount->dc = 'D';
                $cash_amount->ledger_id = $purchaseorder->ledgers_id; // Puchase ledger if selected or ledgers from .env
                // dd($cash_amount);
                $cash_amount->amount = $purchaseorder->total;
                $cash_amount->narration = $reason->name;
                $cash_amount->save();
            } else {
                $sub_amount = new \App\Models\Entryitem();
                $sub_amount->entry_id = $entry->id;
                $sub_amount->user_id = Auth::user()->id;
                $sub_amount->org_id = Auth::user()->org_id;
                $sub_amount->dc = 'D';
                $sub_amount->ledger_id = env('ADJUSTMENT_INVENTORY'); //Client ledger
                $sub_amount->amount = $purchaseorder->total_amount;
                $sub_amount->narration = $reason->name; //$request->user_id
                //dd($sub_amount);
                $sub_amount->save();

                // Debitte to Bank or cash account that we are already in

                $cash_amount = new \App\Models\Entryitem();
                $cash_amount->entry_id = $entry->id;
                $cash_amount->user_id = Auth::user()->id;
                $cash_amount->org_id = Auth::user()->org_id;
                $cash_amount->dc = 'C';
                $cash_amount->ledger_id = $purchaseorder->ledgers_id; // Puchase ledger if selected or ledgers from .env
                // dd($cash_amount);
                $cash_amount->amount = $purchaseorder->total_amount;
                $cash_amount->narration = $reason->name;
                $cash_amount->save();
            }

            //now update entry_id in income row
            $purchaseorder->update(['entry_id' => $entry->id]);
        }

        return 0;
    }


    //Barcode features

    public function promotionCreate($id)
    {

        return view('admin.products.promotionmodal', compact('id'));
    }


    public function barcodeCreate($id)
    {
        $products = \App\Models\Product::find($id);
        $page_title = "Admin | Products | Barcode | Print";
        $page_description = "Lits of products barcode";

        return view('admin.products.barcodecreate', compact('products', 'page_title', 'id'));
    }

    public function barcodePost(Request $request, $id)
    {
        //$products = \App\Models\Product::find($id);
        $page_title = "Admin | Products | Barcode | Print";
        $page_description = "Lits of products barcode";

        $requests = $request->all();

        $products_all = $request->product;
        $quantity = $request->quantity;

        ///dd($products);


        return view('admin.products.barcodecreate', compact( 'page_title',  'products_all', 'quantity', 'requests', 'id'));
    }

    public function getPrintProduct(Request $request)
    {

        $attributes = $request->all();

        $products = \App\Models\Product::orderBy('id', 'desc')->Where('name', $request->product_name)->first();

        if (count($products) > 0) {

            $data = '<tr>
                    <td><input name="product[]" type="hidden" value="' . $products->id . '">' . $products->name . ' (' . $products->product_code . ')</td>
                    <td><input class="form-control quantity " name="quantity[]" type="number" value="100"  onclick="this.select();"></td>
                    <td></td>
                    <td class="text-center"> <a href="javascript::void(1);" style="width: 10%;" readonly>
                                <i class="remove-this btn btn-xs btn-danger icon fa fa-trash deletable" style="float: right; color: #fff;"></i>
                    </a>
                    </td>
                </tr>';
        } else {

            $data = 0;
        }

        return ['purchasedetailinfo' => $data];
    }


    public function product_statement(Request $request){

        $page_title = 'Product Statement';
        $page_description = 'Search product to find stock ledger statement';

        $products = \App\Models\Product::orderBy('ordernum')->where('enabled', '1')
            ->where('org_id', Auth::user()->org_id)->orderBy('name', 'ASC')
            ->pluck('name', 'id');

        $current_product = $request->product_id;



        $transations = \App\Models\StockMove::where(function($query) use ($current_product){

            return $query->where('stock_id',$current_product);
        })->where(function($query){

            $start_date = \Request::get('start_date');
            $end_date = \Request::get('end_date');

            if($start_date && $end_date){

                return $query->whereBetween('tran_date',[$start_date,$end_date]);


            }



        })

        ->orderBy('id');

        $isExcel = false;
        if($request->submit && $request->submit == 'excel' ){
            $transations = $transations->get();
            $view = view('admin.products.product-statement',compact('transations','isExcel'));
            return \Excel::download(new \App\Exports\ExcelExportFromView($view), 'product_statement.xlsx');

        }
        $transations = $transations->paginate(50);

        // ->paginate(50);

         $isExcel = false;


        return view('admin.products.statement', compact('transations','page_description','page_title','products','current_product','transations','isExcel'));

    }


    public function multipledelete(Request $request){

       $ids = $request->chkCourse;
       Audit::log(Auth::user()->id, trans('admin/courses/general.audit-log.category'), trans('admin/courses/general.audit-log.msg-destroy', ['name' => 'Deleted multiple products' ]));
        try{

            $this->course->whereIn('id',$ids)->delete();
            \App\Models\ProductModel::whereIn('product_id', $ids)->delete();
            \App\Models\ProductSerialNumber::whereIn('product_id', $ids)->delete();
            Flash::success(trans('admin/courses/general.status.deleted'));


        }catch(\Exception $e){

            Flash::error("The selected Products Are Related With Invoice");
        }



        return redirect('/admin/products');
    }
    public function inportExportView(Request $request)
    {
        $page_title = 'Import Export Budget';
        $page_description = 'Import Export the Budget Excel File';

        return view('admin.products.importExport', compact('page_title', 'page_description'));
    }

    public function int_purch($id)
    {
       $page_description = "Purchase Description";
       $int_purch = \App\Models\ProductInternationPurchase::where('product_id',$id)->first();
       $product_name = \App\Models\Product::where('id',$id)->first()->name;
       return view('admin.products.internation_purchase_create',compact('page_description','int_purch','id','product_name'));
    }


    public function int_purch_update(Request $request,$id)
    {
       $attributes = $request->all();
       $int_purch = \App\Models\ProductInternationPurchase::firstOrCreate(['product_id' =>  $id],);
       $int_purch->update($attributes);
       Flash::success('Product International Purchase Updated Successfully');
        return redirect()->route('admin.products.index');
    }

}
