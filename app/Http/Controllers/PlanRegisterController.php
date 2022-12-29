<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanRegister;
use App\Models\Area;
use App\Models\SubArea;
use App\Models\ActivitiesMgmt;
use App\Models\Appropriation;
use App\Models\PhysicalUnit;
use App\Models\Fiscalyear;
use App\Models\Grant;
use App\Models\Expenditure;
use App\Models\Program;
use App\Models\CostEstimate;
use App\Models\PlanAgreement;
use App\Models\Consumer;
use Flash;
use Carbon\Carbon;

class PlanRegisterController extends Controller
{
      public function index(){
        $plans = PlanRegister::all();
        $page_title = 'योजना/कार्यक्रम दर्ता व्यवस्थापन';
        return view('plan\programregistration.index', compact('page_title','plans'));
     }
     public function create(){
        $areas =Area::select('Name','Id')->get();
        $subareas =SubArea::select('Name', 'Id')->get();
        $activities =ActivitiesMgmt::select('Name', 'Id')->get();
        $appropriations = Appropriation::select('Name', 'Id')->get(); 
        $units = PhysicalUnit::select('Name', 'Id')->get();
        $years = Fiscalyear::select('fiscal_year', 'id')->get();
        $expenditures = Expenditure::select('expenditure_head', 'id')->get();
        $programs = Program::select('name', 'id')->get();
        $grants = Grant::select('Name','Id')->get();
        $page_title = 'योजना/कार्यक्रम दर्ता व्यवस्थापन';
        $page_description = 'Create new Plan/Program';
         return view('plan\programregistration.create', compact('expenditures','programs','areas','subareas','activities','appropriations','units','years','grants','page_title','page_description'));
     }
     public function store(Request $request){
        //  dd($request->sn, $request->status);
         $input= PlanRegister::create([  
             'fiscalyearid' => $request->fiscal_year,
             'granttypeid' => $request->grant_resource_type,
             'expensetypeid' => $request->expense_type,
             'planid' => $request->plan_progarm,
             'name' => $request->program_activities_name,
             'filenum' => $request->fileid,
             'expenditurehead' => $request->expense_head_num,
             'subjectareaid' => $request->areaid,
             'subjecttypeid' => $request->subareaid,
             'subjectsubtypeid' => $request->mainprogramid,
             'deploymenttypeid' => $request->appropriationid,
             'implementationplace' => $request->implementation_place,
             'ward' => $request->ward,
             'targetqty' => $request->physical_target_qty,
             'unitid' => $request->physical_unit,
             'purpose' => $request->purpose,
             'targetgrp' =>$request->target_grp,
             'appropriationamt' => $request->appropriation_amt,
             'firstquarterlyamt' => $request->first_qtrly_amt,
             'firstquarterlytarget' => $request->first_qtrly_target,
             'secondquarterlyamt' => $request->second_qtrly_amt,
             'secondquarterlytarget' => $request->second_qtrly_target,
             'thirdquarterlyamt' => $request->third_qtrly_amts,
             'thirdquarterlytarget' => $request->third_qtrly_target,
         ]);
         Flash::success('Plan/Program SuccessFully Created');
         return redirect('/admin/plan');
     }
     public function edit($id){  
        $findplan = PlanRegister::find($id);
        // $findcost= CostEstimate::where('operationid', $id)->get();
        $areas =Area::select('Name','Id')->get();
        $subareas =SubArea::select('Name', 'Id')->get();
        $activities =ActivitiesMgmt::select('Name', 'Id')->get();
        $appropriations = Appropriation::select('Name', 'Id')->get(); 
        $unit = PhysicalUnit::select('Name', 'Id')->get();
        $expenditures = Expenditure::select('expenditure_head', 'id')->get();
        $programs = Program::select('name', 'id')->get();
        $years = Fiscalyear::select('fiscal_year', 'id')->get();
        $grants = Grant::select('Name','Id')->get();
        $consumercommittee= Consumer::select('Name', 'Id')->get();
        $findagreement= PlanAgreement::where('operationid', $id)->get();
        // dd($findagreement);
        $findcost= CostEstimate::where('operationid', $id)->get();
        // dd($findcost);
         $page_title = 'योजना/कार्यक्रम दर्ता व्यवस्थापन';
         $page_description = 'Update PlanRegister';
         return view('plan\programregistration.edit', compact('consumercommittee','findagreement','expenditures','findcost','programs','areas','subareas','activities','appropriations','units','years','grants','findplan','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= PlanRegister::where('Id', $id)->update([
            'fiscalyearid' => $request->fiscal_year,
            'granttypeid' => $request->grant_resource_type,
            'expensetypeid' => $request->expense_type,
            'planid' => $request->plan_progarm,
            'name' => $request->program_activities_name,
            'filenum' => $request->fileid,
            'expenditurehead' => $request->expense_head_num,
            'subjectareaid' => $request->areaid,
            'subjecttypeid' => $request->subareaid,
            'subjectsubtypeid' => $request->mainprogramid,
            'deploymenttypeid' => $request->appropriationid,
            'implementationplace' => $request->implementation_place,
            'ward' => $request->ward,
            'targetqty' => $request->physical_target_qty,
            'unitid' => $request->physical_unit,
            'purpose' => $request->purpose,
            'targetgrp' =>$request->target_grp,
            'appropriationamt' => $request->appropriation_amt,
            'firstquarterlyamt' => $request->first_qtrly_amt,
            'firstquarterlytarget' => $request->first_qtrly_target,
            'secondquarterlyamt' => $request->second_qtrly_amt,
            'secondquarterlytarget' => $request->second_qtrly_target,
            'thirdquarterlyamt' => $request->third_qtrly_amt,
            'thirdquarterlytarget' => $request->third_qtrly_target,
         ]);
         Flash::success('Plan/Program SuccessFully Updated');
         return redirect('/admin/plan');
     }
     public function delete($id){
         $area = PlanRegister::where('Id', $id)->delete();
         Flash::success('Plan/Program Successfully Deleted');
         return redirect('/admin/plan');
     }
     public function multitaboption($id){
        $findplan= PlanRegister::find($id);
        $consumercommittee= Consumer::select('Name', 'Id')->get(); 
        $designations= \App\Models\Post::select('Name','Id')->get();
        $page_title = 'योजना/कार्यक्रम दर्ता व्यवस्थापन';
        $page_description = 'योजना/कार्यक्रम विवरण';
        return view('costestimate.costestimate',compact('findplan','designations','consumercommittee', 'page_title', 'page_description'));
     }
}
