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
			<form method="post" action="{{route('household.quadrupeds.update', $edit->id)}}">
				{{ csrf_field() }}
				{{ method_field('patch') }}
				<div class="row">
                    
                    <input type="hidden" name="household_id" value="{{ $householdId }}">

					<div class="col-md-6 col-sm-12 form-group">
						<label class="control-label">चौपाया तथा पशुपंक्षी</label>
						<input type="text" name="name" class="form-control" value="{{ !empty($edit)? $edit->name : '' }}">
					</div>

					<div class="col-md-6 col-sm-12 form-group">
						<label class="control-label">स्थानीय जातको संख्या</label>
						<input type="text" name="local_caste_number" class="form-control" value="{{ !empty($edit)? $edit->local_caste_number : '' }}">
					</div>

				</div>

				<div class="row">
					<div class="col-md-12 ">

						<div class="form-group pull-right">
							{!! Form::submit( trans('admin/ticket/general.button.update'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
							<a href="{{ url('household.show', $householdId) }}" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
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

