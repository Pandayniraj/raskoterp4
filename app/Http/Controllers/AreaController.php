<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use Flash;
use Carbon\Carbon;

class AreaController extends Controller
{
    public function __construct(Area $area)
    {
        $this->area = $area;
    }
    public function index(){
        
       $areas = $this->area::all();
        $page_title = 'Admin | Area Management';
        return view('others.area',compact('areas', 'page_title'));
    }
    public function create(){
        $page_title = 'Admin | Area Management';
        $page_description = 'Create new Area';
        return view('others.areacreate', compact('page_title','page_description'));
    }
    public function store(Request $request){
        $input= Area::create([
            'Name' => $request->name,
            'Amount' => $request->amount,
            'IsEnable' => $request->status,
            'CreatedOn' => Carbon::now(),
            'UpdatedOn' => Carbon::now()
        ]);
        Flash::success('Area SuccessFully Created');
        return redirect('/admin/area');
    }
    public function edit($id){  
        $findarea= Area::find($id);
        $page_title = 'Admin | Area Management';
        $page_description = 'Update Area';
        return view('others.areaedit', compact('findarea','page_title','page_description'));
    }
    public function update( Request $request, $id){
        $updatearea= Area::where('Id', $id)->update([
            'Name' => $request->name,
            'Amount' => $request->amount,
            'IsEnable' => $request->status,
            'UpdatedOn' => Carbon::now()
        ]);
        Flash::success('Area SuccessFully Updated');
        return redirect('/admin/area');
    }
    public function delete($id){
        $area = Area::where('Id', $id)->delete();
        Flash::success('Area Successfully Deleted');
        return redirect('/admin/area');
    }
}
