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
use App\Models\PlanPhotoFile;
use App\Models\ExtensionDetail;
use App\Models\FinancialTransaction;
use Flash;
use File;
use date;
class PmsAgreedController extends Controller
{
    public function index()
    {
        $page_title = 'सम्झौता भएको योजना';
        $page_description = 'सम्झौता भएको (संचालनमा रहेको) योजना/कार्यक्रम';

        $plans = PlanRegister::join('planagreements', 'pms_operation.id', 'planagreements.operationid')
                    ->join('costestimate', 'pms_operation.id', 'costestimate.operationid')
                    ->select('pms_operation.*', 'planagreements.prjrunning_committee as prjrunning_committee', 
                        'planagreements.agreementdate as agreementdate', 'planagreements.completiondate as completiondate')->get();
        return view('pms.agreed.index', compact('page_title','plans', 'page_description'));
    }
    public function current_year_index()
    {
        $currentyear=\App\Models\FiscalYear::latest()->select('id','numeric_fiscal_year','start_date','end_date')->first();
        // dd($currentyear);
        $presentdatenepali= \App\Helpers\TaskHelper::getNepaliDate(\Carbon\Carbon::now());
        $year= date('Y', strtotime($presentdatenepali));
        // dd($year-1);
        $previousyear= \App\Models\FiscalYear::orderBy('id', 'DESC')->skip(1)->take(1)->select('id','numeric_fiscal_year','start_date','end_date')->first();
        $checkdate=$year-1;
        $previousnumericyear=$previousyear->numeric_fiscal_year;
        // dd($previousnumericyear);
        if($currentyear->numeric_fiscal_year == $year && ($currentyear->end_date > \Carbon\Carbon::now() && $currentyear->start_date<\Carbon\Carbon::now())){
            $page_title = 'सम्पन्न भएको योजना ';
            $page_description = "यस बर्ष सम्पन्न भएको योजन/कार्यक्रम";
            $currentyear_completeplan= PlanRegister::join('planagreements', 'pms_operation.id', 'planagreements.operationid')
            ->join('costestimate', 'pms_operation.id', 'costestimate.operationid')->join('economic_conditions', 'pms_operation.id', 'economic_conditions.operationid')
            ->join('pms_operation_plan_photo_file', 'pms_operation.id','pms_operation_plan_photo_file.pms_operation_id')
            ->join('pms_operation_extension_details', 'pms_operation.id','pms_operation_extension_details.pms_operation_id')
            ->where('pms_operation.fiscalyearid', $currentyear->id)
            ->select('pms_operation.*', 'planagreements.prjrunning_committee as prjrunning_committee', 
            'planagreements.agreementdate as agreementdate', 'planagreements.completiondate as completiondate')
            ->get();
            // dd($currentyear_completeplan);
            return view('admin.completeplan_program.index',compact('page_title','page_description','currentyear_completeplan'));

        }
    }
    public function previous_year_index(){
        $currentyear=\App\Models\FiscalYear::latest()->select('id','numeric_fiscal_year','start_date','end_date')->first();
        // dd($currentyear);
        $presentdatenepali= \App\Helpers\TaskHelper::getNepaliDate(\Carbon\Carbon::now());
        $year= date('Y', strtotime($presentdatenepali));
        // dd($year-1);
        $previousyear= \App\Models\FiscalYear::orderBy('id', 'DESC')->skip(1)->take(1)->select('id','numeric_fiscal_year','start_date','end_date')->first();
        $checkdate=$year-1;
        $previousnumericyear=$previousyear->numeric_fiscal_year;
            if($checkdate == $previousnumericyear){
               $page_title = 'सम्पन्न भएको योजना ';
           $page_description = "गत बर्ष सम्पन्न भएको योजन/कार्यक्रम";
           $currentyear_completeplan= PlanRegister::join('planagreements', 'pms_operation.id', 'planagreements.operationid')
           ->join('costestimate', 'pms_operation.id', 'costestimate.operationid')->join('economic_conditions', 'pms_operation.id', 'economic_conditions.operationid')
           ->join('pms_operation_plan_photo_file', 'pms_operation.id','pms_operation_plan_photo_file.pms_operation_id')
           ->join('pms_operation_extension_details', 'pms_operation.id','pms_operation_extension_details.pms_operation_id')
           ->where('pms_operation.fiscalyearid', $previousyear->id)
           ->select('pms_operation.*', 'planagreements.prjrunning_committee as prjrunning_committee', 
           'planagreements.agreementdate as agreementdate', 'planagreements.completiondate as completiondate')
           ->get();
           return view('admin.completeplan_program.index',compact('page_title','page_description','currentyear_completeplan')); 
           // dd($currentyear->numeric_fiscal_year, $currentyear->end_date,'else');
       }
    }
    public function edit($id)
    {
        $page_title = 'सम्झौता भएको योजना';
        $page_description = 'सम्झौता भएको (संचालनमा रहेको) योजना/कार्यक्रम';

        $findplan = PlanRegister::find($id);
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
        $findorganization=$findagreement[0]->prjrunning_committee; 
        $orgdetails=Consumer::with('orgdetail')->where('Id', $findorganization)->first();
        // dd($orgdetails);
        $findcost= CostEstimate::where('operationid', $id)->get();
        $planPhoto = PlanPhotoFile::where('pms_operation_id', $id)->first();
        $extensionDetail = ExtensionDetail::where('pms_operation_id', $id)->first();

        return view('pms.agreed.edit',compact('consumercommittee','findagreement','orgdetails','expenditures','findcost','programs','areas','subareas','activities','appropriations','units','years','grants','findplan','page_title','page_description', 'planPhoto', 'extensionDetail'));
    }

    public function updatePhoto(Request $request, $id)
    {
        try{
            $planPhotoFile = PlanPhotoFile::where('pms_operation_id', $id)->first();
            
            if (empty($planPhotoFile)){
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = $image->getClientOriginalName();
                    $uniqueName = time() . '-' . $imageName;
                    $image->move(public_path() . '/plan-photo-images/', $uniqueName);
                    
                    $request['image'] = $uniqueName;
                }
    
                $planPhotoFile = PlanPhotoFile::create([
                    'pms_operation_id' => $id,
                    'photo_or_file' => $uniqueName,
                    'photo_file_details' => $request['photoCaption'],
                ]);
            }
            else{
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = $image->getClientOriginalName();
                    $uniqueName = time() . '-' . $imageName;
                    $image->move(public_path() . '/plan-photo-images/', $uniqueName);
                    
                    $request['image'] = $uniqueName;
        
                    File::delete(public_path().'/plan-photo-images/'. $planPhotoFile->photo_or_file);
                    PlanPhotoFile::where('pms_operation_id', $id)->update(['photo_or_file' => $uniqueName]);
                }
    
                $planPhotoFile = PlanPhotoFile::where('pms_operation_id', $id)->update([
                    'photo_file_details' => $request['photoCaption'],
                ]);
            }

            Flash::success('Data saved successfully !!!');
            return redirect()->back();
        }
        catch (\Exception $e){
            $message = $e->getMessage();
            Flash::error($message);
            return redirect()->back();
        }
        
    }

    public function updateExtension(Request $request, $id)
    {
        try{
            $extensionDetail = ExtensionDetail::where('pms_operation_id', $id)->first();
            
            if (empty($extensionDetail)){
    
                $extensionDetail = ExtensionDetail::create([
                    'pms_operation_id' => $id,
                    'request_date' => $request['request_date'],
                    'office_letter_date' => $request['office_letter_date'],
                    'completed_date' => $request['completed_date'],
                    'extension_reason' => $request['extension_reason'],
                ]);
            }
            else{
                $extensionDetail = ExtensionDetail::where('pms_operation_id', $id)->update([
                    'request_date' => $request['request_date'],
                    'office_letter_date' => $request['office_letter_date'],
                    'completed_date' => $request['completed_date'],
                    'extension_reason' => $request['extension_reason'],
                ]);
            }

            Flash::success('Data saved successfully !!!');
            return redirect()->back();
        }
        catch (\Extension $e){
            $message = $e->getMessage();
            Flash::error($message);
            return redirect()->back();
        }
    }
    public function financial_transaction(Request $request){
        $data= FinancialTransaction::create([
            'appropriationamt' => $request->appropriationamt,
            'amtbyoffice' => $request->amtbyoffice,
            'paymentamt' => $request->paymentamt,
            'remainingamt' => $request->remainingamt,
            'type' => $request->prjcondition,
            'operationid' => $request->operationid
        ]);
        Flash::success('Financial Transaction saved successfully !!!');
        return redirect()->back();
    }
    public function currentedit($id){
        $page_title = 'सम्पन्न भएको योजना ';
        $page_description = 'यस बर्ष सम्पन्न भएको योजन/कार्यक्रम';

        $findplan = PlanRegister::find($id);
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
        $findorganization=$findagreement[0]->prjrunning_committee; 
        $orgdetails=Consumer::with('orgdetail')->where('Id', $findorganization)->first();
        // dd($orgdetails);
        $findcost= CostEstimate::where('operationid', $id)->get();
        $planPhoto = PlanPhotoFile::where('pms_operation_id', $id)->first();
        $extensionDetail = ExtensionDetail::where('pms_operation_id', $id)->first();
        $findfinancialtransaction= \App\Models\FinancialTransaction::where('operationid', $id)->first();

        return view('admin.completeplan_program.edit',compact('consumercommittee','findagreement','orgdetails','expenditures','findcost','programs','areas','subareas','activities','appropriations','units','years','grants','findplan','page_title','page_description', 'planPhoto', 'extensionDetail', 'findfinancialtransaction'));  
    }
}
