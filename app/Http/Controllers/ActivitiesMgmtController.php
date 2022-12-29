<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubArea;
use App\Models\Area;
use App\Models\ActivitiesMgmt;
use Flash;
use Carbon\Carbon;

class ActivitiesMgmtController extends Controller
{
    public function index(){
        $activities = ActivitiesMgmt::all();
        $page_title = 'Admin | Main Program / Activity Management';
        return view('others.activitiesmgmt',compact('subareas', 'page_title','activities'));
     }
     public function create(){
         $page_title = 'Admin | Main Program / Activity Management';
         $page_description = 'Create new Activity/Program';
         $areas = Area::select('Name', 'Id')->get();
         $subareas = SubArea::select('Name', 'Id')->get();
         return view('others.activitiesmgmt_create', compact('page_title','page_description', 'areas', 'subareas'));
     }
     public function store(Request $request){
         $input= ActivitiesMgmt::create([
            'SubjectAreaId'=>$request->area,
             'SubjectTypeId' => $request->subarea,
             'Name'=> $request->activities,  
             'Amount' => $request->amount,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Activities/Program Successfully Created');
         return redirect('/admin/activitiesmgmt');
     }
     public function edit($id){  
         $findactivity= ActivitiesMgmt::find($id);
         $page_title = 'Admin | Main Program / Activity Management';
         $page_description = 'Update Activity/Program';
         $areas = Area::select('Name', 'Id')->get();
         $subareas = SubArea::select('Name', 'Id')->get();
         return view('others.activitiesmgmt_edit', compact('findactivity','page_title','areas','subareas','page_description'));
     }
     public function update( Request $request, $id){
         $updatearea= ActivitiesMgmt::where('Id', $id)->update([
            'SubjectAreaId'=>$request->area,
             'SubjectTypeId' => $request->subarea,
             'Name'=> $request->activities, 
             'Amount' => $request->amount,
             'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Activities/Program Successfully Updated');
         return redirect('/admin/activitiesmgmt');
     }
     public function delete($id){
         $area = ActivitiesMgmt::where('Id', $id)->delete();
         Flash::success('Activities/Program Successfully Deleted');
         return redirect('/admin/activitiesmgmt');
     }
}
