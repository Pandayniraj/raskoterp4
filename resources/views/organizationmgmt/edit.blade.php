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
        <form method="post" action="{{route('organizationmgmt.update', $findorganization->Id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">

                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कम्पनी/कर्मचारी/ब्यक्तिको नाम</label>
                    <div class="input-group">
                        <input type="text" name="name" value="{{ $findorganization->Name}}" class="form-control input-sm">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label"> प्रकार</label>
                    <div class="input-group">
                        <select name="type" class="form-control">
                            <option value="" disable seleceted>Select Any One</option>
                            <option value="कम्पनी" {{ ($findorganization->Type == "कम्पनी") ? "selected":"" }}>कम्पनी</option>
                            <option value="कर्मचारी" {{ ($findorganization->Type == "कर्मचारी") ? "selected":"" }}>कर्मचारी</option>
                            <option value="ब्यक्ति" {{ ($findorganization->Type == "ब्यक्ति") ? "selected":"" }}>ब्यक्ति</option>

                        </select>
                        <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">ठेगाना</label>
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="address" value="{{ $findorganization->Address}}">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-sort-amount-desc"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">
                        सम्पर्क नं.</label>
                   <div class="input-group">
                      <input type="text" name="contact" value="{{ $findorganization->ContactNumber}}" class="form-control input-sm">
                     <div class="input-group-addon">
                           <a href="#"><i class="fa  fa-calendar"></i></a>
                       </div>
                   </div>
               </div>
               <div class="col-md-4 col-sm-12 form-group">
                   <label class="control-label">स्थापना मिति</label>
                  <div class="input-group">
                     <input type="text" name="date" value="{{ $findorganization->EstablishedDate}}" class="form-control input-sm datepicker">
                    <div class="input-group-addon">
                          <a href="#"><i class="fa  fa-calendar"></i></a>
                      </div>
                  </div>
              </div>
                <div class="col-md-4 col-sm-12 form-group">
                     <label class="control-label">संचालक सदस्य संख्या:</label>
                    <div class="input-group">
                        <input type="number" class="form-control input-sm" value="{{ $findorganization->NoOfMember}}" name="members">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa fa-sticky-note-o"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-4 col-sm-12 form-group">
                     <label class="control-label">कर्मचारीको संख्या:</label>
                    <div class="input-group">
                         <input type="number" value="{{ $findorganization->NoOfPresentMember }}" name="staff" class="form-control  input-sm">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">
                        सक्रिय</label>
                   <div class="input-group">
                       <select name="status" class="form-control input sm">
                        <option value="" disabled selected>Select Any One</option>
                        <option value=1 {{ ($findorganization->IsEnable == 1) ? "selected":"" }}>छ</option>
                        <option value=0 {{ ($findorganization->IsEnable == 0) ? "selected":"" }}>छैन</option>
                       </select>
                       {{-- {!! Form::select('fileid',$tickets,null,['class'=>'form-control searchable','placeholder'=>'Select Ticket Number']) !!} --}}
                     <div class="input-group-addon">
                           <a href="#"><i class="fa fa-user-secret"></i></a>
                       </div>
                   </div>
               </div>
               <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">बैकको नाम, शाखा:</label>
                    <div class="input-group">
                        <input type="text" name="bankname" value="{{ $findorganization->NameOfBank}}" class="form-control  input-sm">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">बैक खाता नं.:</label>
                   <div class="input-group">
                        <input type="number" name="accountno" value="{{ $findorganization->BankAccountNo}}" class="form-control  input-sm">
                     <div class="input-group-addon">
                           <a href="#"><i class="fa fa-user-plus"></i></a>
                       </div>
                   </div>
               </div>
               <div class="col-md-4 col-sm-12 form-group">
                   <label class="control-label">कैफियत</label>
                  <div class="input-group">
                      <input type="text" name="remarks" value="{{ $findorganization->Remarks}}" class="form-control">
                      {{-- {!! Form::select('fileid',$tickets,null,['class'=>'form-control searchable','placeholder'=>'Select Ticket Number']) !!} --}}
                    <div class="input-group-addon">
                          <a href="#"><i class="fa fa-user-secret"></i></a>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 col-sm-12 form-group">
                   <label class="control-label">कम्पनी सँग सम्वन्धित फाईल</label>
                   <div class="input-group">
                       <input type="file" name="file" class="form-control">
                       <div class="input-group-addon">
                           <a href="#"><i class="fa fa-user-plus"></i></a>
                       </div>
                   </div>
               </div>
           </div>    
         <div class="row">
                    <div class="col-md-12 ">

                        <div class="form-group pull-right">
                            {!! Form::submit( trans('admin/ticket/general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                            <a href="/admin/organizationmgmt/" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
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

