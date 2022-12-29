<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailAboutField;
use Flash;

class HouseholdFieldController extends Controller
{
    public function index()
    {
        
    }

    
    public function create($id)
    {
        $page_title = 'बालीनालीको विवरण';
        $page_description = '';
        $householdId = $id;

        return view('admin.household.field.create', compact('page_title', 'page_description', 'householdId'));
    }

    
    public function store(Request $request)
    {
        $create = DetailAboutField::create($request->all());

        if ($create){
            Flash::success('Data added successfully !!!');
            return redirect('/admin/household/'. $request->household_id);
        }
        else{
            Flash::error('Failed to add data !!!');
            return redirect()->back();
        }
    }

    
    public function show($householdId, $id)
    {
        $fields = DetailAboutField::where('id', $id)->first();

        return view('admin.household.field.show', compact('fields', 'householdId'));
    }

    
    public function edit($householdId, $id)
    {
        $edit = DetailAboutField::where('id', $id)->first();

        if ($edit){
            return view('admin.household.field.edit', compact('edit', 'householdId'));
        }
        else{
            return redirect()->back();
        }
    }

    
    public function update(Request $request, $id)
    {
        $update = DetailAboutField::where('id', $id)->update($request->except(['_token', '_method', 'household_id']));

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
        $delete = DetailAboutField::where('id', $id)->delete();

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
