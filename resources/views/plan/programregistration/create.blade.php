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
        <form method="post" action="{{route('plan.store')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">आर्थिक वर्ष</label>
                    <div class="input-group">
                        <select name="fiscal_year" class="form-control">
                            <option value="" disabled selected> Select Any One</option>
                            @foreach ($years as $year )
                            <option value="{{ $year->id}}">{{$year->fiscal_year}}</option>
                            @endforeach
                        </select>
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">स्रोत/अनुदानको किसिम</label>
                    <div class="input-group">
                        <select name="grant_resource_type" class="form-control">
                            <option value="" disabled selected>Select Any One</option>
                            @foreach ($grants as $grant )
                                <option value="{{ $grant->Id}}">{{ $grant->Name}}</option>
                            @endforeach
                        </select>
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-sort-amount-desc"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-4 col-sm-12 form-group">
                     <label class="control-label">खर्चको किसिम</label>
                    <div class="input-group">
                        <select name="expense_type" class="form-control">
                            <option value="" disabled selected> Select Any One</option>
                            @foreach ($expenditures as $expenditure )
                            <option value="{{ $expenditure->id}}">{{$expenditure->expenditure_head}}</option>
                            @endforeach
                        </select>
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-calendar"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4 col-sm-12 form-group">
                     <label class="control-label">योजना/कार्यक्रम</label>
                    <div class="input-group">
                        <select name="plan_progarm" class="form-control">
                            <option value="" disabled selected>Select Any One</option>
                            @foreach ($programs as $program)
                            <option value="{{$program->id}}">{{$program->name}}</option>
                            @endforeach
                        </select>
                      <div class="input-group-addon">
                            <a href="#"><i class="fa fa-sticky-note-o"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-8 col-sm-12 form-group">
                     <label class="control-label">कार्यक्रम/आयोजना/क्रियाकलापको नाम</label>
                    <div class="input-group">
                         <input type="text" name="program_activities_name" class="form-control  input-sm" placeholder="Receiver Organization..." >
                      <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="row">

                 <div class="col-md-4 col-sm-12 form-group">
                     <label class="control-label">फाइल नं./योजना दर्ता नं.</label>
                    <div class="input-group">
                        <input type="text" name="fileid" class="form-control input-sm">
                        {{-- {!! Form::select('fileid',$tickets,null,['class'=>'form-control searchable','placeholder'=>'Select Ticket Number']) !!} --}}
                      <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-secret"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">खर्च शिर्षक नं.</label>
                   <div class="input-group">
                     <input type="text" name="expense_head_num" class="form-control  input-sm">
                     <div class="input-group-addon">
                           <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                       </div>
                   </div>
               </div>
               <div class="col-md-4 col-sm-12 form-group">
                <label class="control-label">
                    क्षेत्र</label>
               <div class="input-group">
                <select name="areaid" class="form-control">
                    <option value="" disabled selected>Select Any One</option>
                    @foreach ($areas as $area )
                        <option value="{{ $area->Id}}">{{$area->Name}}</option>
                    @endforeach
                </select>
                 <div class="input-group-addon">
                       <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                   </div>
               </div>
           </div>

            </div>
            <div class="row">
                 <div class="col-md-4 col-sm-12 form-group">
                     <label class="control-label"> 
                        उप-क्षेत्र</label>
                    <div class="input-group">
                        <select name="subareaid" class="form-control">
                            <option value="" disabled selected>Select Any One</option>
                            @foreach ($subareas as $subarea )
                                <option value="{{$subarea->Id}}">{{$subarea->Name}}</option>                                
                            @endforeach
                        </select>
                      <div class="input-group-addon">
                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label"> 
                        मुख्य कार्यक्रम/क्रियाकलाप</label>
                   <div class="input-group">
                    <select name="mainprogramid" class="form-control">
                        <option value="" disabled selected>Select Any One</option>
                        @foreach ($activities as $activity )
                            <option value="{{$activity->Id}}">{{$activity->Name}}</option>
                        @endforeach
                    </select>
                     <div class="input-group-addon">
                           <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                       </div>
                   </div>
               </div>
               <div class="col-md-4 col-sm-12 form-group">
                <label class="control-label"> 
                    विनियोजन किसिम</label>
               <div class="input-group">
                <select name="appropriationid" class="form-control">
                    <option value="" disabled selected>Select Any One </option>
                    @foreach ($appropriations as $appropriation )
                        <option value="{{$appropriation->Id}}">{{$appropriation->Name}}</option>
                    @endforeach
                </select>
                 <div class="input-group-addon">
                       <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                   </div>
               </div>
           </div>

            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">               
                        कार्यान्वयन हुने स्थान
                    </label>
                   <div class="input-group">
                     <input type="text" name="implementation_place" class="form-control  input-sm">
                     <div class="input-group-addon">
                           <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                       </div>
                   </div>
               </div>
               <div class="col-md-4 col-sm-12 form-group">
                   <label class="control-label"> 
                    वडा नं.</label>
                  <div class="input-group">
                    <input type="text" name="ward" class="form-control  input-sm">
                    <div class="input-group-addon">
                          <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 col-sm-12 form-group">
               <label class="control-label"> 
                भौतिक लक्ष्य परिमाण</label>
              <div class="input-group">
                <input type="text" name="physical_target_qty" class="form-control  input-sm">
                <div class="input-group-addon">
                      <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                  </div>
              </div>
          </div>

           </div>
           <div class="row">
            <div class="col-md-4 col-sm-12 form-group">
                <label class="control-label">               
                    भौतिक एकाई
                </label>
               <div class="input-group">
                <select name="physical_unit" class="form-control">
                    <option value="" disabled selected>Select Any One</option>
                    @foreach ($units as $unit )
                        <option value="{{$unit->Id}}">{{$unit->Name}}
                    @endforeach
                </select>
                 {{-- <input type="text" name="physical_unit" class="form-control  input-sm"> --}}
                 <div class="input-group-addon">
                       <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                   </div>
               </div>
           </div>
           <div class="col-md-4 col-sm-12 form-group">
               <label class="control-label"> 
                उद्देश्य</label>
              <div class="input-group">
                <input type="text" name="purpose" class="form-control  input-sm">
                <div class="input-group-addon">
                      <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                  </div>
              </div>
          </div>
          <div class="col-md-4 col-sm-12 form-group">
           <label class="control-label"> 
            लक्षित समूह</label>
          <div class="input-group">
            <input type="text" name="target_grp" class="form-control  input-sm">
            <div class="input-group-addon">
                  <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
              </div>
          </div>
      </div>

       </div>
       <div class="row">
        <div class="col-md-4 col-sm-12 form-group">
            <label class="control-label">                               
                विनियोजन रकम
            </label>
           <div class="input-group">
             <input type="text" name="appropriation_amt" class="form-control  input-sm">
             <div class="input-group-addon">
                   <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
               </div>
           </div>
       </div>
       <div class="col-md-4 col-sm-12 form-group">
           <label class="control-label"> 
            पहिलो चौमासिक रकम</label>
          <div class="input-group">
            <input type="text" name="first_qtrly_amt" class="form-control  input-sm">
            <div class="input-group-addon">
                  <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
              </div>
          </div>
      </div>
      <div class="col-md-4 col-sm-12 form-group">
       <label class="control-label"> 
        पहिलो चौमासिक लक्ष्य</label>
      <div class="input-group">
        <input type="text" name="first_qtrly_target" class="form-control  input-sm">
        <div class="input-group-addon">
              <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
          </div>
      </div>
  </div>
  <div class="col-md-4 col-sm-12 form-group">
    <label class="control-label"> 
        दोस्रो चौमासिक रकम</label>
   <div class="input-group">
     <input type="text" name="second_qtrly_amt" class="form-control  input-sm">
     <div class="input-group-addon">
           <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
       </div>
   </div>
</div>
<div class="col-md-4 col-sm-12 form-group">
    <label class="control-label"> 
        दोस्रो चौमासिक लक्ष्य</label>
   <div class="input-group">
     <input type="text" name="second_qtrly_target" class="form-control  input-sm">
     <div class="input-group-addon">
           <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
       </div>
   </div>
</div>
<div class="col-md-4 col-sm-12 form-group">
    <label class="control-label"> 
        तेस्रो चौमासिक रकम</label>
   <div class="input-group">
     <input type="text" name="third_qtrly_amt" class="form-control  input-sm">
     <div class="input-group-addon">
           <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
       </div>
   </div>
</div>
<div class="col-md-4 col-sm-12 form-group">
    <label class="control-label"> 
        तेस्रो चौमासिक लक्ष्य</label>
   <div class="input-group">
     <input type="text" name="third_qtrly_target" class="form-control  input-sm">
     <div class="input-group-addon">
           <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
       </div>
   </div>
</div>

   </div>

         <div class="row">
                    <div class="col-md-12 ">

                        <div class="form-group pull-right">
                            {!! Form::submit( trans('admin/ticket/general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                            <a href="/admin/plan/" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
                        </div>
                        </div>
                 </div>

    </form>


         </div>
        </div>
    </div>
</div>


<div id="morefiles" style="display: none">
   <table class="table">
      <tbody id="more-custom-tr">
         <tr>
            <td class="moreattachment" style=""> 
               <input type="file" name="attachment[]" class="attachment" >
            </td>
            <td class="w-25" >
               <img src=""  style="max-height: 100px;float: right;margin-left: 30px" class='uploads'>
            </td>
            <td >
               <a href="javascript:void()" style="font-size: 20px; float: right" class="remove-this-attachment"> <i class="fa fa-close deletable"></i></a>
            </td>
         </tr>
      </tbody>
   </table>
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

