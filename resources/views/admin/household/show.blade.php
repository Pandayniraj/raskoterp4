@extends('layouts.master')

@section('head_extra')
    <!-- Select2 css -->
    @include('partials._head_extra_select2_css')

@endsection

{{-- <link href="/bower_components/admin-lte/select2/css/select2.min.css" rel="stylesheet" /> --}}

@section('content')

<link href="/bower_components/admin-lte/select2/css/select2.min.css" rel="stylesheet" />


<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
    <h1>
      {{ $page_title ?? 'Page Title' }}
        <small>{{$page_description ?? 'Page Description'}}</small>
    </h1>
   
    {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false) !!}
</section>

 <div class='row'>
   <div class='col-md-12'>
      <div class="box">
         <div class="box-body">

            <div class="row">

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">सर्वेक्षणकर्ताको नाम थर</label>
                    <p>{{ !empty($household)? $household->name : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">सर्वेक्षणकर्ताको मोबाईल नं.</label>
                    <p>{{ !empty($household)? $household->mobile_no : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घरमुली/उत्तरदाताको वडा नं.</label>
                    <p>{{ !empty($household)? $household->ward_no : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घरमुली/उत्तरदाता वस्ती/टोलको नाम</label>
                    <p>{{ !empty($household)? $household->tole_name : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घर पुग्ने बाटो/सडकको प्रकार</label>
                    <p>{{ !empty($household)? $household->road_type : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घर नम्बर छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->is_there_house_number : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घर नम्बर उल्लेख गर्नुहोला ?</label>
                    <p>{{ !empty($household)? $household->house_number : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घर पुग्ने बाटो/सडकको स्तर</label>
                    <p>{{ !empty($household)? $household->road_level : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">उत्तरदाताको नाम थर</label>
                    <p>{{ !empty($household)? $household->uttardata_name : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">उत्तरदाताको सम्पर्क नं/उत्तरदातासंग सम्पर्क हुने नं ?</label>
                    <p>{{ !empty($household)? $household->uttardata_contact_no : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">उत्तरदाताको घरमुली संग के नाता पर्ने हो ?</label>
                    <p>{{ !empty($household)? $household->uttardatako_gharmuli_relation : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मुख्य जाति</label>
                    <p>{{ !empty($household)? $household->main_caste : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">जाति</label>
                    <p>{{ !empty($household)? $household->caste : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवार संख्या (घरमुली सहित)</label>
                    <p>{{ !empty($household)? $household->family_number_with_gharmuli : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">पालिका भन्दा बाहिर बाट आएर भाडामा बसोबास गर्नेको संख्या</label>
                    <p>{{ !empty($household)? $household->no_of_rent_stay : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाई अरु ठाउँबाट वसाईसराई गरी आउनु भएको हो ?</label>
                    <p>{{ !empty($household)? $household->are_you_migrated : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कहाँबाट आएको</label>
                    <p>{{ !empty($household)? $household->came_from : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कति वर्ष पहिले</label>
                    <p>{{ !empty($household)? $household->came_from_year : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
                    <label class="control-label">वसाईसरी आउनुको कारण</label>
                    <p>{{ !empty($household)? $household->reason_behind_migration : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारको कुनै सदस्य बिरामी भएमा उपचारका लागि सवैभन्दा पहिला कहा जानुहुन्छ ?</label>
                    <p>{{ !empty($household)? $household->member_treatment_place_at_first : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
                    <label class="control-label">उपस्वास्थ्य चौकी (हेल्थसेन्टर) रहेको स्थान</label>
                    <p>{{ !empty($household)? $household->sub_healthpost_place : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">उपस्वास्थ्य चौकी पुग्न लाग्ने समय (मिनेट)</label>
                    <p>{{ !empty($household)? $household->time_for_going_to_subhealth_post_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अस्पताल रहेको स्थान</label>
                    <p>{{ !empty($household)? $household->hospital_place : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अस्पताल पुग्न लाग्ने समय (मिनेट)</label>
                    <p>{{ !empty($household)? $household->time_for_going_to_hospital_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">बालविकास केन्द्र (मिनेट)</label>
                    <p>{{ !empty($household)? $household->child_development_centre_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">आ.वि. (मिनेट)</label>
                    <p>{{ !empty($household)? $household->aa_vi_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मा. वि. (मिनेट)</label>
                    <p>{{ !empty($household)? $household->ma_vi_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">उ.मा.वि (मिनेट)</label>
                    <p>{{ !empty($household)? $household->u_ma_vi_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">क्याम्पस (मिनेट)</label>
                    <p>{{ !empty($household)? $household->campus_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">नजिकको प्रहरी चौकी पुग्न लाग्ने समय (मिनेट)</label>
                    <p>{{ !empty($household)? $household->time_for_going_to_nearest_police_station_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">नजिकको बैंक पुग्न लाग्ने समय (मिनेट)</label>
                    <p>{{ !empty($household)? $household->time_for_going_to_nearest_bank_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">नजिकको बजार पुग्न लाग्ने समय (मिनेट)</label>
                    <p>{{ !empty($household)? $household->time_for_going_to_nearest_bazar_in_minute : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कुपोषण लागेका बालबालिका छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->is_there_malnutritioned_children : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">१८ वर्ष भन्दा कम उमेरका बालबालिका कामको लागि घर देखि बाहिर गएका छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->is_below_18_year_child_going_for_work : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">१८ वर्ष भन्दा कम उमेरका बालबालिका कामको लागि घर देखि बाहिर गएका छन् भने संख्या ?</label>
                    <p>{{ !empty($household)? $household->no_of_if_below_18_years_child_going_for_work : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईका घरपरिवारका सदस्य बैदेशिक रोजगारमा जानुभएको छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->are_family_members_going_for_foreign_employment : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईका घरपरिवारका सदस्य बैदेशिक रोजगारमा कति जना जानुभएको छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_family_members_going_for_foreign_employment : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईका घरपरिवारका सदस्य बैदेशिक रोजगारमा कुन-कुन देशमा जानुभएको छ ?</label>
                    <p>{{ !empty($household)? $household->countries_where_family_members_gone_for_foreign_employment : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको परिवारमा १ बर्षभत्र कुनै सदस्यको मृत्यु भएको छ ?</label>
                    <p>{{ !empty($household)? $household->is_below_1_year_child_died : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मृत्यु भएका मानिसको संख्या</label>
                    <p>{{ !empty($household)? $household->no_of_died_person : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारले प्रयोग गर्ने शौचालय कस्तो प्रकारको छ ?</label>
                    <p>{{ !empty($household)? $household->type_of_toilet : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">हात धुने ठाउँ निश्चित छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->is_handwash_place_fixed : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">साबुन पानीको वयवस्था छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->is_there_arrangement_for_soap_water : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">करेसा बारी छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->is_there_karesa_bari : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारमा गर्भवती हुनुहुन्छ ?</label>
                    <p>{{ !empty($household)? $household->is_there_pregnant_woman : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
                    <label class="control-label">परिवारमा गर्भवतीको संख्या</label>
                    <p>{{ !empty($household)? $household->no_of_pregnant_woman_in_family : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारको सदस्य गर्भवती हुदा ४ पटक गर्भवती जाँच गर्ने गर्नुभएको छ ?</label>
                    <p>{{ !empty($household)? $household->do_pregnant_woman_check_for_4_times : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारको सदस्य गर्भवती भएदेखि सुत्केरी हुन्जेल सम्म पुर्णरुपमा आइरन चक्की खुवाउनु हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->does_pregnant_woman_eat_iron_tablets : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">स्वास्थ्य संस्थाबाट दिने सुबिधा सन्तुष्ट हुनुहुन्छ ?</label>
                    <p>{{ !empty($household)? $household->is_there_satisfaction_for_health_institution_services : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">स्वास्थ्य संस्था जादाँ स्वास्थ्य सेवा उपलव्ध छ ?</label>
                    <p>{{ !empty($household)? $household->is_health_service_available_while_going_to_health_institution : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">सुत्केरी गराउन हेल्थपोस्ट जानुहुन्छ ?</label>
                    <p>{{ !empty($household)? $household->is_pregnant_woman_going_for_healthpost_for_delivery : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">२ वर्ष मुनिको बच्चा संख्या कति छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_below_2_years_child : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">बच्चालाई पूर्ण खोप लगाउने गर्नुभएको छ ?</label>
                    <p>{{ !empty($household)? $household->did_child_get_full_vaccination : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">बच्चाको तौल प्रत्येक महिना लिने गर्नुभएको छ ?</label>
                    <p>{{ !empty($household)? $household->is_there_monthly_record_for_child_weight : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">स्तनपान ६ महिना सम्म निरन्तर रुपमा गराउनु हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->does_mother_breastfeed_for_continuous_6_months : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">६ महिना पछि बच्चालाई थप खाना खुवाउनु हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->is_child_feeded_additional_food_after_6_months : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">बच्चाको दिशा ब्यबस्थापन चर्पीमा गर्नु हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->is_there_arrangement_for_child_stool_in_toilet : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको घरमा फोहोरमैला ब्यबस्थापनको लागि खाडल छ ?</label>
                    <p>{{ !empty($household)? $household->is_there_arrangement_for_pit_for_dirty_things : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">६ महिना देखि ५ वर्ष सम्मको बच्चालाई भिटामिन ए / जुकाको औषधी खुवाएको छ ?</label>
                    <p>{{ !empty($household)? $household->is_child_feeded_medicine_of_vitamin_a_or_worms_from_6_months : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
                    <label class="control-label">समाजिक शुरक्षा भत्ता लिनु भएको छ ?</label>
                    <p>{{ !empty($household)? $household->do_you_take_social_security_allowance : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवार नियोजनको सेवा लिनु भएको छ ?</label>
                    <p>{{ !empty($household)? $household->do_you_take_family_planning_services : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">स्थायी परिवार नियोजन सेवा</label>
                    <p>{{ !empty($household)? $household->permanent_family_planning_services : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अस्थायी परिवार नियोजन सेवा</label>
                    <p>{{ !empty($household)? $household->temporary_family_planning_services : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
                    <label class="control-label">तपाइको घरमा विद्यालयमा पढ्न जाने कति जना हुनुहुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_member_going_for_school : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">एस.ई.ई. भन्दा कम योग्यता भएको (महिला) कति जना हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_female_having_below_s_e_e_certificate : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">एस.ई.ई. भन्दा कम योग्यता भएको (पुरुष) कति जना हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_male_having_below_s_e_e_certificate : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">एस.ई.ई. पास भएको (महिला) कति जना हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_female_passed_s_e_e_certificate : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">एस.ई.ई. पास भएको (पुरुष) कति जना हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_male_passed_s_e_e_certificate : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">स्नातक भन्दा माथि योग्यता भएको (महिला) कति जना हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_female_passed_above_graduate_level : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">स्नातक भन्दा माथि योग्यता भएको (पुरुष) कति जना हुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_male_passed_above_graduate_level : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">३ वर्ष माथि र १५ वर्ष मुनि बिद्यालय छाडेको/नजाने वालवालिका (महिला) कति जना हुनुहुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_female_leaving_school_from_aging_3_years_to_15_years : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">३ वर्ष माथि र १५ वर्ष मुनि बिद्यालय छाडेको/नजाने वालवालिका (पुरुष) कति जना हुनुहुन्छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_male_leaving_school_from_aging_3_years_to_15_years : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">विद्यालय नजाने कारण के हो ?</label>
                    <p>{{ !empty($household)? $household->reason_behind_not_going_for_school : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">विद्यालय जानलाई के-के सुविधा हुनुपर्ने हो ?</label>
                    <p>{{ !empty($household)? $household->services_required_for_going_school : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">बालबालिकालाई घरमा पढ्न समय दिनुभएको छ ?</label>
                    <p>{{ !empty($household)? $household->do_you_give_time_for_child_study : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">सरदर कति समय घरमा पढ्नलाई छुट्याइएको छ (मिनेट) ?</label>
                    <p>{{ !empty($household)? $household->number_of_minutes_for_allocated_for_child_study : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घरमा पढ्नलाई छुट्टै कोठा छ ?</label>
                    <p>{{ !empty($household)? $household->is_there_room_for_study : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कोठामा बत्तिको व्यवस्था छ ?</label>
                    <p>{{ !empty($household)? $household->is_there_management_for_light : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाइको घरबाट सरकारी विद्यालयमा पढ्न जाने बालबालिकले शुल्क तिर्नु भएको छ ?</label>
                    <p>{{ !empty($household)? $household->do_you_pay_for_school_fee_in_government_school : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको घर परिवारका सदस्यहरु विगत २ वर्ष देखि उपभोक्ता/निर्माण समितिमा रहनु भएको छ ?</label>
                    <p>{{ !empty($household)? $household->did_your_family_members_have_engagement_in_consumer_committee : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">उपभोक्ता/निर्माण समितिमा तपाईको पद के हो ?</label>
                    <p>{{ !empty($household)? $household->position_in_consumer_or_construction_committee : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">खानेपानीको मुख्य स्रोत के हो ?</label>
                    <p>{{ !empty($household)? $household->source_of_drinking_water : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">खानेपानी ल्याउन (जाँदा आउँदा) लाग्ने समय</label>
                    <p>{{ !empty($household)? $household->time_taken_for_taking_drinking_water_in_home : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">खाना पकाउन प्रयोग गर्ने मुख्य इन्धन कुन हो ?</label>
                    <p>{{ !empty($household)? $household->main_fuel_for_cooking_food : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">यदि दाउरा भए दाउराको श्रोत कुन हो ?</label>
                    <p>{{ !empty($household)? $household->source_of_firewood : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको घरमा कस्तो प्रकारको चुलो प्रयोग गर्नुहुन्छ ?</label>
                    <p>{{ !empty($household)? $household->type_of_oven_used : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारले प्रयोग गर्ने बत्तीको मुख्य श्रोत कुन हो ?</label>
                    <p>{{ !empty($household)? $household->main_source_of_light_in_family : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कुन कुन सुविधाहरु परिवारले उपभोग गरेको छ ?</label>
                    <p>{{ !empty($household)? $household->consumption_of_services_in_family : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारले कृषि कार्यका लागि जग्गा प्रयोग गरेको छ ?</label>
                    <p>{{ !empty($household)? $household->does_family_used_land_for_agriculture : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">जग्गाको इकाई छान्नुहोस</label>
                    <p>{{ !empty($household)? $household->choose_land_unit : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">आफ्नो परिवारको नाममा रहेको जग्गाको क्षेत्रफल</label>
                    <p>{{ !empty($household)? $household->area_of_land_owned_by_family : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवार बाहेक अरुको नाममा रहेको जग्गाको क्षेत्रफल</label>
                    <p>{{ !empty($household)? $household->area_of_land_not_owned_by_family : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अन्य स्वामित्वमा रहेको जग्गाको क्षेत्रफल</label>
                    <p>{{ !empty($household)? $household->area_of_land_with_others_possession : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अन्य स्वामित्व भए खुलाउनुहोस्</label>
                    <p>{{ !empty($household)? $household->if_possessioned_mention_here : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारका कुनै सदस्यको वैंक तथा वित्तीय संस्थामा खाता छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->is_there_account_in_bank_or_financial_institution : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारको सरदर बार्षिक आम्दानी कति छ (रु मा उल्लेख गर्ने) ?</label>
                    <p>{{ !empty($household)? $household->yearly_income_of_family : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">परिवारको सरदर बार्षिक खर्च कति छ (रु मा उल्लेख गर्ने) ?</label>
                    <p>{{ !empty($household)? $household->yearly_expenses_of_family : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईले बाली उत्पादन वा बिक्री गर्नुभएको छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->have_you_done_production_or_sales_of_field : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको परिवारले कुनै चौपाया तथा पशुपंक्षी पाल्नुभएको छ ?</label>
                    <p>{{ !empty($household)? $household->have_your_family_adopted_quadruped_or_animal_birds : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">डाले घाँसको कुन-कुन प्रजातिको विरुवाहरु लगाईएको छ ?</label>
                    <p>{{ !empty($household)? $household->species_of_daale_grass_used_for_plantation : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">भुइँ घाँसको कुन-कुन प्रजातिको लगाईएको छ ?</label>
                    <p>{{ !empty($household)? $household->species_of_ground_grass_used_for_plantation : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको परिवारमा माछा, मौरी र रेशमपालन गर्नुभएको छ ?</label>
                    <p>{{ !empty($household)? $household->have_your_family_done_fish_bee_silk_farming : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">माछापालन पोखरीको संख्या</label>
                    <p>{{ !empty($household)? $household->no_of_ponds_used_for_fisheries : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">पोखरीको क्षेत्रफल (हेक्टर)</label>
                    <p>{{ !empty($household)? $household->area_of_ponds_in_hectar : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">वार्षिक उत्पादन (के.जी.)</label>
                    <p>{{ !empty($household)? $household->yearly_production_in_kg : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मौरीको घार संख्या (आधुनिक)</label>
                    <p>{{ !empty($household)? $household->no_of_beehives_in_khope_in_modern : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मौरीको घार संख्या (मुढे)</label>
                    <p>{{ !empty($household)? $household->no_of_beehives_in_mude : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मौरीको घार संख्या (खोपे)</label>
                    <p>{{ !empty($household)? $household->no_of_beehives_in_khope : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">वार्षिक मह उत्पादन (के.जी.)</label>
                    <p>{{ !empty($household)? $household->yearly_production_of_maha_in_kg : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">रेशमखेती कोयो संख्या</label>
                    <p>{{ !empty($household)? $household->no_of_silk_farming : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">उत्पादन (के.जी.)</label>
                    <p>{{ !empty($household)? $household->production_in_kg : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">आफ्नो उत्पादन/आम्दानीले तपाईको परिवारलाई कति महिना खान पुग्छ ?</label>
                    <p>{{ !empty($household)? $household->how_long_months_does_your_production_or_income_feed_your_family : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाइको परिवारमा ऋण छ ? यदि छ भने ऋण कहाँबाट लिनुभयो ?</label>
                    <p>{{ !empty($household)? $household->if_having_loan_name_the_place : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">उक्त ऋण कुन उद्धेश्यका लागि लिनु भएको हो ?</label>
                    <p>{{ !empty($household)? $household->purpose_for_taking_loan : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको कुनै सदस्य कुनै संघ/संस्थामा आवध हुनुहुन्छ?</label>
                    <p>{{ !empty($household)? $household->is_your_member_connected_with_any_institution : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">यदि संघ/संस्थामा आवध हुनुहुन्छ भने आवध संघ/संस्था</label>
                    <p>{{ !empty($household)? $household->if_connected_with_any_institution_name_it : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको घर छ/छैन ?</label>
                    <p>{{ !empty($household)? $household->do_you_have_home : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको घर कति वटा छ ?</label>
                    <p>{{ !empty($household)? $household->no_of_homes : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाई बसेको घरको स्वामित्व कस्तो प्रकारको हो ?</label>
                    <p>{{ !empty($household)? $household->possession_of_your_home : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाई बसोबास गर्ने घरको छानाको प्रकार</label>
                    <p>{{ !empty($household)? $household->roof_types_of_your_home : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाई बसेको घरको जग कस्तो प्रकारको छ ?</label>
                    <p>{{ !empty($household)? $household->types_of_your_house_jog : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाई बसेको घर भवन मापदण्ड अनुसार बनेको छ ?</label>
                    <p>{{ !empty($household)? $household->does_your_home_meets_criteria : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाई बसेको घर भूकम्प प्रतिरोधी छ ?</label>
                    <p>{{ !empty($household)? $household->is_your_home_earthquake_resistant : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाईको घर परिवारको जोखिम पारिवारिक योजना बनेको छ ?</label>
                    <p>{{ !empty($household)? $household->do_you_have_made_planning_for_family_risk : '' }}</p>
                </div>
                
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाइको घर प्राकृतिक प्रकोपको जोखिममा छ ?</label>
                    <p>{{ !empty($household)? $household->does_your_home_have_risk_of_natural_disaster : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">Latitude</label>
                    <p>{{ !empty($household)? $household->latitude : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">Longitude</label>
                    <p>{{ !empty($household)? $household->longitude : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घरको फोटो</label>
                    <img src="{{ asset('/household-images/'. $household->image) }}" style="height: 80px; margin-top: 20px; margin-left: 10px;">
                </div>

            </div>

            

         </div>

         


        </div>


        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class='row'>
                            <div class='col-md-12'>
                                <b><font size="4">परिवार सम्वन्धी विवरण </font></b>
                                <div style="display: inline; float: right;">
                                    <a class="btn btn-success btn-sm" style="margin-bottom: 10px"  title="Import/Export Leads" href="{{ route('household.member-details.create', (!empty($household)? $household->id : '')) }}">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>Create</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                
                        <table class="table table-hover table-no-border" id="leads-table">
                
                            <thead>
                                <tr class="bg-info">
                                    <th>क्र.सं.</th>
                                    <th>नाम थर</th>
                                    <th>लिङ्ग</th>
                                    <th>जन्म मिति</th>
                                    <th>धर्म</th>
                                    <th>जाति</th>
                                    <th>शैक्षिकस्तर</th>
                                    <th>वैवाहिक स्थिती</th>
                                    <th width="8%">सेटिङ</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($householdFamilyMembers as $familyMember)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $familyMember->name }}</td>
                                        <td>{{ $familyMember->gender }}</td>
                                        <td>{{ $familyMember->date_of_birth }}</td>
                                        <td>{{ $familyMember->religion }}</td>
                                        <td>{{ $familyMember->main_caste }}</td>
                                        <td>{{ $familyMember->education_level }}</td>
                                        <td>{{ $familyMember->marital_status }}</td>
                                        <td>
                                            <a href="{{ url('/admin/household/'. $household->id .'/member-details/'. $familyMember->id .'/edit') }}"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('/admin/household/'. $household->id .'/member-details/'. $familyMember->id) }}"><i class="fa fa-eye"></i></a>
                                            <a href="{{ url('/admin/household/member-details/destroy/'. $familyMember->id) }}"  title="{{ trans('general.button.delete') }}" onclick="return confirm('Do you want to delete this data ?');"><i class="fa fa-trash-o deletable"></i></a>
                                        </td>
                                    </tr>

                                @endforeach
                
                            </tbody>
                        </table>
                    </div>
                
                    <div class="box box-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class='row'>
                            <div class='col-md-12'>
                                <b><font size="4"> चौपाया तथा पशुपंक्षीको विवरण </font></b>
                                <div style="display: inline; float: right;">
                                    <a class="btn btn-success btn-sm" style="margin-bottom: 10px"  title="Import/Export Leads" href="{{ route('household.quadrupeds.create', (!empty($household)? $household->id : '')) }}">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>Create</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                
                        <table class="table table-hover table-no-border" id="leads-table">
                
                            <thead>
                                <tr class="bg-info">
                                    <th>क्र.सं.</th>
                                    <th>चौपाया तथा पशुपंक्षी</th>
                                    <th>स्थानीय जातको संख्या</th>
                                    <th width="8%">सेटिङ</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($quadrupeds as $quadruped)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $quadruped->name }}</td>
                                        <td>{{ $quadruped->local_caste_number }}</td>
                                        <td>
                                            <a href="{{ url('/admin/household/'. $household->id .'/quadrupeds/'. $quadruped->id .'/edit') }}"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('/admin/household/'. $household->id .'/quadrupeds/'. $quadruped->id) }}"><i class="fa fa-eye"></i></a>
                                            <a href="{{ url('/admin/household/quadrupeds/destroy/'. $quadruped->id) }}"  title="{{ trans('general.button.delete') }}" onclick="return confirm('Do you want to delete this data ?');"><i class="fa fa-trash-o deletable"></i></a>
                                        </td>
                                    </tr>

                                @endforeach
                
                            </tbody>
                        </table>
                    </div>
                
                    <div class="box box-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class='row'>
                            <div class='col-md-12'>
                                <b><font size="4"> बालीनालीको विवरण </font></b>
                                <div style="display: inline; float: right;">
                                    <a class="btn btn-success btn-sm" style="margin-bottom: 10px"  title="Import/Export Leads" href="{{ route('household.field.create', (!empty($household)? $household->id : '')) }}">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>Create</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                
                        <table class="table table-hover table-no-border" id="leads-table">
                
                            <thead>
                                <tr class="bg-info">
                                    <th>क्र.सं.</th>
                                    <th>बालीको नाम	</th>
                                    <th>वार्षिक उत्पादन (के.जि)	</th>
                                    <th>खेती गरिएको क्षेत्रफल</th>
                                    <th>क्षेत्रफलको इकाई (कठ्ठा/रोपनी)</th>
                                    <th width="8%">सेटिङ</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($fields as $field)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $field->name }}</td>
                                        <td>{{ $field->yearly_production_in_kg }}</td>
                                        <td>{{ $field->cultivated_area }}</td>
                                        <td>{{ $field->unit_of_area }}</td>
                                        <td>
                                            <a href="{{ url('/admin/household/'. $household->id .'/field/'. $field->id .'/edit') }}"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('/admin/household/'. $household->id .'/field/'. $field->id) }}"><i class="fa fa-eye"></i></a>
                                            <a href="{{ url('/admin/household/field/destroy/'. $field->id) }}"  title="{{ trans('general.button.delete') }}" onclick="return confirm('Do you want to delete this data ?');"><i class="fa fa-trash-o deletable"></i></a>
                                        </td>
                                    </tr>

                                @endforeach
                
                            </tbody>
                        </table>
                    </div>
                
                    <div class="box box-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class='row'>
                            <div class='col-md-12'>
                                <b><font size="4">घरको नक्शा </font></b>
                                <div style="display: inline; float: right;">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <?php 
                                    $mapCoordinate = !empty($household)? $household->latitude : '';
                                    $mapCoordinate = $mapCoordinate.''. (!empty($household)? (','.$household->longitude) : '');
                                ?>
                                <iframe src="https://maps.google.com/maps?q={{ $mapCoordinate }}&hl=es;z=14&output=embed"
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                            </div>
                        </div>
                
                        
                    </div>
                
                    <div class="box box-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
</div>


<script src="/bower_components/admin-lte/select2/js/select2.min.js"></script>
<script type="text/javascript">

  
$('#more-button').click(function(){
       $(".multipleDiv-attachment").after($('#morefiles #more-custom-tr').html());
});
$('.datepicker').datetimepicker({
                    //inline: true,
                    //format: 'YYYY-MM-DD',
                    format: 'YYYY-MM-DD', 
                    sideBySide: true,
                    allowInputToggle: true
                });
    $(document).on('click','.remove-this-attachment',function(){
      $(this).parent().parent().remove();
    });

    const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
$(document).on('change','.attachment',function(){
  var input = this;
  // console.log('done');
   var parent = $(this).parent().parent();
      if (input.files && input.files[0]) {
        var fileType = input.files[0]['type'];
        var reader = new FileReader();
        reader.onload = function (e) {
          if (validImageTypes.includes(fileType)) {
            parent.find('.uploads')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
            }
          else{
             parent.find('.uploads')
                .attr('src','')
                .width(0)
                .height(0);
          }
       
        };

        reader.readAsDataURL(input.files[0]);
    }
});

$('.searchable').select2()
</script>
@endsection

