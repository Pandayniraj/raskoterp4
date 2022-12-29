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
                <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label">बालीको नाम	</label>
                    <p>{{ !empty($fields)? $fields->name : '' }}</p>
                </div>

                <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label">वार्षिक उत्पादन (के.जि)</label>
                    <p>{{ !empty($fields)? $fields->yearly_production_in_kg : '' }}</p>
                </div>

                <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label">खेती गरिएको क्षेत्रफल</label>
                    <p>{{ !empty($fields)? $fields->cultivated_area : '' }}</p>
                </div>

                <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label">क्षेत्रफलको इकाई (कठ्ठा/रोपनी)	</label>
                    <p>{{ !empty($fields)? $fields->unit_of_area : '' }}</p>
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

