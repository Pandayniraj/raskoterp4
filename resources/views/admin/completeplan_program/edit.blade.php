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
            <small>{{ $page_description ?? 'Page Description' }}</small>
        </h1>

        {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false) !!}
    </section>
    <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#plan">योजना विवरण</a></li>
        <li class="active"><a data-toggle="tab" href="#lagatanuman">लगत अनुमान</a></li>
        <li><a data-toggle="tab" href="#operatingoffice">संचालन गर्ने संस्था/समिति</a></li>
        <li><a data-toggle="tab" href="#yojana">योजना सम्झौता</a></li>
        <li><a data-toggle="tab" href="#yojanaphoto">योजनाको फोटो/फाईल</a></li>
        <li><a data-toggle="tab" href="#aarthic">आर्थिक कारोबार</a></li>
        <li><a data-toggle="tab" href=" #extensiondetails"> म्याद थपको विवरण</a></li>
    </ul>
    <div class="tab-content">
        <div class='row tab-pane fade' id="plan">
            <div class='col-md-12'>
                <div class="box">
                    <div class="box-body">
                        <form method="post" action="#"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">आर्थिक वर्ष</label>
                                    <div class="input-group">
                                        <select name="fiscal_year" class="form-control">
                                            <option value="" disabled>Select Any One</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year->id }}"
                                                    {{ $findplan->fiscalyearid == $year->id ? 'selected' : '' }}>
                                                    {{ $year->fiscal_year }}</option>
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
                                            <option value="" disabled>Select Any One</option>
                                            @foreach ($grants as $grant)
                                                <option value="{{ $grant->Id }}"
                                                    {{ $findplan->granttypeid == $grant->id ? 'selected' : '' }}>
                                                    {{ $grant->Name }}</option>
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
                                            <option value="" disabled>Select Any One</option>
                                            @foreach ($expenditures as $expenditure)
                                                <option value="{{ $expenditure->id }}"
                                                    {{ $findplan->expensetypeid == $expenditure->id ? 'selected' : '' }}>
                                                    {{ $expenditure->expenditure_head }}</option>
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
                                            <option value="" disabled>Select Any One</option>
                                            @foreach ($programs as $program)
                                                <option value="{{ $program->id }}"
                                                    {{ $findplan->planid == $program->id ? 'selected' : '' }}>
                                                    {{ $program->name }}</option>
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
                                        <input type="text" name="program_activities_name" value="{{ $findplan->name }}"
                                            class="form-control  input-sm">
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
                                        <input type="text" name="fileid" value="{{ $findplan->filenum }}"
                                            class="form-control input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa fa-user-secret"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">खर्च शिर्षक नं.</label>
                                    <div class="input-group">
                                        <input type="text" name="expense_head_num"
                                            value="{{ $findplan->expenditurehead }}" class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        क्षेत्र.</label>
                                    <div class="input-group">
                                        <select name="areaid" class="form-control">
                                            <option value="" disabled>Select Any One</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->Id }}"
                                                    {{ $findplan->subjectareaid == $area->Id ? 'selected' : '' }}>
                                                    {{ $area->Name }}</option>
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
                                            <option value="" disabled>Select Any One</option>
                                            @foreach ($subareas as $subarea)
                                                <option value="{{ $subarea->Id }}"
                                                    {{ $findplan->subjecttypeid == $subarea->Id ? 'selected' : '' }}>
                                                    {{ $subarea->Name }}</option>
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
                                            <option value="" disabled>Select Any One</option>
                                            @foreach ($activities as $activity)
                                                <option value="{{ $activity->Id }}"
                                                    {{ $findplan->subjectsubtypeid == $activity->Id ? 'selected' : '' }}>
                                                    {{ $activity->Name }}</option>
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
                                            <option value="" disabled>Select Any One</option>
                                            @foreach ($appropriations as $appropriation)
                                                <option value="{{ $appropriation->Id }}"
                                                    {{ $findplan->deploymenttypeid == $appropriation->Id ? 'selected' : '' }}>
                                                    {{ $appropriation->Name }}</option>
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
                                        <input type="text" name="implementation_place"
                                            value="{{ $findplan->implementationplace }}"
                                            class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        वडा नं.</label>
                                    <div class="input-group">
                                        <input type="text" name="ward" value="{{ $findplan->ward }}"
                                            class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        भौतिक लक्ष्य परिमाण</label>
                                    <div class="input-group">
                                        <input type="text" name="physical_target_qty"
                                            value="{{ $findplan->targetqty }}" class="form-control  input-sm">
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
                                            <option value=""disabled>Select Any One</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->Id }}"
                                                    {{ $findplan->unitid == $unit->Id ? 'selected' : '' }}>
                                                    {{ $unit->Name }}
                                            @endforeach
                                        </select>
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        उद्देश्य</label>
                                    <div class="input-group">
                                        <input type="text" name="purpose" value="{{ $findplan->purpose }}"
                                            class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        लक्षित समूह</label>
                                    <div class="input-group">
                                        <input type="text" name="target_grp" value="{{ $findplan->targetgrp }}"
                                            class="form-control  input-sm">
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
                                        <input type="text" name="appropriation amt"
                                            value="{{ $findplan->appropriationamt }}" class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        पहिलो चौमासिक रकम</label>
                                    <div class="input-group">
                                        <input type="text" name="first_qtrly_amt"
                                            value="{{ $findplan->firstquarterlyamt }}" class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        पहिलो चौमासिक लक्ष्य
                                    </label>
                                    <div class="input-group">
                                        <input type="text" name="first_qtrly_target"
                                            value="{{ $findplan->firstquarterlytarget }}"
                                            class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                        `
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        दोस्रो चौमासिक रकम</label>
                                    <div class="input-group">
                                        <input type="text" name="second_qtrly_amt"
                                            value="{{ $findplan->secondquarterlyamt }}" class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        दोस्रो चौमासिक लक्ष्य</label>
                                    <div class="input-group">
                                        <input type="text" name="second_qtrly_target"
                                            value="{{ $findplan->secondquarterlytarget }}"
                                            class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        तेस्रो चौमासिक रकम</label>
                                    <div class="input-group">
                                        <input type="text" name="third_qtrly_amt"
                                            value="{{ $findplan->thirdquarterlyamt }}" class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">
                                        तेस्रो चौमासिक लक्ष्य</label>
                                    <div class="input-group">
                                        <input type="text" name="third_qtrly_target"
                                            value="{{ $findplan->thirdquarterlytarget }}" class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">

                                    <div class="form-group pull-right">
                                        <!-- {!! Form::submit('Edit', ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit']) !!}
                                        <a href="/admin/plan/" title="{{ trans('general.button.cancel') }}"
                                            class='btn btn-default'>{{ trans('general.button.cancel') }}</a> -->
                                    </div>
                                </div>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
        <div class='row tab-pane fade in active' id="lagatanuman">
            <div class='col-md-12'>
                <div class="box">
                    <div class="box-body">
                        <form method="post" action="#"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="control-label">कार्यालयबाट अनुदान रकम</label>
                                    <div class="input-group">
                                        <input type="text" name="grantamt" value="{{ $findcost[0]->grantamt }}"
                                            class="form-control input-sm" required="">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa  fa-sort-numeric-asc"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12 form-group">
                                    <label class="control-label">
                                        अन्य निकायबाट प्राप्त अनुदान</label>
                                    <div class="input-group">
                                        <input type="text" name="othergrant" value="{{ $findcost[0]->othergrant }}"
                                            class="form-control  input-sm">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa  fa-sort-amount-desc"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12 form-group">
                                    <label class="control-label">
                                        अन्य साझेदारी रकम</label>
                                    <div class="input-group">
                                        <input type="text" name="partnershipamt"
                                            value="{{ $findcost[0]->partnershipamt }}" class="form-control  input-sm"
                                            placeholder="Letter Date...">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa  fa-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 form-group">
                                    <label class="control-label">अन्य साझेदारी संस्था/निकाय</label>
                                    <div class="input-group">
                                        <input type="text" name="partnershiporg"
                                            value="{{ $findcost[0]->partnershiporg }}" class="form-control  input-sm"
                                            placeholder="Subject...">
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
                                        <input type="number" name="cashshare" value="{{ $findcost[0]->cashshare }}"
                                            class="form-control  input-sm" placeholder="Receiver Organization...">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa fa-user-plus"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12 form-group">
                                    <label class="control-label">कन्टिजेन्सी सहितको कुल रकम:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm"
                                            value="{{ $findcost[0]->totalcontingency }}" name="totalcontingency"
                                            id="totalamt" value="{{ $findplan->appropriationamt }}">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa fa-user-secret"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-12 form-group">
                                    <label class="control-label">कन्टिजेन्सी %</label>
                                    <div class="input-group">
                                        <input type="text" id="percentage" value="{{ $findcost[0]->contingencyper }}"
                                            onchange="calc()" class="form-control input-sm" name="contingencyper">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa fa-user-secret"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 form-group">
                                    <label class="control-label">कन्टिजेन्सी र.</label>
                                    <div class="input-group">
                                        <input type="text" name="contingencyamt"
                                            value="{{ $findcost[0]->contingencyamt }}" id="contamt"
                                            class="form-control input-sm" placeholder="Remarks...">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 form-group">
                                    <label class="control-label">अन्य कट्टी %</label>
                                    <div class="input-group">
                                        <input type="text" name="otherdeducper"
                                            value="{{ $findcost[0]->otherdeducper }}" class="form-control input-sm"
                                            placeholder="">
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
                                        <input type="text" name="otherdeducamt"
                                            value="{{ $findcost[0]->otherdeducamt }}" class="form-control  input-sm"
                                            placeholder="Remarks...">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 form-group">
                                    <label class="control-label">
                                        कार्यालयले बेहोर्ने रकम</label>
                                    <div class="input-group">
                                        <input type="text" name="amtbyoffice" value="{{ $findcost[0]->amtbyoffice }}"
                                            id="less" class="form-control  input-sm" placeholder="Remarks...">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 form-group">
                                    <label class="control-label"> समितिबाट जनश्रमदान रकम</label>
                                    <div class="input-group">
                                        <input type="text" name="labordonation"
                                            value="{{ $findcost[0]->labordonation }}" id="wage"
                                            class="form-control input-sm" onchange="totalcalc()"
                                            placeholder="Remarks...">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 form-group">
                                    <label class="control-label">कुल लागत अनुमान रकम</label>
                                    <div class="input-group">
                                        <input type="text" name="totalcost" value="{{ $findcost[0]->totalcost }}"
                                            id="totalwage" class="form-control  input-sm" placeholder="Remarks...">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="fa   fa-pencil-square-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="operationid" value="{{ $findcost[0]->operationid }}">
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
                                                        <th> <button class="btn  bg-maroon btn-xs" id='more-button'
                                                                type="button"><i class="fa fa-plus"></i>Add</button></th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </thead>

                                                <tr class="multipleDiv-attachment">
                                                </tr>
                                                <tr>

                                                    <td class="moreattachment">
                                                        <input type="text" name="Name[]"
                                                            class="form-control input-sm attachment">
                                                    </td>

                                                    <td class="moreattachment">
                                                        <input type="text" name="FatherName[]"
                                                            class="form-control input-sm attachment">
                                                    </td>

                                                    <td class="moreattachment">
                                                        <input type="text" name="GrandFatherName[]"
                                                            class="form-control input-sm attachment">
                                                    </td>

                                                    <td class="moreattachment">
                                                        <input type="text" name="AccountNumber[]"
                                                            class="form-control input-sm attachment">
                                                    </td>
                                                    <td class="w-25">
                                                        <img src=""
                                                            style="max-height: 100px;float: right;margin-left: 20px"
                                                            asdfsdfds class='uploads'>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" style="font-size: 20px; float: right"
                                                            class="remove-this-attachment"> <i
                                                                class="fa fa-close deletable"></i></a>
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
                                        <!-- {!! Form::submit('Update', ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit']) !!}
                                        <a href="#" title="{{ trans('general.button.cancel') }}"
                                            class='btn btn-default'>{{ trans('general.button.cancel') }}</a> -->
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

                        <td class="w-25">
                            <img src="" style="max-height: 100px;float: right;margin-left: 30px" class='uploads'>
                        </td>
                        <td>
                            <a href="javascript:void(0)" style="font-size: 20px; float: right"
                                class="remove-this-attachment"> <i class="fa fa-close deletable"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class='row tab-pane fade' id="operatingoffice">
            <div class='col-md-12'>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 form-group">
                                <p><label class="control-label" style="color:grey">
                                        प्रकार</label>: <strong>{{ $orgdetails->Type }}</strong>
                                </p>
                                <p><label class="control-label" style="color:grey">
                                        उपभोक्ता समितिको नाम</label>: <strong>{{ $orgdetails->Name }}</strong>
                                </p>
                                <p><label class="control-label" style="color:grey">
                                        ठेगाना</label>: <strong>{{ $orgdetails->Address }}</strong>
                                </p>
                                <p><label class="control-label" style="color:rgb(104, 104, 104)">
                                        सम्पर्क नं</label>: <strong>{{ $orgdetails->ContactNumber }}</strong>
                                </p>
                                <p><label class="control-label" style="color:grey">
                                        गठन भएको मिति</label>: <strong>{{ $orgdetails->EstablishedDate }}</strong>
                                </p>

                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                                <p><label class="control-label" style="color:grey">जम्मा सदस्य संख्या</label>:
                                    <strong>{{ $orgdetails->NoOfMember }}</strong></p>
                                <p><label class="control-label" style="color:grey">गठन गर्दा उपस्थित संख्या</label>:
                                    <strong>{{ $orgdetails->NoOfPresentMember }}</strong></p>
                                <p><label class="control-label" style="color:grey">बैकको नाम, शाखा</label>:
                                    <strong>{{ $orgdetails->NameOfBank }}</strong></p>
                                <p><label class="control-label" style="color:grey">बैक खाता नं. </label>:
                                    <strong>{{ $orgdetails->BankAccountNo }}</strong></p>
                                <p><label class="control-label" style="color:grey">कैफियत</label>:
                                    <strong>{{ $orgdetails->Remarks }}</strong></p>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>पद</th>
                                            <th>नाम थर</th>
                                            <th>बुवा/पतिको नाम थर</th>
                                            <th>बाजे/ससुराको नाम थर</th>
                                            <th>ठेगाना</th>
                                            <th>सम्पर्क नं.</th>
                                            <th>हस्ताक्षर गर्ने</th>
                                            <th>नागरिकता नं.</th>
                                        </tr>
                                    </thead>
                                    @foreach ($orgdetails->orgdetail as $details)
                                        <tr>

                                            <td>{{ $details->post->Name }}</td>
                                            <td>{{ $details->Name }}</td>
                                            <td>{{ $details->FatherName }}</td>
                                            <td>{{ $details->GrandFatherName }}</td>
                                            <td>{{ $details->Address }}</td>
                                            <td>{{ $details->ContactNumber }}</td>
                                            <td>
                                                @if ($details->IsSigner == 1)
                                                    हो
                                                @else
                                                    होइन
                                                @endif
                                            </td>
                                            <td>{{ $details->AccountNumber }}</td>

                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class='row tab-pane fade' id='yojana'>
            <div class="box">
                <div class="box-body">
                    <form method="post" action="#"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">
                                    योजना संचालन गर्ने संस्था/समिति:</label>
                                <div class="input-group">
                                    <select name="prjrunning_committee" class="form-control input-sm">
                                        <option value="" disable selected></option>
                                        @foreach ($consumercommittee as $committee)
                                            <option value="{{ $committee->Id }}"
                                                {{ $findagreement[0]->prjrunning_committee == $committee->Id ? 'selected' : '' }}>
                                                {{ $committee->Name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">सम्झौता मिति</label>
                                <div class="input-group">
                                    <input type="text" name="agreementdate"
                                        value="{{ $findagreement[0]->agreementdate }}" placeholder="2079-03-22"
                                        class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-user-secret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">शुरु हुने मिति</label>
                                <div class="input-group">
                                    <input type="text" name="startdate" value="{{ $findagreement[0]->startdate }}"
                                        placeholder="2079-03-22" class="form-control">
                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">
                                    सम्पन्न हुने मिति</label>
                                <div class="input-group">
                                    <input type="text" name="completiondate"
                                        value="{{ $findagreement[0]->completiondate }}" class="form-control">
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
                                    <input type="text" name="householdnumber"
                                        value="{{ $findagreement[0]->householdnumber }}" class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-user-secret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 form-group">
                                <label class="control-label">जनसंख्या</label>
                                <div class="input-group">
                                    <input type="text" name="population" value="{{ $findagreement[0]->population }}"
                                        class="form-control">
                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 form-group">
                                <label class="control-label">
                                    कैफियत</label>
                                <div class="input-group">
                                    <input type="text" name="remarks" value="{{ $findagreement[0]->remarks }}"
                                        class="form-control">
                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $findagreement[0]->operatingid }}" name="operationid">
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">

                                <!-- <div class="form-group pull-right">
                                    {!! Form::submit('Update', ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit']) !!}
                                    <a href="#" title="{{ trans('general.button.cancel') }}"
                                        class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
                                </div> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class='row tab-pane fade' id='yojanaphoto'>
            <div class="box">
                <div class="box-body">
                    <form method="post" action="{{ route('pmsagreed.photo.update', $findagreement[0]->id) }}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label class="control-label">
                                    योजना संग सम्वन्धित फोटो/फाईल:</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="image">
                                    <img src="{{ asset('/plan-photo-images/' . $planPhoto->photo_or_file) }}"
                                        style="height: 80px; margin-top: 20px; margin-left: 10px;">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                                <label class="control-label">फोटो/फाईलको विवरण (क्याप्सन)</label>
                                <div class="input-group">
                                    <input type="text" name="photoCaption"
                                        value="{{ !empty($planPhoto) ? $planPhoto->photo_file_details : '' }}"
                                        placeholder="2079-03-22" class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-user-secret"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">

                                <div class="form-group pull-right">
                                    <!-- {!! Form::submit('Update', ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit']) !!}
                                    <a href="#" title="{{ trans('general.button.cancel') }}"
                                        class='btn btn-default'>{{ trans('general.button.cancel') }}</a> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class='row tab-pane fade' id='extensiondetails'>
            <div class="box">
                <div class="box-body">
                    <form method="post" action="#"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <div class="row">

                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">निवेदन मिति</label>
                                <div class="input-group">
                                    <input type="date" name="request_date"
                                        value="{{ !empty($extensionDetail) ? $extensionDetail->request_date : '' }}"
                                        placeholder="Enter Date" class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">कार्यालयको पत्र मिति</label>
                                <div class="input-group">
                                    <input type="date" name="office_letter_date"
                                        value="{{ !empty($extensionDetail) ? $extensionDetail->office_letter_date : '' }}"
                                        placeholder="Enter Date" class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">सम्पन्न मिति</label>
                                <div class="input-group">
                                    <input type="date" name="completed_date"
                                        value="{{ !empty($extensionDetail) ? $extensionDetail->completed_date : '' }}"
                                        placeholder="Enter Date" class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">म्याद थपको कारण</label>
                                <input type="text" name="extension_reason"
                                    value="{{ !empty($extensionDetail) ? $extensionDetail->extension_reason : '' }}"
                                    placeholder="Enter reason" class="form-control">

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 ">

                                <div class="form-group pull-right">
                                    <!-- {!! Form::submit('Update', ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit']) !!}
                                    <a href="#" title="{{ trans('general.button.cancel') }}"
                                        class='btn btn-default'>{{ trans('general.button.cancel') }}</a> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row tab-pane fade" id="aarthic">
            <div class="box">
                <div class="box-body">
                    <form method="post" action="#"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <div class="row">

                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">विनियोजन रकम</label>
                                <div class="input-group">
                                    <input type="text" name="appropriationamt" value="{{ $findcost[0]->grantamt }}"
                                        placeholder=" Appropriation Amount...." class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                                <label class="control-label">कार्यालयले बेहोर्ने रकम</label>
                                <div class="input-group">
                                    <input type="text" name="amtbyoffice" value="{{ $findcost[0]->amtbyoffice }}"
                                        placeholder="Amount to be borne....." class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 form-group">
                                <label class="control-label">भुक्तानी रकम</label>
                                <div class="input-group">
                                    <input type="text" name="paymentamt" value="{{ $findfinancialtransaction->paymentamt}}" placeholder="Payment Amount...."
                                        class="form-control">

                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 form-group">
                                <label class="control-label"> बाँकी रकम</label>
                                <input type="text" name="remainingamt" value="{{$findfinancialtransaction->remainingamt}}" placeholder="Remaining Amount...."
                                    class="form-control">

                            </div>
                            <div class="col-md-2 col-sm-12 form-group">
                                <label class="control-label">अवस्था</label>
                                <select name="remainingamt" class="form-control">
                                    <option value="" disabled selected>Select Any One</option>
                                    <option value="दर्ता भएको">दर्ता भएको</option>
                                    <option value="लागत अनुमान भएको">लागत अनुमान भएको</option>
                                    <option value="सम्झौता भएको">सम्झौता भएको</option>
                                    <option value="अनुगमन मुल्याङ्कन भएको">अनुगमन मुल्याङ्कन भएको</option>
                                    <option value="म्याद थप भएको">म्याद थप भएको</option>
                                    <option value="सम्पन्न भएको">सम्पन्न भएको</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="more-tr">
                                    <table class="table more table-hover table-bordered" id="tbone" style="width: 100%;">
                                        <tbody>
                                            <thead>
                                                <tr>
                                                    <th>मिति</th>
                                                    <th>विवरण</th>
                                                    <th>भुक्तानी दिन स्वीकृत रकम</th>
                                                    <th>मुल्यांकन अंक</th>
                                                    <th>कैफियत</th>
                                                    <th> <button class="btn  bg-maroon btn-xs" id='more-buttonthree'
                                                            type="button"><i class="fa fa-plus"></i>Add</button></th>
                                                    <th colspan="2"></th>
                                                </tr>
                                            </thead>

                                            <tr class="multipleDiv-attachmentthree">
                                            </tr>
                                            <tr>

                                                <td class="moreattachment">
                                                    <input type="text" name="date[]"
                                                        class="form-control input-sm attachment">
                                                </td>

                                                <td class="moreattachment">
                                                    <input type="text" name="details[]"
                                                        class="form-control input-sm attachment">
                                                </td>

                                                <td class="moreattachment">
                                                    <input type="text" name="sanctionedamt[]"
                                                    class="form-control input-sm attachment getamount">
                                                </td>

                                                <td class="moreattachment">
                                                    <input type="text" name="evaluationpoint[]"
                                                        class="form-control input-sm attachment">
                                                </td>
                                                <td class="moreattachment">
                                                    <input type="text" name="remarks[]"
                                                        class="form-control input-sm attachment">
                                                </td>
                                                <td class="w-25">
                                                    <img src=""
                                                        style="max-height: 100px;float: right;margin-left: 20px"
                                                        class='uploads'>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" style="font-size: 20px; float: right"
                                                        class="remove-this-attachment"> <i
                                                            class="fa fa-close deletable"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>जम्मा</td>
                                                <td id="summation"></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">

                                <div class="form-group pull-right">
                                    <!-- {!! Form::submit('Update', ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit']) !!}
                                    <a href="#" title="{{ trans('general.button.cancel') }}"
                                        class='btn btn-default'>{{ trans('general.button.cancel') }}</a> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="morefilesthree" style="display: none">
            <table class="table table-bordered" id="tbtwo">
                <tbody id="more-customthree-tr">
                    <tr>
                        <td class="moreattachment">
                            <input type="text" name="date[]" class="form-control input-sm attachment">
                        </td>

                        <td class="moreattachment">
                            <input type="text" name="details[]" class="form-control input-sm attachment">
                        </td>

                        <td class="moreattachment">
                            <input type="text" name="sanctionedamt[]" class="form-control input-sm attachment getamount">
                        </td>

                        <td class="moreattachment">
                            <input type="text" name="evaluationpoint[]" class="form-control input-sm attachment">
                        </td>
                        <td class="moreattachment">
                            <input type="text" name="remarks[]"
                                class="form-control input-sm attachment">
                        </td>

                        <td class="w-25">
                            <img src="" style="max-height: 100px;float: right;margin-left: 30px" class='uploads'>
                        </td>
                        <td>
                            <a href="javascript:void(0)" style="font-size: 20px; float: right"
                                class="remove-this-attachmentthree"> <i class="fa fa-close deletable"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>


    <script src="/bower_components/admin-lte/select2/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function calc() {
            var amt = document.getElementById("totalamt").value;
            var per = document.getElementById("percentage").value;
            var peramt = amt * per / 100;
            document.getElementById("contamt").value = peramt;
            var lessamt = amt - peramt;
            document.getElementById("less").value = lessamt;
        }

        function totalcalc() {
            var lessamt = document.getElementById('less').value;
            var wage = document.getElementById("wage").value;
            if (wage == 0 || wage == null) {
                document.getElementById("totalwage").value = lessamt;
            } else {
                var add = parseInt(lessamt) + parseInt(wage);
                document.getElementById("totalwage").value = add;
            }
        }
    </script>
    <script>
       $(document).on('keyup', '.getamount', function ()
       {
        var total = 0;
           var length = $('.getamount').length;

           for( var i = 0; i < (length-1); i++){
            var amount = parseInt($('.getamount').eq(i).val());
            total = total + amount;
           }
           document.getElementById("summation").innerHTML = total;
       });
    </script>    
    <script type="text/javascript">
        $('#more-button').click(function() {
            $(".multipleDiv-attachment").after($('#morefiles #more-custom-tr').html());
        });
        $('#more-buttontwo').click(function() {
            $(".multipleDiv-attachmenttwo").after($('#morefilestwo #more-customtwo-tr').html());
        });
        $('#more-buttonthree').click(function() {
            $(".multipleDiv-attachmentthree").after($('#morefilesthree #more-customthree-tr').html());
        });

        $(document).on('click', '.remove-this-attachment', function() {
            $(this).parent().parent().remove();
        });
        $(document).on('click', '.remove-this-attachmenttwo', function() {
            $(this).parent().parent().remove();
        });
        $(document).on('click', '.remove-this-attachmentthree', function() {
            $(this).parent().parent().remove();
        });

        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        $(document).on('change', '.attachment', function() {
            var input = this;
            // console.log('done');
            var parent = $(this).parent().parent();
            if (input.files && input.files[0]) {
                var fileType = input.files[0]['type'];
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (validImageTypes.includes(fileType)) {
                        parent.find('.uploads')
                            .attr('src', e.target.result)
                            .width(150)
                            .height(200);
                    } else {
                        parent.find('.uploads')
                            .attr('src', '')
                            .width(0)
                            .height(0);
                    }

                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endsection
