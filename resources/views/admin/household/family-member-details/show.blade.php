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
                
                <input type="hidden" name="household_id" value="{{ $householdId }}">
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">नाम थर</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->name : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">घरमुली सँगको नाता</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->relation_with_gharmuli : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">लिङ्ग</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->gender : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">जन्म मिति (YYYY-MM-DD) B.S.</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->date_of_birth : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">ना. नं./रा.प.प. नं./जन्म दर्ता प्र.प.</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->citizenship_no : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">सम्पर्क नं.</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->contact_no : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">धर्म</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->religion : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मातृभाषा</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->mothertongue : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मुख्य जाति</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->main_caste : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">जाति</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->caste : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">शैक्षिकस्तर</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->education_level : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">तपाई अध्यनरत हुनु हुन्छ ?</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->are_you_studying : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">विद्यालयको किसिम</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->type_of_school : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अध्यनरत विद्यालयको नाम</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->school_name : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">विद्यालयको ठेगाना</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->school_address : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अध्यनरत कक्षा</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->class : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">संकाय</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->faculty : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">बसोबासको अवस्था</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->shelter_condition : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
                    <label class="control-label">बसोबास गरेको स्थान/ठाउँ</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->shelter_address : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">गएको अवधि (वर्षमा)</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->last_period_in_years : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
                    <label class="control-label">पेशा</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->occupation : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">व्यवसायको नाम</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->business_name : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">दर्ता छ/छैन</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->is_there_registration : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">दर्ता नं.</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->registration_no : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">प्यान नं./भ्याट नं.</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->pan_or_vat_no : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">व्यवसायको प्रकार</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->business_type : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">वार्षिक कारोवार</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->yearly_transactions : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">व्यवसाय भएको स्थान</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->place_of_business : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कुल लगानी</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->total_investment : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अपाङ्गताको स्थिति</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->disability_status : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अपाङ्ग परिचय पत्रको प्रकार</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->type_of_disability_identity_card : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">स्वास्थ्य अवस्था</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->health_condition : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">विगत ३ बर्षमा के-कस्ता व्यवसायिक सीप तालिम प्राप्त गर्नुभएको छ ?</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->vocational_skills_training_in_last_3_years : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मतदाता परिचय पत्र छ/छैन ?</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->is_there_voters_identity_card : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">मतदाता परिचय पत्र नभएको कारण</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->reason_behind_not_making_voters_identity_card : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">अपाङ्गता बाहेकको अन्य सरकारी परिचयपत्र लिनुभएको छ ?</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->do_you_take_other_governmental_identity_card_besides_disability : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">वैवाहिक स्थिती</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->marital_status : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">विवाह गरेको उमेर</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->age_of_marriage : '' }}</p>
                </div>

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">काम गर्न चाहेको क्षेत्र / इच्छया</label>
                    <p>{{ !empty($householdFamilyMembersDetail)? $householdFamilyMembersDetail->desired_area_to_work : '' }}</p>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 ">

                    <div class="form-group pull-right">
                        <a href="{{ url('/admin/household/'. $householdId) }}" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
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

