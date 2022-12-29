<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMembersDetail;
use Flash;

class HouseholdFamilyMemberDetailsController extends Controller
{
    
    public function index()
    {
        
    }

    
    public function create($id)
    {
        $page_title = 'परिवारको सदस्यको विवरण';
        $page_description = '';
        $householdId = $id;

        return view('admin.household.family-member-details.create', compact('page_title', 'page_description', 'householdId'));
    }

    
    public function store(Request $request)
    {
        $create = FamilyMembersDetail::create($request->all());

        if ($create){
            Flash::success('Family member details added successfully !!!');
            return redirect('/admin/household/'. $request->household_id);
        }
        else{
            Flash::error('Failed to add family member details !!!');
            return redirect()->back();
        }
    }

    
    public function show($householdId, $id)
    {
        $householdFamilyMembersDetail = FamilyMembersDetail::where('id', $id)->first();

        return view('admin.household.family-member-details.show', compact('householdFamilyMembersDetail', 'householdId'));
    }

    
    public function edit($householdId, $id)
    {
        $edit = FamilyMembersDetail::where('id', $id)->first();

        if ($edit){
            return view('admin.household.family-member-details.edit', compact('edit', 'householdId'));
        }
        else{
            return redirect()->back();
        }
    }

    
    public function update(Request $request, $id)
    {
        $update = FamilyMembersDetail::where('id', $id)->update($request->except(['_token', '_method', 'household_id']));

        if ($update){
            Flash::success('Family member details updated successfully !!!');
            return redirect('/admin/household/'. $request['household_id']);
        }
        else{
            Flash::error('Failed to update family member details !!!');
            return redirect()->back();
        }
    }

    
    public function destroy($id)
    {
        $delete = FamilyMembersDetail::where('id', $id)->delete();

        if ($delete){
            Flash::success('Family member detail deleted successfully !!!');
            return redirect()->back();
        }
        else{
            Flash::error('Failed to delete family member details !!!');
            return redirect()->back();
        }
    }
}
