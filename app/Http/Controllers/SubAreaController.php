<?php

namespace App\Http\Controllers;
use App\Models\SubArea;
use App\Models\Area;
use Illuminate\Http\Request;
use Flash;
use Carbon\Carbon;

class SubAreaController extends Controller
{
    public function index(){
        $subareas = SubArea::all();
        $page_title = 'Admin | Sub-region Management';
        return view('others.subarea',compact('subareas', 'page_title'));
     }
     public function create(){
         $page_title = 'Admin | Sub-region Management';
         $page_description = 'Create new Sub-region';
         $areas = Area::select('Name', 'Id')->get();
        //  dd($areas);
         return view('others.subareacreate', compact('page_title','page_description', 'areas'));
     }
     public function store(Request $request){
        //  dd($request->area);
         $input= SubArea::create([
            'SubjectAreaId'=>$request->area,
             'Name' => $request->subarea,
             'Amount' => $request->amount,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Sub-region SuccessFully Created');
         return redirect('/admin/subarea');
     }
     public function edit($id){  
         $findsubarea= SubArea::find($id);
         $page_title = 'Admin | Sub-region Management';
         $page_description = 'Update Sub-region';
         $areas = Area::select('Name', 'Id')->get();
        //  dd($findsubarea->SubjectAreaId, $areas);
         return view('others.subareaedit', compact('findsubarea','page_title','areas','page_description'));
     }
     public function update( Request $request, $id){
         $updatearea= SubArea::where('Id', $id)->update([
            'SubjectAreaId'=>$request->area,
             'Name' => $request->subarea,
             'Amount' => $request->amount,
             'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Sub-region SuccessFully Updated');
         return redirect('/admin/subarea');
     }
     public function delete($id){
         $area = SubArea::where('Id', $id)->delete();
         Flash::success('Sub-region Successfully Deleted');
         return redirect('/admin/subarea');
     }
}
