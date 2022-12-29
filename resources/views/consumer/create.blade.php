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
        <form method="post" action="{{route('consumer.store')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">

                <div class="col-md-6 col-sm-12 form-group">
                    <label class="control-label">उपभोक्ता समितिको नाम</label>
                    <div class="input-group">
                      <input type="text" name="org_Name" class="form-control input-sm" required="">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label">
                        ठेगाना</label>
                    <div class="input-group">
                      <input type="text" name="org_Address" class="form-control  input-sm">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-sort-amount-desc"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-3 col-sm-12 form-group">
                     <label class="control-label">
                        सम्पर्क नं.</label>
                    <div class="input-group">
                      <input type="text" name="org_ContactNumber" class="form-control  input-sm" placeholder="Letter Date...">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-calendar"></i></a>
                        </div>
                    </div>
                </div>

            </div>



            <div class="row">

                <div class="col-md-2 col-sm-12 form-group">
                     <label class="control-label">गठन भएको मिति</label>
                    <div class="input-group">
                      <input type="text" name="EstablishedDate" class="form-control  input-sm datepicker" placeholder="Subject..." required="">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa fa-sticky-note-o"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-2 col-sm-12 form-group">
                     <label class="control-label">जम्मा सदस्य संख्या:</label>
                    <div class="input-group">
                         <input type="number" name="NoOfMember" class="form-control  input-sm" placeholder="Receiver Organization..." >
                      <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-plus"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-2 col-sm-12 form-group">
                     <label class="control-label">गठन गर्दा उपस्थित संख्या:</label>
                    <div class="input-group">
                       <input type="number" class="form-control input-sm" name="NoOfPresentMember">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-secret"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2 col-sm-12 form-group">
                    <label class="control-label">महिला सदस्य संख्या:</label>
                   <div class="input-group">
                      <input type="number"  class="form-control input-sm" name="NoOfFemale">
                     <div class="input-group-addon">
                           <a href="#"><i class="fa fa-user-secret"></i></a>
                       </div>
                   </div>
               </div>
               <div class="col-md-2 col-sm-12 form-group">
                <label class="control-label">अनुगमन समिति संख्या:</label>
               <div class="input-group">
                 <input type="text" name="NoOfMonitoring" class="form-control  input-sm" placeholder="Remarks...">
                 <div class="input-group-addon">
                       <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                   </div>
               </div>
           </div>
            <div class="col-md-2 col-sm-12 form-group">
                <label class="control-label">सक्रिय:</label>
            <div class="input-group">
                <select name="IsEnable" class="form-control input-sm">
                    <option value="" disabled selected>Select Any One</option>
                    <option value=1>छ</option>
                    <option value=0>छैन</option>

                </select>
                <div class="input-group-addon">
                    <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                </div>
            </div>
            </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label">बैकको नाम, शाखा:</label>
                <div class="input-group">
                    <input type="text" name="NameOfBank" class="form-control  input-sm" placeholder="Remarks...">
                    <div class="input-group-addon">
                        <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                    </div>
                </div>
                </div>
                <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label">
                        बैक खाता नं.</label>
                <div class="input-group">
                    <input type="text" name="BankAccountNo" class="form-control  input-sm" placeholder="Remarks...">
                    <div class="input-group-addon">
                        <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                    </div>
                </div>
                </div>
                <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label"> कैफियत</label>
                <div class="input-group">
                    <input type="text" name="Remarks" class="form-control  input-sm" placeholder="Remarks...">
                    <div class="input-group-addon">
                        <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                    </div>
                </div>
                </div>
                <div class="col-md-3 col-sm-12 form-group">
                    <label class="control-label">उपभोक्ता सँग सम्वन्धित फाईल</label>
                <div class="input-group">
                    <input type="file" name="file" class="form-control  input-sm" placeholder="Remarks...">
                    <div class="input-group-addon">
                        <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                    </div>
                </div>
                </div>
                
            </div>    
            


        <div class="row">
            <div class="col-md-12 ">
                  <div class="more-tr">
                     <table class="table more table-hover table-no-border" style="width: 100%;">
                        <tbody>
                          <thead>
                            <tr>
                                <th>पद</th>
                                <th>नाम थर</th>
                                <th>बुवा/पतिको नाम थर</th>
                                <th>बाजे/ससुराको नाम थर</th>
                                <th>नागरिकता नं.</th>
                                <th>ठेगाना</th>
                                <th>सम्पर्क नं.</th>
                                <th>हस्ताक्षर गर्ने</th>
                              <th> <button class="btn  bg-maroon btn-xs" id='more-button' type="button"><i class="fa fa-plus"></i>Add</button></th>
                              <th colspan="2"></th>
                            </tr>
                          </thead>
                       
                           <tr class="multipleDiv-attachment">
                           </tr>
                               <tr>
                                <td class="moreattachment">
                                    <select name="DesignationId[]" class=" form-control input-sm attachment">
                                        <option value="" disabled selected>Select Any One</option>
                                        @foreach ($designations as $designation )
                                            <option value="{{ $designation->Id}}">{{ $designation->Name}}</option>
                                        @endforeach
                                </td>
                                <td class="moreattachment">
                                    <input type="text" name="Name[]" class="form-control input-sm attachment">
                                </td>
                                <td class="moreattachment">
                                    <input type="text" name="FatherName[]" class="form-control input-sm attachment">
                                </td>
                                <td class="moreattachment">
                                    <input type="text" name="GrandFatherName[]" class="form-control input-sm attachment">
                                </td>
                                <td class="moreattachment">
                                    <input type="text" name="AccountNumber[]" class="form-control input-sm attachment">
                                </td>
                                <td class="moreattachment">
                                    <input type="text" name="Address[]" class="form-control input-sm attachment">
                                </td>
                                <td class="moreattachment">
                                    <input type="text" name="ContactNumber[]" class="form-control input-sm attachment">
                                </td>
                                <td class="moreattachment">
                                    <select name="IsSigner[]" class="form-control input-sm attachment">
                                        <option value="" disabled selected>Select Any One</option>
                                        <option value=1>छ</option>
                                        <option value=0>छैन</option> 
                                    </select>
                                </td>
                              <td class="w-25" >
                                 <img src=""  style="max-height: 100px;float: right;margin-left: 20px" asdfsdfds class='uploads'>
                              </td>
                              <td >
                                 <a href="javascript:void()" style="font-size: 20px; float: right" class="remove-this-attachment"> <i class="fa fa-close deletable"></i></a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
              </div>
        </div>
         <div class="row">
                    <div class="col-md-12 ">

                        <div class="form-group pull-right">
                            {!! Form::submit( trans('admin/ticket/general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                            <a href="/admin/consumer/" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
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
            <td class="moreattachment">
                <select name="DesignationId[]" class=" form-control input-sm attachment">
                    <option value="" disabled selected>Select Any One</option>
                    @foreach ($designations as $designation )
                        <option value="{{ $designation->Id}}">{{ $designation->Name}}</option>
                    @endforeach
            </td>
            <td class="moreattachment">
                <input type="text" name="Name[]" class="form-control input-sm attachment">
            </td>
            <td class="moreattachment">
                <input type="text" name="FatherName[]" class="form-control input-sm attachment">
            </td>
            <td class="moreattachment">
                <input type="text" name="GrandFatherName[]" class="form-control input-sm attachment">
            </td>
            <td class="moreattachment">
                <input type="text" name="AccountNumber[]" class="form-control input-sm attachment">
            </td>
            <td class="moreattachment">
                <input type="text" name="Address[]" class="form-control input-sm attachment">
            </td>
            <td class="moreattachment">
                <input type="text" name="ContactNumber[]" class="form-control input-sm attachment">
            </td>
            <td class="moreattachment">
                <select name="IsSigner[]" class="form-control input-sm attachment">
                    <option value="" disabled selected>Select Any One</option>
                    <option value=1>छ</option>
                    <option value=0>छैन</option> 
                </select>
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

