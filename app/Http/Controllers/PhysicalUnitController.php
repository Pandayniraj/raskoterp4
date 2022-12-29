<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhysicalUnit;
use Flash;
use Carbon\Carbon;

class PhysicalUnitController extends Controller
{
    //
    public function index(){
        $units = PhysicalUnit::all();
        $page_title = 'Admin | Unit Management';
        // dd('hello');
        return view('others.unit', compact('page_title','units'));
     }
     public function create(){
         $page_title = 'Admin | Unit Management';
         $page_description = 'Create new Unit';
         return view('others.unitcreate', compact('page_title','page_description'));
     }
     public function store(Request $request){
        
         $input= PhysicalUnit::create([  
             'Alias' => $request->unitcode,
             'Name' => $request->unitname,
             'Sortkey' => $request->sn,
             'Remarks' => $request->remarks,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Unit Successfully Created');
         return redirect('/admin/unit');
     }
     public function edit($id){  
         $findunit = PhysicalUnit::find($id);
         $page_title = 'Admin | Unit Management';
         $page_description = 'Update Unit';
         return view('others.unitedit', compact('findunit','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= PhysicalUnit::where('Id', $id)->update([
            'Alias' => $request->unitcode,
             'Name' => $request->unitname,
             'Sortkey' => $request->sn,
             'Remarks' => $request->remarks,
             'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Unit Successfully Updated');
         return redirect('/admin/unit');
     }
     public function delete($id){
         $area = PhysicalUnit::where('Id', $id)->delete();
         Flash::success('Unit Successfully Deleted');
         return redirect('/admin/unit');
     }
}
