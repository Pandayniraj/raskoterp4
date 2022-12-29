<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appropriation;
use Flash;
use Carbon\Carbon;

class AppropriationController extends Controller
{
    //
    public function index(){
        $appropriations = Appropriation::all();
        $page_title = 'Admin | Appropriation Type Management';
        return view('others.appropriation',compact('page_title','appropriations'));
     }
     public function create(){
         $page_title = 'Admin | Appropriation Type Management';
         $page_description = 'Create new Appropriation';
         return view('others.appropriationcreate', compact('page_title','page_description'));
     }
     public function store(Request $request){
         $input= Appropriation::create([
             'Name'=> $request->appropriation,  
             'Remarks' => $request->detail,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Appropriation Successfully Created');
         return redirect('/admin/appropriation');
     }
     public function edit($id){  
         $findappropriation= Appropriation::find($id);
         $page_title = 'Admin | Appropriation Type Management';
         $page_description = 'Update Appropriation';
         return view('others.appropriationedit', compact('findappropriation','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= Appropriation::where('Id', $id)->update([
            'Name'=> $request->appropriation,  
            'Remarks' => $request->detail,
            'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Appropriation Successfully Updated');
         return redirect('/admin/appropriation');
     }
     public function delete($id){
         $area = Appropriation::where('Id', $id)->delete();
         Flash::success('Appropriation Successfully Deleted');
         return redirect('/admin/appropriation');
     }
}
