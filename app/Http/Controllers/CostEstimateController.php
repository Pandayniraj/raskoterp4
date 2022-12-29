<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CostEstimate;
use App\Models\PlanRegister;
use Flash;
use Carbon\Carbon;

class CostEstimateController extends Controller
{
    //
    public function store(Request $request ){
        $allcost= $request->all();
        $allcost['createdat'] = Carbon::now();
        $allcost['updatedat'] = carbon::now();
        CostEstimate::create($allcost);
        PlanRegister::where('Id', $request->operationid)->update(['expenditurehead'=>$request->totalcost]);
        Flash::success('Cost Estimate SuccessFully Created');
        return redirect()->back();
    }

    public function update(Request $request, $id){
  
        $allcost= CostEstimate::find($id);
    
        $up=CostEstimate::where('id', $id)->update([
            'grantamt'=> $request->grantamt,
            'othergrant'=> $request->othergrant,
            'partnershipamt'=>$request->partnershipamt,
            'partnershiporg'=> $request->partnershiporg,
            'cashshare'=> $request->cashshare,
            'totalcontingency'=>$request->totalcontingency,
            'contingencyper'=> $request->contingencyper,
            'contingencyamt'=> $request->contingencyamt,
            'otherdeducper'=>$request->otherdeducper,
            'otherdeducamt'=> $request->otherdeducamt,
            'amtbyoffice'=> $request->amtbyoffice,
            'labordonation'=>$request->labordonation,
            'totalcost'=> $request->totalcost,
            'operationid'=>$request->operationid,
        ]);
        // dd('updated');
        PlanRegister::where('Id', $request->operationid)->update(['expenditurehead'=>$request->totalcost]);
        Flash::success('Cost Estimate SuccessFully Updated');
        return redirect()->back();
    }
}
