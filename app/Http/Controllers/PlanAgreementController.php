<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanAgreement;
use Flash;
use Carbon\Carbon;
class PlanAgreementController extends Controller
{
    //
    public function store(Request $request ){
        $agreement= $request->all();
        // dd($agreement);
        $agreement['createdat'] = Carbon::now();
        $agreement['updatedat'] = carbon::now();
        //  dd($agreement);
        PlanAgreement::create($agreement);
        Flash::success('Plan Agreement SuccessFully Created');
        return redirect()->back();
    }

    public function update(Request $request, $id){
        $agreement= PlanAgreement::find($id);  
        $up=PlanAgreement::where('id', $id)->update([
            'prjrunning_committee'=> $request->prjrunning_committee,
            'agreementdate'=> $request->agreementdate,
            'startdate'=>$request->startdate,
            'completiondate'=> $request->completiondate,
            'householdnumber'=> $request->householdnumber,
            'population'=>$request->population,
            'remarks'=> $request->remarks,
            'updatedat'=> Carbon::now(),
            'operationid'=>$request->operationid,
        ]);
        Flash::success('Plan Agreement SuccessFully Updated');
        return redirect()->back();
}
}
