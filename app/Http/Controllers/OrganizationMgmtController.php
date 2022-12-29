<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationMgmt;
use Flash;
use Carbon\Carbon;

class OrganizationMgmtController extends Controller
{
    //
    public function index(){
        $details = OrganizationMgmt::all();
        $page_title = 'कम्पनी/कर्मचारी/ब्यक्ति व्यवस्थापन';
        return view('organizationmgmt.index', compact('page_title','details'));
     }
     public function create(){
        $page_title = 'कम्पनी/कर्मचारी/ब्यक्ति व्यवस्थापन';
        $page_description = 'Create new Org/Staff/Person';
         return view('organizationmgmt.create', compact('page_title','page_description'));
     }

     public function store(Request $request){
         $input= OrganizationMgmt::create([
            'Type' => $request->type,  
             'Name' => $request->name,
             'Address' => $request->address,
             'ContactNumber' => $request->contact,
             'EstablishedDate' => $request->date,
             'NoOfMember' => $request->members,
             'NoOfPresentNumber' => $request->staff,
             'IsEnable' => $request->status,
             'NameOfBank' => $request->bankname,
             'BankAccountNo' => $request->accountno,
             'Remarks'=>$request->remarks,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now(),
            //  dd($request->staff),
         ]);
         Flash::success('Org/Staff/Person SuccessFully Created');
         return redirect('/admin/organizationmgmt');
     }
     public function edit($id){  
        $findorganization = OrganizationMgmt::find($id);
         $page_title = 'कम्पनी/कर्मचारी/ब्यक्ति व्यवस्थापन';
         $page_description = 'Update Org/Staff/Person';
         return view('organizationmgmt.edit', compact('findorganization','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= OrganizationMgmt::where('Id', $id)->update([
            'Type' => $request->type,  
             'Name' => $request->name,
             'Address' => $request->address,
             'ContactNumber' => $request->contact,
             'EstablishedDate' => $request->date,
             'NoOfMember' => $request->members,
             'NoOfPresentMember' => $request->staff,
             'IsEnable' => $request->status,
             'NameOfBank' => $request->bankname,
             'BankAccountNo' => $request->accountno,
             'Remarks'=>$request->remarks,
             'UpdatedOn' => Carbon::now(),
         ]);
         Flash::success('Org/Staff/Person SuccessFully Updated');
         return redirect('/admin/organizationmgmt');
     }
     public function delete($id){
         $org = OrganizationMgmt::where('Id', $id)->delete();
         Flash::success('Org/Staff/Person Successfully Deleted');
         return redirect('/admin/organizationmgmt');
     }
}
