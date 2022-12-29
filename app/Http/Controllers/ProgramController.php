<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Flash;
use Carbon\Carbon;

class ProgramController extends Controller
{
    //
    public function index(){
        $programs = Program::all();
        $page_title = 'Admin|Program';
        return view('program.index', compact('page_title','programs'));
     }
     public function create(){
        $page_title = 'Admin| Program';
        $page_description = 'Create new Program';
         return view('program.create', compact('page_title','page_description'));
     }
     public function store(Request $request){
        //  dd($request->sn, $request->status);
         $input= program::create([  
             'name' => $request->name,
             'createdon' => Carbon::now(),
             'updatedon' => Carbon::now(),
         ]);
         Flash::success('Program SuccessFully Created');
         return redirect('/admin/program');
     }
     public function edit($id){
        $findprogram = Program::find($id);
        $page_title = 'Admin| Program';
        $page_description = 'Create new Program';  
         return view('program.edit', compact('findprogram','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= Program::where('Id', $id)->update([
            'name' => $request->name,
            'updatedon' => Carbon::now(),
         ]);
         Flash::success('Program SuccessFully Updated');
         return redirect('/admin/program');
     }
     public function delete($id){
         $area = Program::where('Id', $id)->delete();
         Flash::success('Program Successfully Deleted');
         return redirect('/admin/program');
     }
}
