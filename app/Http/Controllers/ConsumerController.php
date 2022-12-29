<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\ConsumerDetail;
use App\Models\Post;
use Flash;
use Carbon\Carbon;


class ConsumerController extends Controller
{
    //
    public function index(){
        $consumers = Consumer::all();
        $page_title = 'उपभोक्ता समिति व्यवस्थापन';
        return view('consumer.index', compact('consumers', 'page_title'));
    }
    public function create(){
        $designations = Post::select('Name', 'Id')->get();
        $page_title='उपभोक्ता समिति व्यवस्थापन';
        $page_description = 'Create new Consumer Committee';
        return view('consumer.create', compact('page_title','page_description','designations'));
    }
    public function store(Request $request){

        $arr = $request->all();
        $data['Type'] = $arr['Type'];
        $data['Name'] = $arr['org_Name'];
        $data['Address'] = $arr['org_Address'];
        $data['ContactNumber'] = $arr['org_ContactNumber'];
        $data['EstablishedDate'] = $arr['EstablishedDate'];
        $data['NoOfMember'] = $arr['NoOfMember'];
        $data['NoOfPresentMember'] = $arr['NoOfPresentMember'];
        $data['NameOfBank'] = $arr['NameOfBank'];
        $data['BankAccountNo'] = $arr['BankAccountNo'];
        $data['Remarks'] = $arr['Remarks'];
        $data['CreatedOn'] = Carbon::now();
        $data['UpdatedOn'] = Carbon::now();
        $data['IsEnable'] = $arr['IsEnable'];
        $data['NoOfFemale'] = $arr['NoOfFemale'];
        $data['NoOfMonitoring'] = $arr['NoOfMonitoring'];
        // dd($arr);
        $id = \App\Models\Consumer::create($data);
        if(isset($arr['DesignationId']) && $arr['DesignationId'])
        {
            
            foreach($arr['DesignationId'] as $key=>$des)
            {
                $data_arr['OrganizationId'] = $id->id;
                $data_arr['DesignationId'] = $arr['DesignationId'][$key];
                $data_arr['Name'] = $arr['Name'][$key];
                $data_arr['Address'] = $arr['Address'][$key];
                $data_arr['AccountNumber'] = $arr['AccountNumber'][$key];
                $data_arr['ContactNumber'] = $arr['ContactNumber'][$key];
                $data_arr['FatherName'] = $arr['FatherName'][$key];
                $data_arr['GrandFatherName'] = $arr['GrandFatherName'][$key];
                $data_arr['IsSigner'] = $arr['IsSigner'][$key];
                ConsumerDetail::create($data_arr);
            }
        }
        Flash::success('Consumer Committee Management SuccessFully Created');
        return redirect('/admin/consumer');

    }
    public function edit($id){
        $findconsumer = Consumer::find($id);
        $designations = Post::select('Name', 'Id')->get();
        $consumerdetail = ConsumerDetail::where('OrganizationId',$id)->get();
        $page_title='उपभोक्ता समिति व्यवस्थापन';
        $page_description = 'Update Consumer Committee';
        return view('consumer.edit', compact('findconsumer', 'consumerdetail', 'page_title', 'page_description','designations'));

    }
    public function update($id, Request $request){
        $arr = $request->all();
        // dd($arr);
        $data['Type'] = $arr['Type'];
        $data['Name'] = $arr['org_Name'];
        $data['Address'] = $arr['org_Address'];
        $data['ContactNumber'] = $arr['org_ContactNumber'];
        $data['EstablishedDate'] = $arr['EstablishedDate'];
        $data['NoOfMember'] = $arr['NoOfMember'];
        $data['NoOfPresentMember'] = $arr['NoOfPresentMember'];
        $data['NameOfBank'] = $arr['NameOfBank'];
        $data['BankAccountNo'] = $arr['BankAccountNo'];
        $data['Remarks'] = $arr['Remarks'];
        $data['CreatedOn'] = Carbon::now();
        $data['UpdatedOn'] = Carbon::now();
        $data['IsEnable'] = $arr['IsEnable'];
        $data['NoOfFemale'] = $arr['NoOfFemale'];
        $data['NoOfMonitoring'] = $arr['NoOfMonitoring'];
        
        \App\Models\Consumer::where('Id', $id)->update($data);
        if(isset($arr['DesignationId']) && $arr['DesignationId'])
        {
            ConsumerDetail::where('OrganizationId', $id)->delete();
            foreach($arr['DesignationId'] as $key=>$des)
            {
                // dd('hello');
                $data_arr['OrganizationId'] = $id;
                $data_arr['DesignationId'] = $arr['DesignationId'][$key];
                $data_arr['Name'] = $arr['Name'][$key];
                $data_arr['Address'] = $arr['Address'][$key];
                $data_arr['AccountNumber'] = $arr['AccountNumber'][$key];
                $data_arr['ContactNumber'] = $arr['ContactNumber'][$key];
                $data_arr['FatherName'] = $arr['FatherName'][$key];
                $data_arr['GrandFatherName'] = $arr['GrandFatherName'][$key];
                $data_arr['IsSigner'] = $arr['IsSigner'][$key];
                
                ConsumerDetail::create($data_arr);
            }
        }
        Flash::success('Consumer Committee Management SuccessFully Updated');
        return redirect('/admin/consumer');
    }
    public function delete($id){
        $consumer = Consumer::where('Id', $id)->delete();
        $consumerdetail= ConsumerDetail::where('OrganizationId', $id)->delete();
         Flash::success('Consumer Committee Management Successfully Deleted');
         return redirect('/admin/consumer');

    }
}
