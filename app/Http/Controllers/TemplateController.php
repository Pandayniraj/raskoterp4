<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Flash;
use Carbon\Carbon;

class TemplateController extends Controller
{
    //
    public function index(){
        $templates = Template::all();
        $page_title = 'Admin | Template Management';
        return view('others.template', compact('page_title','templates'));
     }
     public function create(){
         $page_title = 'Admin | Template Management';
         $page_description = 'Create new Template';
         return view('others.templatecreate', compact('page_title','page_description'));
     }
     public function store(Request $request){
        
         $input= Template::create([  
             'Name' => $request->template,
             'Content' => $request->subject,
             'Sortkey' => $request->sn,
             'Remarks' => $request->detail,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Template Successfully Created');
         return redirect('/admin/template');
     }
     public function edit($id){  
         $findtemplate = Template::find($id);
         $page_title = 'Admin | Template Management';
         $page_description = 'Update Template';
         return view('others.templateedit', compact('findtemplate','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= Template::where('Id', $id)->update([
            'Name' => $request->template,
            'Content' => $request->subject,
            'Sortkey' => $request->sn,
            'Remarks' => $request->detail,
            'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Template Successfully Updated');
         return redirect('/admin/template');
     }
     public function delete($id){
         $area = Template::where('Id', $id)->delete();
         Flash::success('Template Successfully Deleted');
         return redirect('/admin/template');
     }
}
