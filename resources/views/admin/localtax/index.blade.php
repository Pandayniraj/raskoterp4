@extends('layouts.master')
@section('content')

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
	<h1>
		{{ $page_title ?? "Page Title"}}
		<small> {{ $page_description ?? "Page Description" }}</small>
	</h1>
	{!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false)  !!}
</section>


<div class="box box-primary">
	<div class="box-header with-border">
		<div class='row'>
			<div class='col-md-12'>
				<b><font size="4">स्थानीय कर फारमहरू </font></b>
				<div style="display: inline; float: right;">
					<a class="btn btn-success btn-sm" style="margin-bottom: 10px"  title="Import/Export Leads" href="{{ route('admin.localtax.create') }}">
						<i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>सिर्जना गर्नुहोस्</strong>
					</a>
				</div>
			</div>
		</div>

		<table class="table table-hover table-no-border" id="leads-table">

			<thead>
				<tr class="bg-info">

					<th>आइडी</th>
					<th>कार्यालयको कोड नं</th>
					<th>Receipt No</th>
					<th>रसिद नं</th>
					<th>कुल रकम</th>
					<th>कार्य</th>
				</tr>
			</thead>
			<tbody>
				@foreach($localtaxs as $key=>$att)

				<tr>


					<td>{{ $att->id }}</td>
					<td>{{ $att->officer_code_number }}</td>
					<td>{{ $att->receipt_no }}</a></td>
					<td>{{ $att->date }}</td>
					<td>{{ $att->total_amount }}</td>
					<td>
						@if(!$att->approved_by)
						<a href="/admin/localtax/{{$att->id}}/edit?approve"><i title="click to approve" class="fa fa-check-circle fa-colour-blue"></i></a>
						@endif
						@if($att->approved_by)
						<a><i class="fa fa-check-circle"></i></a>
						@endif
						<a href="/admin/localtax/{{$att->id}}/edit"><i class="fa fa-edit"></i></a>
						<a href="{!! route('admin.localtax.confirm-delete', $att->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable"></i></a>

					</td>
				</tr>

				@endforeach

			</tbody>
		</table>
	</div>
</div>


@endsection
