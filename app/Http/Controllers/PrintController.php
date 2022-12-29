<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function printone($id){
        $planagreement= \App\Models\PlanAgreement::where('operationid',$id)->first();
        $plandetail=\App\Models\Consumer::find($planagreement->prjrunning_committee);
        $consumerdetail=\App\Models\ConsumerDetail::where('OrganizationId', $plandetail->Id)->groupBy('DesignationId')->get();
        $designation=$consumerdetail->groupBy('DesignationId');
        $fiscalyear=\App\Models\Fiscalyear::latest()->first();
        $costdetail=\App\Models\CostEstimate::where('operationid',$id)->first();
        $plan=\App\Models\PlanRegister::find($id);
        return view('admin.printfiles.printone',compact('plandetail', 'consumerdetail','fiscalyear','designation','planagreement','costdetail','plan'));
    }
    public function printtwo($id){
        $planagreement= \App\Models\PlanAgreement::where('operationid',$id)->select('prjrunning_committee')->first();
        $plandetail=\App\Models\Consumer::find($planagreement->prjrunning_committee);
        $fiscalyear=\App\Models\Fiscalyear::latest()->first();
        return view('admin.printfiles.printtwo',compact('plandetail', 'fiscalyear'));
    }
    public function printthree($id){
        $planagreement= \App\Models\PlanAgreement::where('operationid',$id)->select('prjrunning_committee','agreementdate','startdate')->first();
        $plandetail=\App\Models\Consumer::find($planagreement->prjrunning_committee);
        $consumerdetail=\App\Models\ConsumerDetail::where('OrganizationId', $plandetail->Id)->groupBy('DesignationId')->get();
        $designation=$consumerdetail->groupBy('DesignationId');
        $fiscalyear=\App\Models\Fiscalyear::latest()->first();
        $costdetail=\App\Models\CostEstimate::where('operationid',$id)->first();
        return view('admin.printfiles.printthree',compact('plandetail', 'fiscalyear','designation','planagreement','costdetail'));
    }
    public function printfour($id){
        $planagreement= \App\Models\PlanAgreement::where('operationid',$id)->select('prjrunning_committee','agreementdate')->first();
        $plandetail=\App\Models\Consumer::find($planagreement->prjrunning_committee);
        $consumerdetail=\App\Models\ConsumerDetail::where('OrganizationId', $plandetail->Id)->groupBy('DesignationId')->get();
        $designation=$consumerdetail->groupBy('DesignationId');
        $fiscalyear=\App\Models\Fiscalyear::latest()->first();
        $amount=\App\Models\PlanRegister::find($id);
        return view('admin.printfiles.printfour',compact('plandetail', 'fiscalyear','designation','amount','planagreement'));
    }
    public function printfive($id){
        $planagreement= \App\Models\PlanAgreement::where('operationid',$id)->select('prjrunning_committee')->first();
        $plandetail=\App\Models\Consumer::find($planagreement->prjrunning_committee);
        $fiscalyear=\App\Models\Fiscalyear::latest()->first();
        $consumerdetail=\App\Models\ConsumerDetail::where('OrganizationId', $plandetail->Id)->groupBy('DesignationId')->get();
        $designation=$consumerdetail->groupBy('DesignationId');
        return view('admin.printfiles.printfive',compact('plandetail', 'fiscalyear','designation'));
    }
    public function printsix($id){
        $planagreement= \App\Models\PlanAgreement::where('operationid',$id)->select('prjrunning_committee')->first();
        $plandetail=\App\Models\Consumer::find($planagreement->prjrunning_committee);
        $fiscalyear=\App\Models\Fiscalyear::latest()->first();
        return view('admin.printfiles.printsix',compact('plandetail', 'fiscalyear'));

    }
}
