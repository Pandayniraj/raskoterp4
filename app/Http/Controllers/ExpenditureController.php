<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure;
use Flash;
use Carbon\Carbon;

class ExpenditureController extends Controller
{
    //
    public function index(){
        $expenditures = Expenditure::all();
        $page_title = 'Admin|Expenditure';
        return view('expenditure.index', compact('page_title','expenditures'));
     }
     public function create(){
        $page_title = 'Admin| Expenditure';
        $page_description = 'Create new Expenditure';
         return view('expenditure.create', compact('page_title','page_description'));
     }
     public function store(Request $request){
        //  dd($request->sn, $request->status);
         $input= Expenditure::create([  
             'expenditure_head' => $request->expenditure_head,
             'createdon' => Carbon::now(),
             'updatedon' => Carbon::now(),
         ]);
         Flash::success('Expenditure SuccessFully Created');
         return redirect('/admin/expenditure');
     }
     public function edit($id){
        $findexpenditure = Expenditure::find($id);
        $page_title = 'Admin| Expenditure';
        $page_description = 'Create new Expenditure';  
         return view('expenditure.edit', compact('findexpenditure','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= Expenditure::where('Id', $id)->update([
            'expenditure_head' => $request->expenditure_head,
            'updatedon' => Carbon::now(),
         ]);
         Flash::success('Expenditure SuccessFully Updated');
         return redirect('/admin/expenditure');
     }
     public function delete($id){
         $area = Expenditure::where('Id', $id)->delete();
         Flash::success('Expenditure Successfully Deleted');
         return redirect('/admin/expenditure');
     }
}
