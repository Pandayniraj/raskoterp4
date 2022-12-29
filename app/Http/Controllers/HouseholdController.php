<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\AnswerDetail;
use App\Models\Household;
use App\Models\FamilyMembersDetail;
use App\Models\DetailsOfQuadrupedsAndLivestock;
use App\Models\DetailAboutField;
use Flash;
use Illuminate\Support\Facades\DB;
use File;

class HouseholdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = "Admin | घरधुरी सर्वेक्षणको विवरण व्यवस्थापन";
        $page_description = "घरधुरी सर्वेक्षण";

        $castes = \App\Models\Caste::where('status', 1)->orderBy('order', 'ASC')->pluck('display_name', 'name');
        $educations = \App\Models\Education::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $occupations = \App\Models\Occupation::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $institutes = \App\Models\Institute::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $timePeriods = \App\Models\FeedingTimePeriodByOwnProductionOrIncome::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $houseBasements = \App\Models\HouseBasement::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $roofTypeOfHouses = \App\Models\RoofTypeOfHouse::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $stoveTypes = \App\Models\StoveType::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $toiletTypes = \App\Models\ToiletType::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $sourceOfDrinkingWaters = \App\Models\SourceOfDrinkingWater::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        $wardNos = \App\Models\WardNo::where('status', 1)->orderBy('display_order', 'ASC')->pluck('display_name', 'name');
        // dd($castes);

        $households = DB::table('households');

                    if (!empty($request['uttardata_contact_no']) && !is_null($request['uttardata_contact_no'])){
                        $households = $households->where('uttardata_contact_no', 'LIKE', '%'. $request['uttardata_contact_no'] .'%');
                    }

                    if (!empty($request['main_caste']) && !is_null($request['main_caste'])){
                        $households = $households->where('main_caste', 'LIKE', '%'. $request['main_caste'] .'%');
                    }

                    if (!empty($request['if_connected_with_any_institution_name_it']) && !is_null($request['if_connected_with_any_institution_name_it'])){
                        $households = $households->where('if_connected_with_any_institution_name_it', 'LIKE', '%'. $request['if_connected_with_any_institution_name_it'] .'%');
                    }

                    if (!empty($request['how_long_months_does_your_production_or_income_feed_your_family']) && !is_null($request['how_long_months_does_your_production_or_income_feed_your_family'])){
                        $households = $households->where('how_long_months_does_your_production_or_income_feed_your_family', 'LIKE', '%'. $request['how_long_months_does_your_production_or_income_feed_your_family'] .'%');
                    }

                    if (!empty($request['types_of_your_house_jog']) && !is_null($request['types_of_your_house_jog'])){
                        $households = $households->where('types_of_your_house_jog', 'LIKE', '%'. $request['types_of_your_house_jog'] .'%');
                    }

                    if (!empty($request['roof_types_of_your_home']) && !is_null($request['roof_types_of_your_home'])){
                        $households = $households->where('roof_types_of_your_home', 'LIKE', '%'. $request['roof_types_of_your_home'] .'%');
                    }

                    if (!empty($request['source_of_firewood']) && !is_null($request['source_of_firewood'])){
                        $households = $households->where('source_of_firewood', 'LIKE', '%'. $request['source_of_firewood'] .'%');
                    }

                    if (!empty($request['type_of_toilet']) && !is_null($request['type_of_toilet'])){
                        $households = $households->where('type_of_toilet', 'LIKE', '%'. $request['type_of_toilet'] .'%');
                    }

                    if (!empty($request['source_of_drinking_water']) && !is_null($request['source_of_drinking_water'])){
                        $households = $households->where('source_of_drinking_water', 'LIKE', '%'. $request['source_of_drinking_water'] .'%');
                    }

                    if (!empty($request['ward_no']) && !is_null($request['ward_no'])){
                        $households = $households->where('ward_no', 'LIKE', '%'. $request['ward_no'] .'%');
                    }

                    $households = $households->orderBy('id', 'ASC')->paginate(20);

        return view('admin.household.index', compact('households', 'page_title', 'page_description', 
                    'castes', 'educations', 'occupations', 'institutes', 'timePeriods', 'houseBasements',
                    'roofTypeOfHouses', 'stoveTypes', 'toiletTypes', 'sourceOfDrinkingWaters', 'wardNos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Admin | घरधुरी सर्वेक्षणको विवरण व्यवस्थापन";
        $page_description = "घरधुरी सर्वेक्षण";

        return view('admin.household.create', compact('page_title', 'page_description'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try{
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = $image->getClientOriginalName();
                $uniqueName = time() . '-' . $imageName;
                $image->move(public_path() . '/household-images/', $uniqueName);
    
                $request['image'] = $uniqueName;
            }
    
    
            $create = Household::create($request->all());
    
            if ($create){
                Flash::success('Household created successfully !!!');
                return redirect()->route('household.index');
            }
            else{
                Flash::error('Failed to create household !!!');
                return redirect()->back();
            }
        }
        catch(\Exception $e){
            Flash::error('Error Occured,  failed to create household !!!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $page_title = 'Admin | घरधुरी सर्वेक्षणको विवरण व्यवस्थापन';
            $page_description = 'घरधुरी सर्वेक्षण';

            $household = Household::where('id', $id)->first();
            $householdFamilyMembers = FamilyMembersDetail::where('household_id', $household->id)->get();
            $quadrupeds = DetailsOfQuadrupedsAndLivestock::where('household_id', $household->id)->get();
            $fields = DetailAboutField::where('household_id', $household->id)->get();

            return view('admin.household.show', compact('household', 'page_title', 'page_description', 'householdFamilyMembers', 'quadrupeds', 'fields'));
            
        }
        catch(\Exception $e){
            Flash::error('Due to some problem, it is failed to create household !!!');
            return redirect()->back();
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $edit = Household::find($id);
    
            if ($edit){
                return view('admin.household.edit', compact('edit'));
            }
            else{
                Flash::error('Unknown request !!!');
                return redirect()->route('household.index');
            }
        }
        catch(\Exception $e){
            Flash::error('Due to some problem, it is failed to create household !!!');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = $image->getClientOriginalName();
            $uniqueName = time() . '-' . $imageName;
            $image->move(public_path() . '/household-images/', $uniqueName);
            
            $request['image'] = $uniqueName;

            $household = Household::where('id', $id)->first();
            File::delete(public_path().'/household-images/'. $household->image);
        }

        $update = Household::where('id', $id)->update($request->except('_token', '_method', 'img'));
        

        if ($update){
            Flash::success('Household updated successfully !!!');
            return redirect()->route('household.index');
        }
        else{
            Flash::error('Failed to update household !!!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FamilyMembersDetail::where('household_id', $id)->delete();
        DetailsOfQuadrupedsAndLivestock::where('household_id', $id)->delete();
        DetailAboutField::where('household_id', $id)->delete();

        $household = Household::where('id', $id)->first();
        File::delete(public_path().'/household-images/'. $household->image);
        $delete = Household::where('id', $id)->delete();


        if ($delete){
            Flash::success('Household deleted successfully !!!');            
            return redirect()->route('household.index');
        }
        else{
            Flash::error('Failed to delete household !!!');            
            return redirect()->back();
        }
    }
}
