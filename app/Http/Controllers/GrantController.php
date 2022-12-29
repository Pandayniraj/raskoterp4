<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grant;
use Flash;
use Carbon\Carbon;

class GrantController extends Controller
{
    // 
    public function index(){
        $grants = Grant::all();
        $page_title = 'Admin | Grant Managment';
        return view('others.grantmgmt',compact('page_title','grants'));
     }
     public function create(){
         $page_title = 'Admin | Grant Management';
         $page_description = 'Create new Grant';
         return view('others.grantcreate', compact('page_title','page_description'));
     }
     public function store(Request $request){
         $input= Grant::create([
             'Name'=> $request->grant,  
             'Remarks' => $request->detail,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Grant Successfully Created');
         return redirect('/admin/grantmgmt');
     }
     public function edit($id){  
        // dd('hello');
         $findgrant= Grant::find($id);
        //  dd($findgrant);
         $page_title = 'Admin | Grant Management';
         $page_description = 'Update Grant';
         return view('others.grantedit', compact('findgrant','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= Grant::where('Id', $id)->update([
            'Name'=> $request->grant,  
            'Remarks' => $request->detail,
            'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Grant Successfully Updated');
         return redirect('/admin/grantmgmt');
     }
     public function delete($id){
         $area = Grant::where('Id', $id)->delete();
         Flash::success('Grant Successfully Deleted');
         return redirect('/admin/grantmgmt');
     }
}
