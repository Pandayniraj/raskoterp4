@extends('layouts.master')

@section('head_extra')
    <!-- Select2 css -->
    @include('partials._head_extra_select2_css')
@endsection

@section('content')

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
            <h1>
             {{ $page_title ?? "Page Title"}} 
                <small>{{$description}}</small>
            </h1>
            {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false)  !!}
        </section>
       <form  action="{{route('admin.invoice.returnfromird.post')}}" method="post"> 
        {{csrf_field()}}
   	<div class="row">
        		<div class="col-md-6">
   <div class="panel panel-custom"> 

        <div class="panel-heading">
        	
        	<div class="row">
        		<div class="col-md-12">
        			<label>Fiscal Year</label>
        			<div class="form-group">
        				<select class="form-control searchable" name="fiscal_year" required="">
                            <option value="">--Select Fiscal Year--</option>
                            @foreach($fiscalyear as $o)
                                <option value="{{$o->fiscal_year}}" @if($o->current_year == 1) selected @endif> #{{$o->fiscal_year}} ({{$o->id}})</option>
                            @endforeach            
                        </select>
        			</div>
        		</div>
        	</div>


        	<div class="row">
        		<div class="col-md-12">
        			<label>Bill Type</label>
        			<div class="form-group">
        				<select class="form-control" name='bill_type'>
                            <option value="tax">Tax Bills</option>
                        </select>
        			</div>
        		</div>
        	</div>

            <div class="row">
                <div class="col-md-12">
                    <label>Bill Number</label>
                    <div class="form-group">
                       <input type="text" name="bill_no" class="form-control" required>
                    </div>
                </div>
            </div>

             <div class="row">
                <div class="col-md-12">
                    <label>Credit Note No</label>
                    <div class="form-group">
                       <input type="text" name="credit_note_no" class="form-control" value="{{$credit_note_no}}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label>Cancel Date</label>
                    <div class="form-group">
                       <input type="text" name="cancel_date" class="form-control datepicker" data-single='true' required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label>Cancel Reason</label>
                    <div class="form-group">
                        <textarea name="void_reason" class="form-control" required></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Return Bill</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
  </div>
</form>



@endsection

@section('body_bottom')
@include('partials._date-toggle')

<link href="/bower_components/admin-lte/select2/css/select2.min.css" rel="stylesheet" />>
<link href="{{ asset("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.css") }}" rel="stylesheet" type="text/css" />
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>

<script src="/bower_components/admin-lte/select2/js/select2.min.js"></script>
<link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
<script src="{{ asset("/bower_components/admin-lte/plugins/jQueryUI/jquery-ui.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/moment.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap-datetimepicker.js") }}" type="text/javascript"></script>


<script src="/bower_components/admin-lte/plugins/datatables/extra/export.js"></script>

<script type="text/javascript">
    $('.datepicker').datepicker({
          dateFormat: 'yy-mm-dd',
        sideBySide: true,
    });
  
</script>




@endsection