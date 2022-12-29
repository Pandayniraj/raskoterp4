<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailsOfQuadrupedsAndLivestock;
use Flash;

class HouseholdQuadrupedsAndLivestocksDetailController extends Controller
{
    public function index()
    {
        
    }

    public function create($id)
    {
        $page_title = 'चौपाया तथा पशुपंक्षीको विवरण';
        $page_description = '';
        $householdId = $id;

        return view('admin.household.quadrupeds-and-livestock.create', compact('page_title', 'page_description', 'householdId'));
    }

    
    public function store(Request $request)
    {
        $create = DetailsOfQuadrupedsAndLivestock::create($request->all());

        if ($create){
            Flash::success('Datas added successfully !!!');
            return redirect('/admin/household/'. $request->household_id);
        }
        else{
            Flash::error('Failed to add data !!!');
            return redirect()->back();
        }
    }

    
    public function show($householdId, $id)
    {
        $quadrupeds = DetailsOfQuadrupedsAndLivestock::where('id', $id)->first();

        return view('admin.household.quadrupeds-and-livestock.show', compact('quadrupeds', 'householdId'));
    }

    
    public function edit($householdId, $id)
    {
        $edit = DetailsOfQuadrupedsAndLivestock::where('id', $id)->first();

        if ($edit){
            return view('admin.household.quadrupeds-and-livestock.edit', compact('edit', 'householdId'));
        }
        else{
            return redirect()->back();
        }
    }

    
    public function update(Request $request, $id)
    {
        $update = DetailsOfQuadrupedsAndLivestock::where('id', $id)->update($request->except(['_token', '_method', 'household_id']));

        if ($update){
            Flash::success('Data updated successfully !!!');
            return redirect('/admin/household/'. $request['household_id']);
        }
        else{
            Flash::error('Failed to update data !!!');
            return redirect()->back();
        }
    }

    
    public function destroy($id)
    {
        $delete = DetailsOfQuadrupedsAndLivestock::where('id', $id)->delete();

        if ($delete){
            Flash::success('Data deleted successfully !!!');
            return redirect()->back();
        }
        else{
            Flash::error('Failed to delete data !!!');
            return redirect()->back();
        }
    }
}
