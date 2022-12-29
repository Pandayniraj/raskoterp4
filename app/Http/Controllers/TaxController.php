<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use Flash;
use Carbon\Carbon;


class TaxController extends Controller
{
    //
    public function index(){
        $taxes = Tax::all();
        $page_title = 'Admin | Tax Management';
        return view('others.tax', compact('page_title','taxes'));
     }
     public function create(){
         $page_title = 'Admin | Tax Management';
         $page_description = 'Create new Tax';
         return view('others.taxcreate', compact('page_title','page_description'));
     }
     public function store(Request $request){
         $input= Tax::create([  
             'Alias' => $request->signnum,
             'Name' => $request->taxname,
             'Sortkey' => $request->sn,
             'Rate' => $request->rate,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Tax Successfully Created');
         return redirect('/admin/tax');
     }
     public function edit($id){  
         $findtax = Tax::find($id);
         $page_title = 'Admin | Tax Management';
         $page_description = 'Update Tax';
         return view('others.taxedit', compact('findtax','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= Tax::where('Id', $id)->update([
            'Alias' => $request->signnum,
            'Name' => $request->taxname,
            'Sortkey' => $request->sn,
            'Rate' => $request->rate,
            'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Tax Successfully Updated');
         return redirect('/admin/tax');
     }
     public function delete($id){
         $area = Tax::where('Id', $id)->delete();
         Flash::success('Tax Successfully Deleted');
         return redirect('/admin/tax');
     }
}
