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
			<form method="post" action="{{route('household.member-details.store')}}">
				{{ csrf_field() }}
				<div class="row">
                    
                    <input type="hidden" name="household_id" value="{{ $householdId }}">
					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">नाम थर</label>
						<input type="text" name="name" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">घरमुली सँगको नाता</label>
						<input type="text" name="relation_with_gharmuli" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">लिङ्ग</label>
						<input type="text" name="gender" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">जन्म मिति (YYYY-MM-DD) B.S.</label>
						<input type="text" name="date_of_birth" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">ना. नं./रा.प.प. नं./जन्म दर्ता प्र.प.</label>
						<input type="text" name="citizenship_no" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">सम्पर्क नं.</label>
						<input type="text" name="contact_no" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">धर्म</label>
						<input type="text" name="religion" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मातृभाषा</label>
						<input type="text" name="mothertongue" class="form-control">
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
						<label class="control-label">शैक्षिकस्तर</label>
						<input type="text" name="education_level" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">तपाई अध्यनरत हुनु हुन्छ ?</label>
						<input type="text" name="are_you_studying" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">विद्यालयको किसिम</label>
						<input type="text" name="type_of_school" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अध्यनरत विद्यालयको नाम</label>
						<input type="text" name="school_name" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">विद्यालयको ठेगाना</label>
						<input type="text" name="school_address" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अध्यनरत कक्षा</label>
						<input type="text" name="class" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">संकाय</label>
						<input type="text" name="faculty" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">बसोबासको अवस्था</label>
						<input type="text" name="shelter_condition" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
						<label class="control-label">बसोबास गरेको स्थान/ठाउँ</label>
						<input type="text" name="shelter_address" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">गएको अवधि (वर्षमा)</label>
						<input type="text" name="last_period_in_years" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group" style="margin-top: 20px;">
						<label class="control-label">पेशा</label>
						<input type="text" name="occupation" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">व्यवसायको नाम</label>
						<input type="text" name="business_name" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">दर्ता छ/छैन</label>
						<input type="text" name="is_there_registration" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">दर्ता नं.</label>
						<input type="text" name="registration_no" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">प्यान नं./भ्याट नं.</label>
						<input type="text" name="pan_or_vat_no" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">व्यवसायको प्रकार</label>
						<input type="text" name="business_type" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">वार्षिक कारोवार</label>
						<input type="text" name="yearly_transactions" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">व्यवसाय भएको स्थान</label>
						<input type="text" name="place_of_business" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">कुल लगानी</label>
						<input type="text" name="total_investment" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अपाङ्गताको स्थिति</label>
						<input type="text" name="disability_status" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अपाङ्ग परिचय पत्रको प्रकार</label>
						<input type="text" name="type_of_disability_identity_card" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">स्वास्थ्य अवस्था</label>
						<input type="text" name="health_condition" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">विगत ३ बर्षमा के-कस्ता व्यवसायिक सीप तालिम प्राप्त गर्नुभएको छ ?</label>
						<input type="text" name="vocational_skills_training_in_last_3_years" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मतदाता परिचय पत्र छ/छैन ?</label>
						<input type="text" name="is_there_voters_identity_card" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">मतदाता परिचय पत्र नभएको कारण</label>
						<input type="text" name="reason_behind_not_making_voters_identity_card" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">अपाङ्गता बाहेकको अन्य सरकारी परिचयपत्र लिनुभएको छ ?</label>
						<input type="text" name="do_you_take_other_governmental_identity_card_besides_disability" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">वैवाहिक स्थिती</label>
						<input type="text" name="marital_status" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">विवाह गरेको उमेर</label>
						<input type="text" name="age_of_marriage" class="form-control">
					</div>

					<div class="col-md-4 col-sm-12 form-group">
						<label class="control-label">काम गर्न चाहेको क्षेत्र / इच्छया</label>
						<input type="text" name="desired_area_to_work" class="form-control">
					</div>

				</div>

				<div class="row">
					<div class="col-md-12 ">

						<div class="form-group pull-right">
							{!! Form::submit( trans('admin/ticket/general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
							<a href="/admin/household/member-details" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
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

