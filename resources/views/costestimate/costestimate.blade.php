@extends('layouts.master')

@section('head_extra')
    <!-- Select2 css -->
    @include('partials._head_extra_select2_css')

@endsection

{{-- <link href="/bower_components/admin-lte/select2/css/select2.min.css" rel="stylesheet" /> --}}

@section('content')

<link href="/bower_components/admin-lte/select2/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
    <h1>
      {{ $page_title ?? 'Page Title' }}
        <small>{{$page_description ?? 'Page Description'}}</small>
    </h1>
   
    {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false) !!}
</section>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#lagatanuman">लगत अनुमान</a></li>
    <li><a data-toggle="tab" href="#operatingoffice">संचालन गर्ने संस्था/समिति</a></li>
    <li><a data-toggle="tab" href="#yojana">योजना सम्झौता</a></li>
  </ul>
  
  <div class="tab-content">
    <div class='row tab-pane fade in active' id="lagatanuman">
        <div class='col-md-12'>
            <div class="box">
                <div class="box-body">
                <form method="post" action="{{ route('costestimate.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">

                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">कार्यालयबाट अनुदान रकम</label>
                        <div class="input-group">
                        <input type="text" name="grantamt" value="{{$findplan->appropriationamt}}" class="form-control input-sm" required="" id="appropriationamt">
                        <div class="input-group-addon">
                                <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">
                            अन्य निकायबाट प्राप्त अनुदान</label>
                        <div class="input-group">
                        <input type="text" name="othergrant" class="form-control  input-sm" id="grantamt">
                        <div class="input-group-addon">
                                <a href="#"><i class="fa  fa-sort-amount-desc"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">
                            अन्य साझेदारी रकम</label>
                        <div class="input-group">
                        <input type="text" name="partnershipamt" id="partnershipamt" class="form-control  input-sm" placeholder="अन्य साझेदारी रकम...">
                        <div class="input-group-addon">
                                <a href="#"><i class="fa  fa-calendar"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">अन्य साझेदारी संस्था/निकाय</label>
                        <div class="input-group">
                        <input type="text" name="partnershiporg" class="form-control  input-sm" placeholder="अन्य साझेदारी संस्था/निकाय...">
                        <div class="input-group-addon">
                                <a href="#"><i class="fa fa-sticky-note-o"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">समितिबाट नगद साझेदारी रकम</label>
                        <div class="input-group">
                            <input type="number" name="cashshare" id="cashshareamt" class="form-control  input-sm" placeholder="साझेदारी रकम..." >
                        <div class="input-group-addon">
                                <a href="#"><i class="fa fa-user-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">कन्टिजेन्सी सहितको कुल रकम:</label>
                        <div class="input-group">
                        <input type="text" class="form-control input-sm" name="totalcontingency" id="totalamt" onclick="contigencyamt()">
                        <div class="input-group-addon">
                                <a href="#"><i class="fa fa-user-secret"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-sm-12 form-group">
                        <label class="control-label">कन्टिजेन्सी %</label>
                    <div class="input-group">
                        <input type="text" id="percentage" onchange="calc()" class="form-control input-sm" name="contingencyper">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-secret"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 form-group">
                    <label class="control-label">कन्टिजेन्सी रकम.</label>
                <div class="input-group">
                    <input type="text" name="contingencyamt" id="contamt" class="form-control input-sm" placeholder="कन्टिजेन्सी रकम...">
                    <div class="input-group-addon">
                        <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                    </div>
                </div>
            </div>
                <div class="col-md-2 col-sm-12 form-group">
                    <label class="control-label">अन्य कट्टी %</label>
                <div class="input-group">
                    <input type="text" name="otherdeducper" class="form-control input-sm" placeholder="अन्य कट्टी %">
                    <div class="input-group-addon">
                        <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                    </div>
                </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">अन्य कट्टी रकम</label>
                    <div class="input-group">
                        <input type="text" name="otherdeducamt" class="form-control  input-sm" placeholder="अन्य कट्टी रकम...">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">
                            कार्यालयले बेहोर्ने रकम</label>
                    <div class="input-group">
                        <input type="text" name="amtbyoffice" id="less" class="form-control  input-sm" placeholder="कार्यालयले बेहोर्ने रकम...">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label"> समितिबाट जनश्रमदान रकम</label>
                    <div class="input-group">
                        <input type="text" name="labordonation" id="wage" class="form-control input-sm" onchange="totalcalc()" placeholder="समितिबाट जनश्रमदान रकम...">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa fa-pencil-square-o"></i></a>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3 col-sm-12 form-group">
                        <label class="control-label">कुल लागत अनुमान रकम</label>
                    <div class="input-group">
                        <input type="text" name="totalcost" id="totalwage" class="form-control  input-sm" placeholder="कुल लागत अनुमान रकम...">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                        </div>
                    </div>
                    </div>
                    <input type="hidden" name="operationid" value="{{$findplan->Id}}">
                </div>    
                


            <div class="row">
                <div class="col-md-12 ">
                    <div class="more-tr">
                        <table class="table more table-hover table-no-border" style="width: 100%;">
                            <tbody>
                            <thead>
                                <tr>
                                    <th>
                                        उपलब्ध गराउने स्रोत/निकाय</th>
                                    <th>सामाग्रीको विवरण</th>
                                    <th>परिमाण</th>
                                    <th>एकाई</th>
                                <th> <button class="btn  bg-maroon btn-xs" id='more-button' type="button"><i class="fa fa-plus"></i>Add</button></th>
                                <th colspan="2"></th>
                                </tr>
                            </thead>
                        
                            <tr class="multipleDiv-attachment">
                            </tr>
                                <tr>
                                
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
                                <td class="w-25" >
                                    <img src=""  style="max-height: 100px;float: right;margin-left: 20px" asdfsdfds class='uploads'>
                                </td>
                                <td >
                                    <a href="javascript:void(0)" style="font-size: 20px; float: right" class="remove-this-attachment"> <i class="fa fa-close deletable"></i></a>
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
                 
                 <td class="w-25" >
                    <img src=""  style="max-height: 100px;float: right;margin-left: 30px" class='uploads'>
                 </td>
                 <td >
                    <a href="javascript:void(0)" style="font-size: 20px; float: right" class="remove-this-attachment"> <i class="fa fa-close deletable"></i></a>
                 </td>
              </tr>
           </tbody>
        </table>
    </div>
    
    <div class='row tab-pane fade' id="operatingoffice">
        <div class='col-md-12'>
           <div class="box">
              <div class="box-body">
             <form method="post" action="{{route('consumer.store')}}" enctype="multipart/form-data">
                 {{ csrf_field() }}
                 <div class="row">
                    <div class="col-md-6 col-sm-12 form-group">
                        <label class="control-label">प्रकार</label>
                        <div class="input-group">
                          <select name="Type" id="types" class="form-control input-sm" required="" onchange="dynamicform()">
                            <option value="" disabled selected>कुनै एक प्रकार चयन गर्नुहोस </option>
                            <option value="उपभोक्ता">उपभोक्ता</option>
                            <option value="कर्मचारी ">कर्मचारी </option>
                            <option value="कम्पनि">कम्पनि</option>
                            <option value="व्यक्ती">व्यक्ती</option>
                          </select>
                          <div class="input-group-addon">
                                <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                            </div>
                        </div>
                    </div>
                 </div>
                 <div class="box" id="typeone">
                 <div class="row" >
     
                     <div class="col-md-6 col-sm-12 form-group">
                         <label class="control-label">उपभोक्ता समितिको नाम</label>
                         <div class="input-group">
                           <input type="text" name="org_Name" class="form-control input-sm" required="" value="{{$findplan->name . ' उपभोक्ता समिती'}}">
                           <div class="input-group-addon">
                                 <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                             </div>
                         </div>
                     </div>
     
                      <div class="col-md-3 col-sm-12 form-group">
                         <label class="control-label">
                             ठेगाना</label>
                         <div class="input-group">
                           <input type="text" name="org_Address" class="form-control  input-sm" placeholder="ठेगाना">
                           <div class="input-group-addon">
                                 <a href="#"><i class="fa  fa-sort-amount-desc"></i></a>
                             </div>
                         </div>
                     </div>
     
                      <div class="col-md-3 col-sm-12 form-group">
                          <label class="control-label">
                             सम्पर्क नं.</label>
                         <div class="input-group">
                           <input type="text" name="org_ContactNumber" class="form-control  input-sm" placeholder="सम्पर्क नं. ...">
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
                           <input type="text" name="EstablishedDate" class="form-control  input-sm datepicker" placeholder="गठन भएको मिति: 2079-03-02" required="">
                           <div class="input-group-addon">
                                 <a href="#"><i class="fa fa-sticky-note-o"></i></a>
                             </div>
                         </div>
                     </div>
     
                      <div class="col-md-2 col-sm-12 form-group">
                          <label class="control-label">जम्मा सदस्य संख्या:</label>
                         <div class="input-group">
                              <input type="number" name="NoOfMember" class="form-control  input-sm" placeholder="जम्मा संख्या..." >
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
                      <input type="text" name="NoOfMonitoring" class="form-control  input-sm" placeholder="अनुगमन समिति संख्या...">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                        </div>
                    </div>
                </div>
                 <div class="col-md-2 col-sm-12 form-group">
                     <label class="control-label">सक्रिय:</label>
                 <div class="input-group">
                     <select name="IsEnable" class="form-control input-sm">
                         <option value="" disabled selected>कुनै एक चयन गर्नुहोस</option>
                         <option value=1>छ</option>
                         <option value=0>छैन</option>
     
                     </select>
                     <div class="input-group-addon">
                         <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                     </div>
                 </div>
                 </div>
                 </div>
     
                 <div class="row" >
                     <div class="col-md-3 col-sm-12 form-group">
                         <label class="control-label">बैकको नाम, शाखा:</label>
                     <div class="input-group">
                         <input type="text" name="NameOfBank" class="form-control  input-sm" placeholder="बैकको नाम, शाखा...">
                         <div class="input-group-addon">
                             <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                         </div>
                     </div>
                     </div>
                     <div class="col-md-3 col-sm-12 form-group">
                         <label class="control-label">
                             बैक खाता नं.</label>
                     <div class="input-group">
                         <input type="text" name="BankAccountNo" class="form-control  input-sm" placeholder="बैक खाता नं....">
                         <div class="input-group-addon">
                             <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                         </div>
                     </div>
                     </div>
                     <div class="col-md-3 col-sm-12 form-group">
                         <label class="control-label">कैफियत</label>
                     <div class="input-group">
                         <input type="text" name="Remarks" class="form-control  input-sm" placeholder="कैफियत...">
                         <div class="input-group-addon">
                             <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                         </div>
                     </div>
                     </div>
                     <div class="col-md-3 col-sm-12 form-group">
                         <label class="control-label">उपभोक्ता सँग सम्वन्धित फाईल</label>
                     <div class="input-group">
                         <input type="file" name="file" class="form-control  input-sm" placeholder="सम्वन्धित फाईल...">
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
                                   <th> <button class="btn  bg-maroon btn-xs" id='more-buttontwo' type="button"><i class="fa fa-plus"></i>Add</button></th>
                                   <th colspan="2"></th>
                                 </tr>
                               </thead>
                            
                                <tr class="multipleDiv-attachmenttwo">
                                </tr>
                                    <tr>
                                     <td class="moreattachment">
                                         <select name="DesignationId[]" class=" form-control input-sm attachment">
                                             <option value="" disabled selected>कुनै एक चयन गर्नुहोस</option>
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
                                             <option value="" disabled selected>कुनै एक चयन गर्नुहोस</option>
                                             <option value=1>छ</option>
                                             <option value=0>छैन</option> 
                                         </select>
                                     </td>
                                   <td class="w-25" >
                                      <img src=""  style="max-height: 100px;float: right;margin-left: 20px" asdfsdfds class='uploads'>
                                   </td>
                                   <td >
                                      <a href="javascript:void(0)" style="font-size: 20px; float: right" class="remove-this-attachment"> <i class="fa fa-close deletable"></i></a>
                                   </td>
                                </tr>
                             </tbody>
                          </table>
                       </div>
                   </div>
             </div>
                 </div>
                 <div class="box" id="typetwo">
             <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                    <label class="control-label">कम्पनी/कर्मचारी/ब्यक्तिको नाम</label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control input-sm">
                      <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                        </div>
                    </div>
                </div>
          

                 <div class="col-md-6 col-sm-12 form-group">
                    <label class="control-label">ठेगाना</label>
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="address">
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
                        <input type="text" name="contact" class="form-control input-sm">
                        <div class="input-group-addon">
                                <a href="#"><i class="fa  fa-calendar"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group">
                        <label class="control-label">स्थापना मिति</label>
                    <div class="input-group">
                        <input type="text" name="date" class="form-control input-sm datepicker">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa  fa-calendar"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">संचालक सदस्य संख्या:</label>
                    <div class="input-group">
                        <input type="number" class="form-control input-sm" name="members">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa fa-sticky-note-o"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कर्मचारीको संख्या:</label>
                    <div class="input-group">
                        <input type="number" name="staff" class="form-control  input-sm">
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
                        <option value="" disabled selected>कुनै एक चयन गर्नुहोस</option>
                        <option value=1>छ</option>
                        <option value=0>छैन</option>
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
                        <input type="text" name="bankname" class="form-control  input-sm">
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
                        <input type="number" name="accountno" class="form-control  input-sm">
                        <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कैफियत</label>
                    <div class="input-group">
                    <input type="text" name="remarks" class="form-control">
                    
                        <div class="input-group-addon">
                            <a href="#"><i class="fa fa-user-secret"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group">
                    <label class="control-label">कम्पनी सँग सम्वन्धित फाईल</label>
                        <div class="input-group">
                            <input type="text" name="file" class="form-control">
                            <div class="input-group-addon">
                                <a href="#"><i class="fa fa-user-plus"></i></a>
                            </div>
                        </div>
                </div>
            </div> 
                 </div>
              <div class="row">
                         <div class="col-md-12 ">
     
                             <div class="form-group pull-right">
                                 {!! Form::submit( trans('admin/ticket/general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                                 <a href="#" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
                             </div>
                             </div>
                      </div>
     
         </form>
     
     
              </div>
             </div>
         </div>
    </div>
    <div id="morefilestwo" style="display: none">
        <table class="table">
           <tbody id="more-customtwo-tr">
              <tr>
                 <td class="moreattachment">
                     <select name="DesignationId[]" class=" form-control input-sm attachment">
                         <option value="" disabled selected>कुनै एक चयन गर्नुहोस</option>
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
                         <option value="" disabled selected>कुनै एक चयन गर्नुहोस</option>
                         <option value=1>छ</option>
                         <option value=0>छैन</option> 
                     </select>
                 </td>
                 <td class="w-25" >
                    <img src=""  style="max-height: 100px;float: right;margin-left: 30px" class='uploads'>
                 </td>
                 <td >
                    <a href="javascript:void(0)" style="font-size: 20px; float: right" class="remove-this-attachmenttwo"> <i class="fa fa-close deletable"></i></a>
                 </td>
              </tr>
           </tbody>
        </table>
    </div>

    <div class='row tab-pane fade' id='yojana'>
        <div class="box">
            <div class="box-body">
                <form method="post" action="{{ route('planagreement.store')}}" enctype="multipart/form-data">
                 {{ csrf_field() }}
                    <div class="row">
                    <div class="col-md-6 col-sm-12 form-group">
                        <label class="control-label">
                        योजना संचालन गर्ने संस्था/समिति:</label>
                        <div class="input-group">
                           <select name="prjrunning_committee" class="form-control input-sm">
                            <option value="" selected disabled>कुनै एक चयन गर्नुहोस</option>
                            @foreach($consumercommittee as $committee)
                                <option value="{{ $committee->Id}}">{{ $committee->Name}}</option>
                            @endforeach
                           </select>
                            <div class="input-group-addon">
                                <a href="#"><i class="fa fa-user-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 form-group">
                        <label class="control-label">सम्झौता मिति</label>
                        <div class="input-group">
                        <input type="text" name="agreementdate" class="form-control" placeholder="2079-03-22">
                        
                            <div class="input-group-addon">
                                <a href="#"><i class="fa fa-user-secret"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 form-group">
                        <label class="control-label">शुरु हुने मिति</label>
                            <div class="input-group">
                                <input type="text" name="startdate" placeholder="2079-03-22" class="form-control">
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-user-plus"></i></a>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-2 col-sm-12 form-group">
                        <label class="control-label">
                            सम्पन्न हुने मिति</label>
                            <div class="input-group">
                                <input type="text" name="completiondate" placeholder="2079-03-22" class="form-control">
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-user-plus"></i></a>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12 form-group">
                        <label class="control-label">
                            घरपरिवर संख्या</label>
                        <div class="input-group">
                        <input type="text" name="householdnumber" class="form-control">
                        
                            <div class="input-group-addon">
                                <a href="#"><i class="fa fa-user-secret"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 form-group">
                        <label class="control-label">जनसंख्या</label>
                            <div class="input-group">
                                <input type="text" name="population" class="form-control">
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-user-plus"></i></a>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-4 col-sm-12 form-group">
                        <label class="control-label">
                            कैफियत</label>
                            <div class="input-group">
                                <input type="text" name="remarks" class="form-control">
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-user-plus"></i></a>
                                </div>
                            </div>
                    </div>
                    <input type="hidden" value="{{ $findplan->Id}}" name="operationid">
                </div>
                <div class="row">
                    <div class="col-md-12 ">

                        <div class="form-group pull-right">
                            {!! Form::submit( trans('admin/ticket/general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                            <a href="#" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
                        </div>
                        </div>
                 </div>
                </form>
            </div>    
        </div>   
    </div>
  </div>



<script src="/bower_components/admin-lte/select2/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
    function contigencyamt(){
    var appropriation= document.getElementById("appropriationamt").value;
    // alert(appropriation);
    var grant= document.getElementById("grantamt").value;
    var partnership= document.getElementById("partnershipamt").value;
    var cashshare= document.getElementById("cashshareamt").value;
    if((grant && grant!='') && (partnership && partnership!='') && (cashshare && cashshare!='')){
        var totalamts= parseInt(appropriation) + parseInt(grant) + parseInt(partnership) + parseInt(cashshare);
        document.getElementById("totalamt").value=totalamts;
    }
    else if((grant && grant!='') && partnership == '' && (cashshare && cashshare!='') ){
        var partialone= parseInt(appropriation) + parseInt(grant) + 0 + parseInt(cashshare);
        document.getElementById("totalamt").value=partialone;
    }
    else if(grant=='' && (partnership  && partnership != '') && (cashshare && cashshare!='') ){
        var partialtwo= parseInt(appropriation) + 0+ parseInt(partnership) + parseInt(cashshare);
        document.getElementById("totalamt").value=partialtwo;
    }
    else if(grant == "" && (partnership && partnership != '') && cashshare==""){
        var partialthree= parseInt(appropriation) + 0 + parseInt(partnership) + 0;
        document.getElementById("totalamt").value=partialthree;
    }
    else if ((grant && grant!='') && (partnership && partnership!='') && cashshare == ""){
        var partialfour = parseInt(appropriation) + parseInt(grant) + parseInt(partnership) + 0 ;
        document.getElementById("totalamt").value=partialfour;
    }
    else if(grant == 0 && (partnership && partnership!='') ){
        var partial = parseInt(appropriation) + parseInt(grant) + parseInt(partnership);
        document.getElementById("totalamt").value=partial;
    }

    else if(grant && grant!=''){
        var grantamt= parseInt(appropriation)+parseInt(grant)+0;
        document.getElementById("totalamt").value=grantamt;
    }
    else if(partnership && partnership!=''){
        var partnership= parseInt(appropriation)+parseInt(partnership)+0;
        document.getElementById("totalamt").value=partnership;

    }
    else if(cashshare && cashshare!=''){
        var partnership= parseInt(appropriation)+parseInt(cashshare)+0;
        document.getElementById("totalamt").value=partnership;

    }
    else{
        var finalamt= parseInt(appropriation);
        document.getElementById("totalamt").value=finalamt;
    }
    }

    function calc(){
   var amt= document.getElementById("totalamt").value;
   var per= document.getElementById("percentage").value;
   var peramt = amt * per/100;
   document.getElementById("contamt").value=peramt;
   var lessamt = amt-peramt;
   document.getElementById("less").value=lessamt;
    }
    function totalcalc(){
    var lessamt= document.getElementById('less').value;
   var wage = document.getElementById("wage").value;
   if(wage== 0 || wage == null){
        document.getElementById("totalwage").value=lessamt;
   }
   else{
    var add = parseInt(lessamt) + parseInt(wage);
    document.getElementById("totalwage").value=add;
   }
  }
  function dynamicform(){
    var x = document.getElementById("types").value;
    if(x == 'उपभोक्ता'){
        document.getElementById("typeone").style.display= "block";
        document.getElementById("typetwo").style.display= "none";
    }
    else{  
        document.getElementById("typeone").style.display= "none";
        document.getElementById("typetwo").style.display= "none";
    }
  }
</script>
<script type="text/javascript">
    $('#more-button').click(function(){
        $(".multipleDiv-attachment").after($('#morefiles #more-custom-tr').html());
    });
    $('#more-buttontwo').click(function(){
        $(".multipleDiv-attachmenttwo").after($('#morefilestwo #more-customtwo-tr').html());
    });

        $(document).on('click','.remove-this-attachment',function(){
        $(this).parent().parent().remove();
        });
        $(document).on('click','.remove-this-attachmenttwo',function(){
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

</script>
@endsection

