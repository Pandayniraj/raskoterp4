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
			<form method="post" action="{{route('household.store')}}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="row">

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">सर्वेक्षणकर्ताको नाम थर</label>
						<input type="text" name="name" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">सर्वेक्षणकर्ताको मोबाईल नं.</label>
						<input type="text" name="mobile_no" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घरमुली/उत्तरदाताको वडा नं.</label>
						<input type="text" name="ward_no" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घरमुली/उत्तरदाता वस्ती/टोलको नाम</label>
						<input type="text" name="tole_name" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घर पुग्ने बाटो/सडकको प्रकार</label>
						<input type="text" name="road_type" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घर नम्बर छ/छैन ?</label>
						<input type="text" name="is_there_house_number" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घर नम्बर उल्लेख गर्नुहोला ?</label>
						<input type="text" name="house_number" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घर पुग्ने बाटो/सडकको स्तर</label>
						<input type="text" name="road_level" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">उत्तरदाताको नाम थर</label>
						<input type="text" name="uttardata_name" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">उत्तरदाताको सम्पर्क नं/उत्तरदातासंग सम्पर्क हुने नं ?</label>
						<input type="text" name="uttardata_contact_no" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">उत्तरदाताको घरमुली संग के नाता पर्ने हो ?</label>
						<input type="text" name="uttardatako_gharmuli_relation" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मुख्य जाति</label>
						<input type="text" name="main_caste" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">जाति</label>
						<input type="text" name="caste" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवार संख्या (घरमुली सहित)</label>
						<input type="text" name="family_number_with_gharmuli" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">पालिका भन्दा बाहिर बाट आएर भाडामा बसोबास गर्नेको संख्या</label>
						<input type="text" name="no_of_rent_stay" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाई अरु ठाउँबाट वसाईसराई गरी आउनु भएको हो ?</label>
						<input type="text" name="are_you_migrated" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">कहाँबाट आएको</label>
						<input type="text" name="came_from" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">कति वर्ष पहिले</label>
						<input type="text" name="came_from_year" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
						<label class="control-label">वसाईसरी आउनुको कारण</label>
						<input type="text" name="reason_behind_migration" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारको कुनै सदस्य बिरामी भएमा उपचारका लागि सवैभन्दा पहिला कहा जानुहुन्छ ?</label>
						<input type="text" name="member_treatment_place_at_first" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
						<label class="control-label">उपस्वास्थ्य चौकी (हेल्थसेन्टर) रहेको स्थान</label>
						<input type="text" name="sub_healthpost_place" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">उपस्वास्थ्य चौकी पुग्न लाग्ने समय (मिनेट)</label>
						<input type="text" name="time_for_going_to_subhealth_post_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अस्पताल रहेको स्थान</label>
						<input type="text" name="hospital_place" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अस्पताल पुग्न लाग्ने समय (मिनेट)</label>
						<input type="text" name="time_for_going_to_hospital_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">बालविकास केन्द्र (मिनेट)</label>
						<input type="text" name="child_development_centre_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">आ.वि. (मिनेट)</label>
						<input type="text" name="aa_vi_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मा. वि. (मिनेट)</label>
						<input type="text" name="ma_vi_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">उ.मा.वि (मिनेट)</label>
						<input type="text" name="u_ma_vi_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">क्याम्पस (मिनेट)</label>
						<input type="text" name="campus_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">नजिकको प्रहरी चौकी पुग्न लाग्ने समय (मिनेट)</label>
						<input type="text" name="time_for_going_to_nearest_police_station_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">नजिकको बैंक पुग्न लाग्ने समय (मिनेट)</label>
						<input type="text" name="time_for_going_to_nearest_bank_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">नजिकको बजार पुग्न लाग्ने समय (मिनेट)</label>
						<input type="text" name="time_for_going_to_nearest_bazar_in_minute" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">कुपोषण लागेका बालबालिका छ/छैन ?</label>
						<input type="text" name="is_there_malnutritioned_children" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">१८ वर्ष भन्दा कम उमेरका बालबालिका कामको लागि घर देखि बाहिर गएका छ/छैन ?</label>
						<input type="text" name="is_below_18_year_child_going_for_work" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">१८ वर्ष भन्दा कम उमेरका बालबालिका कामको लागि घर देखि बाहिर गएका छन् भने संख्या ?</label>
						<input type="text" name="no_of_if_below_18_years_child_going_for_work" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईका घरपरिवारका सदस्य बैदेशिक रोजगारमा जानुभएको छ/छैन ?</label>
						<input type="text" name="are_family_members_going_for_foreign_employment" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईका घरपरिवारका सदस्य बैदेशिक रोजगारमा कति जना जानुभएको छ ?</label>
						<input type="text" name="no_of_family_members_going_for_foreign_employment" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईका घरपरिवारका सदस्य बैदेशिक रोजगारमा कुन-कुन देशमा जानुभएको छ ?</label>
						<input type="text" name="countries_where_family_members_gone_for_foreign_employment" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको परिवारमा १ बर्षभत्र कुनै सदस्यको मृत्यु भएको छ ?</label>
						<input type="text" name="is_below_1_year_child_died" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मृत्यु भएका मानिसको संख्या</label>
						<input type="text" name="no_of_died_person" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारले प्रयोग गर्ने शौचालय कस्तो प्रकारको छ ?</label>
						<input type="text" name="type_of_toilet" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">हात धुने ठाउँ निश्चित छ/छैन ?</label>
						<input type="text" name="is_handwash_place_fixed" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">साबुन पानीको वयवस्था छ/छैन ?</label>
						<input type="text" name="is_there_arrangement_for_soap_water" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">करेसा बारी छ/छैन ?</label>
						<input type="text" name="is_there_karesa_bari" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारमा गर्भवती हुनुहुन्छ ?</label>
						<input type="text" name="is_there_pregnant_woman" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
						<label class="control-label">परिवारमा गर्भवतीको संख्या</label>
						<input type="text" name="no_of_pregnant_woman_in_family" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारको सदस्य गर्भवती हुदा ४ पटक गर्भवती जाँच गर्ने गर्नुभएको छ ?</label>
						<input type="text" name="do_pregnant_woman_check_for_4_times" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारको सदस्य गर्भवती भएदेखि सुत्केरी हुन्जेल सम्म पुर्णरुपमा आइरन चक्की खुवाउनु हुन्छ ?</label>
						<input type="text" name="does_pregnant_woman_eat_iron_tablets" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">स्वास्थ्य संस्थाबाट दिने सुबिधा सन्तुष्ट हुनुहुन्छ ?</label>
						<input type="text" name="is_there_satisfaction_for_health_institution_services" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">स्वास्थ्य संस्था जादाँ स्वास्थ्य सेवा उपलव्ध छ ?</label>
						<input type="text" name="is_health_service_available_while_going_to_health_institution" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">सुत्केरी गराउन हेल्थपोस्ट जानुहुन्छ ?</label>
						<input type="text" name="is_pregnant_woman_going_for_healthpost_for_delivery" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">२ वर्ष मुनिको बच्चा संख्या कति छ ?</label>
						<input type="text" name="no_of_below_2_years_child" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">बच्चालाई पूर्ण खोप लगाउने गर्नुभएको छ ?</label>
						<input type="text" name="did_child_get_full_vaccination" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">बच्चाको तौल प्रत्येक महिना लिने गर्नुभएको छ ?</label>
						<input type="text" name="is_there_monthly_record_for_child_weight" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">स्तनपान ६ महिना सम्म निरन्तर रुपमा गराउनु हुन्छ ?</label>
						<input type="text" name="does_mother_breastfeed_for_continuous_6_months" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">६ महिना पछि बच्चालाई थप खाना खुवाउनु हुन्छ ?</label>
						<input type="text" name="is_child_feeded_additional_food_after_6_months" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">बच्चाको दिशा ब्यबस्थापन चर्पीमा गर्नु हुन्छ ?</label>
						<input type="text" name="is_there_arrangement_for_child_stool_in_toilet" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको घरमा फोहोरमैला ब्यबस्थापनको लागि खाडल छ ?</label>
						<input type="text" name="is_there_arrangement_for_pit_for_dirty_things" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">६ महिना देखि ५ वर्ष सम्मको बच्चालाई भिटामिन ए / जुकाको औषधी खुवाएको छ ?</label>
						<input type="text" name="is_child_feeded_medicine_of_vitamin_a_or_worms_from_6_months" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
						<label class="control-label">समाजिक शुरक्षा भत्ता लिनु भएको छ ?</label>
						<input type="text" name="do_you_take_social_security_allowance" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवार नियोजनको सेवा लिनु भएको छ ?</label>
						<input type="text" name="do_you_take_family_planning_services" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">स्थायी परिवार नियोजन सेवा</label>
						<input type="text" name="permanent_family_planning_services" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अस्थायी परिवार नियोजन सेवा</label>
						<input type="text" name="temporary_family_planning_services" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
						<label class="control-label">तपाइको घरमा विद्यालयमा पढ्न जाने कति जना हुनुहुन्छ ?</label>
						<input type="text" name="no_of_member_going_for_school" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">एस.ई.ई. भन्दा कम योग्यता भएको (महिला) कति जना हुन्छ ?</label>
						<input type="text" name="no_of_female_having_below_s_e_e_certificate" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">एस.ई.ई. भन्दा कम योग्यता भएको (पुरुष) कति जना हुन्छ ?</label>
						<input type="text" name="no_of_male_having_below_s_e_e_certificate" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">एस.ई.ई. पास भएको (महिला) कति जना हुन्छ ?</label>
						<input type="text" name="no_of_female_passed_s_e_e_certificate" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">एस.ई.ई. पास भएको (पुरुष) कति जना हुन्छ ?</label>
						<input type="text" name="no_of_male_passed_s_e_e_certificate" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">स्नातक भन्दा माथि योग्यता भएको (महिला) कति जना हुन्छ ?</label>
						<input type="text" name="no_of_female_passed_above_graduate_level" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">स्नातक भन्दा माथि योग्यता भएको (पुरुष) कति जना हुन्छ ?</label>
						<input type="text" name="no_of_male_passed_above_graduate_level" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">३ वर्ष माथि र १५ वर्ष मुनि बिद्यालय छाडेको/नजाने वालवालिका (महिला) कति जना हुनुहुन्छ ?</label>
						<input type="text" name="no_of_female_leaving_school_from_aging_3_years_to_15_years" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">३ वर्ष माथि र १५ वर्ष मुनि बिद्यालय छाडेको/नजाने वालवालिका (पुरुष) कति जना हुनुहुन्छ ?</label>
						<input type="text" name="no_of_male_leaving_school_from_aging_3_years_to_15_years" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">विद्यालय नजाने कारण के हो ?</label>
						<input type="text" name="reason_behind_not_going_for_school" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">विद्यालय जानलाई के-के सुविधा हुनुपर्ने हो ?</label>
						<input type="text" name="services_required_for_going_school" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">बालबालिकालाई घरमा पढ्न समय दिनुभएको छ ?</label>
						<input type="text" name="do_you_give_time_for_child_study" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">सरदर कति समय घरमा पढ्नलाई छुट्याइएको छ (मिनेट) ?</label>
						<input type="text" name="number_of_minutes_for_allocated_for_child_study" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घरमा पढ्नलाई छुट्टै कोठा छ ?</label>
						<input type="text" name="is_there_room_for_study" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">कोठामा बत्तिको व्यवस्था छ ?</label>
						<input type="text" name="is_there_management_for_light" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाइको घरबाट सरकारी विद्यालयमा पढ्न जाने बालबालिकले शुल्क तिर्नु भएको छ ?</label>
						<input type="text" name="do_you_pay_for_school_fee_in_government_school" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको घर परिवारका सदस्यहरु विगत २ वर्ष देखि उपभोक्ता/निर्माण समितिमा रहनु भएको छ ?</label>
						<input type="text" name="did_your_family_members_have_engagement_in_consumer_committee" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">उपभोक्ता/निर्माण समितिमा तपाईको पद के हो ?</label>
						<input type="text" name="position_in_consumer_or_construction_committee" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">खानेपानीको मुख्य स्रोत के हो ?</label>
						<input type="text" name="source_of_drinking_water" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">खानेपानी ल्याउन (जाँदा आउँदा) लाग्ने समय</label>
						<input type="text" name="time_taken_for_taking_drinking_water_in_home" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">खाना पकाउन प्रयोग गर्ने मुख्य इन्धन कुन हो ?</label>
						<input type="text" name="main_fuel_for_cooking_food" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">यदि दाउरा भए दाउराको श्रोत कुन हो ?</label>
						<input type="text" name="source_of_firewood" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको घरमा कस्तो प्रकारको चुलो प्रयोग गर्नुहुन्छ ?</label>
						<input type="text" name="type_of_oven_used" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारले प्रयोग गर्ने बत्तीको मुख्य श्रोत कुन हो ?</label>
						<input type="text" name="main_source_of_light_in_family" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">कुन कुन सुविधाहरु परिवारले उपभोग गरेको छ ?</label>
						<input type="text" name="consumption_of_services_in_family" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारले कृषि कार्यका लागि जग्गा प्रयोग गरेको छ ?</label>
						<input type="text" name="does_family_used_land_for_agriculture" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">जग्गाको इकाई छान्नुहोस</label>
						<input type="text" name="choose_land_unit" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">आफ्नो परिवारको नाममा रहेको जग्गाको क्षेत्रफल</label>
						<input type="text" name="area_of_land_owned_by_family" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवार बाहेक अरुको नाममा रहेको जग्गाको क्षेत्रफल</label>
						<input type="text" name="area_of_land_not_owned_by_family" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अन्य स्वामित्वमा रहेको जग्गाको क्षेत्रफल</label>
						<input type="text" name="area_of_land_with_others_possession" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">अन्य स्वामित्व भए खुलाउनुहोस्</label>
						<input type="text" name="if_possessioned_mention_here" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारका कुनै सदस्यको वैंक तथा वित्तीय संस्थामा खाता छ/छैन ?</label>
						<input type="text" name="is_there_account_in_bank_or_financial_institution" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">परिवारको सरदर बार्षिक आम्दानी कति छ (रु मा उल्लेख गर्ने) ?</label>
						<input type="text" name="yearly_income_of_family" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">परिवारको सरदर बार्षिक खर्च कति छ (रु मा उल्लेख गर्ने) ?</label>
						<input type="text" name="yearly_expenses_of_family" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">तपाईले बाली उत्पादन वा बिक्री गर्नुभएको छ/छैन ?</label>
						<input type="text" name="have_you_done_production_or_sales_of_field" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको परिवारले कुनै चौपाया तथा पशुपंक्षी पाल्नुभएको छ ?</label>
						<input type="text" name="have_your_family_adopted_quadruped_or_animal_birds" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">डाले घाँसको कुन-कुन प्रजातिको विरुवाहरु लगाईएको छ ?</label>
						<input type="text" name="species_of_daale_grass_used_for_plantation" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">भुइँ घाँसको कुन-कुन प्रजातिको लगाईएको छ ?</label>
						<input type="text" name="species_of_ground_grass_used_for_plantation" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको परिवारमा माछा, मौरी र रेशमपालन गर्नुभएको छ ?</label>
						<input type="text" name="have_your_family_done_fish_bee_silk_farming" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">माछापालन पोखरीको संख्या</label>
						<input type="text" name="no_of_ponds_used_for_fisheries" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">पोखरीको क्षेत्रफल (हेक्टर)</label>
						<input type="text" name="area_of_ponds_in_hectar" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">वार्षिक उत्पादन (के.जी.)</label>
						<input type="text" name="yearly_production_in_kg" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मौरीको घार संख्या (आधुनिक)</label>
						<input type="text" name="no_of_beehives_in_khope_in_modern" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मौरीको घार संख्या (मुढे)</label>
						<input type="text" name="no_of_beehives_in_mude" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मौरीको घार संख्या (खोपे)</label>
						<input type="text" name="no_of_beehives_in_khope" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">वार्षिक मह उत्पादन (के.जी.)</label>
						<input type="text" name="yearly_production_of_maha_in_kg" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">रेशमखेती कोयो संख्या</label>
						<input type="text" name="no_of_silk_farming" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">उत्पादन (के.जी.)</label>
						<input type="text" name="production_in_kg" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">आफ्नो उत्पादन/आम्दानीले तपाईको परिवारलाई कति महिना खान पुग्छ ?</label>
						<input type="text" name="how_long_months_does_your_production_or_income_feed_your_family" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाइको परिवारमा ऋण छ ? यदि छ भने ऋण कहाँबाट लिनुभयो ?</label>
						<input type="text" name="if_having_loan_name_the_place" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">उक्त ऋण कुन उद्धेश्यका लागि लिनु भएको हो ?</label>
						<input type="text" name="purpose_for_taking_loan" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको कुनै सदस्य कुनै संघ/संस्थामा आवध हुनुहुन्छ?</label>
						<input type="text" name="is_your_member_connected_with_any_institution" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">यदि संघ/संस्थामा आवध हुनुहुन्छ भने आवध संघ/संस्था</label>
						<input type="text" name="if_connected_with_any_institution_name_it" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको घर छ/छैन ?</label>
						<input type="text" name="do_you_have_home" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको घर कति वटा छ ?</label>
						<input type="text" name="no_of_homes" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाई बसेको घरको स्वामित्व कस्तो प्रकारको हो ?</label>
						<input type="text" name="possession_of_your_home" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाई बसोबास गर्ने घरको छानाको प्रकार</label>
						<input type="text" name="roof_types_of_your_home" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाई बसेको घरको जग कस्तो प्रकारको छ ?</label>
						<input type="text" name="types_of_your_house_jog" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाई बसेको घर भवन मापदण्ड अनुसार बनेको छ ?</label>
						<input type="text" name="does_your_home_meets_criteria" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाई बसेको घर भूकम्प प्रतिरोधी छ ?</label>
						<input type="text" name="is_your_home_earthquake_resistant" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाईको घर परिवारको जोखिम पारिवारिक योजना बनेको छ ?</label>
						<input type="text" name="do_you_have_made_planning_for_family_risk" class="form-control">
					</div>
					
					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">तपाइको घर प्राकृतिक प्रकोपको जोखिममा छ ?</label>
						<input type="text" name="does_your_home_have_risk_of_natural_disaster" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top:20px;">
						<label class="control-label">Latitude</label>
						<input type="text" name="latitude" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">Longitude</label>
						<input type="text" name="longitude" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घरको फोटो</label>
						<input type="file" name="img" class="form-control">
					</div>

				</div>

				<div class="row">
					<div class="col-md-12 ">

						<div class="form-group pull-right">
							{!! Form::submit( trans('admin/ticket/general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
							<a href="/admin/household/" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
						</div>
					</div>
				</div>

			</form>

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

