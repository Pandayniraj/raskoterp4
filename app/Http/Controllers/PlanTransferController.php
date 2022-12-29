<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanTransfer;
use App\Models\PlanRegister;
use Flash;
use Carbon\Carbon;

class PlanTransferController extends Controller
{
    //
    public function index(){
        $plans = PlanTransfer::all();
        $page_title = 'Admin| Plan Money Transfer';
        return view('plantransfer.index', compact('page_title','plans'));
     }
     public function create(){
        $registers =PlanRegister::select('name','appropriationamt','Id')->get();
        $page_title = 'Admin| Plan Money Transfer';
        $page_description = 'Create new Plan Money Transfer';
         return view('plantransfer.create', compact('registers','page_title','page_description'));
     }

     public function store(Request $request){
         $input= PlanTransfer::create([  
             'PlanFromId' => $request->planfromid,
             'FromAmount' => $request->appropriationamt,
             'PlanToId' => $request->planto,
             'ToAmount' => $request->amountto,
             'TransDate' => $request->miti,
             'Description' => $request->description,
             'Remarks' => $request->remark,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now(),
         ]);
         Flash::success('Plan Money Transfer SuccessFully Created');
         return redirect('/admin/plantransfer');
     }
     public function edit($id){  
        $registers =PlanRegister::select('name','appropriationamt','Id')->get();
        $findplan = PlanTransfer::find($id);
         $page_title = 'Admin| Plan Money Transfer';
         $page_description = 'Update Plan Money Transfer';
         return view('plantransfer.edit', compact('findplan','registers','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= PlanTransfer::where('Id', $id)->update([
            'PlanFromId' => $request->planfromid,
             'FromAmount' => $request->appropriationamt,
             'PlanToId' => $request->planto,
             'ToAmount' => $request->amountto,
             'TransDate' => $request->miti,
             'Description' => $request->description,
             'Remarks' => $request->remark,
             'UpdatedOn' => Carbon::now(),
         ]);
         Flash::success('Plan Money Transfer SuccessFully Updated');
         return redirect('/admin/plantransfer');
     }
     public function delete($id){
         $area = PlanTransfer::where('Id', $id)->delete();
         Flash::success('Plan Money Transfer Successfully Deleted');
         return redirect('/admin/plantransfer');
     }
}
