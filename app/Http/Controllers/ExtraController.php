<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extra;
use Flash;
use Carbon\Carbon;

class ExtraController extends Controller
{
    //
    public function index(){
        $extras = Extra::all();
        $page_title = 'Admin| Extra Field';
        return view('others.extra', compact('page_title','extras'));
     }
     public function create(){
         $page_title = 'Admin | Extra Field';
         $page_description = 'Create new Extra Field';
         return view('others.extracreate', compact('page_title','page_description'));
     }
     public function store(Request $request){
         $input= Extra::create([  
             'Name' => $request->nepaliname,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Extra Successfully Created');
         return redirect('/admin/extra');
     }
     public function edit($id){  
         $findextra = Extra::find($id);
         $page_title = 'Admin | Extra Field';
         $page_description = 'Update Extra Field';
         return view('others.extraedit', compact('findextra','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= Extra::where('Id', $id)->update([
            'Name' => $request->nepaliname,
             'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Extra Successfully Updated');
         return redirect('/admin/extra');
     }
     public function delete($id){
         $area = Extra::where('Id', $id)->delete();
         Flash::success('Extra Successfully Deleted');
         return redirect('/admin/extra');
     }
}
