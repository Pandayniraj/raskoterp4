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
				<b><font size="4">Marriage Registration forms </font></b>
				<div style="display: inline; float: right;">
					<a class="btn btn-success btn-sm" style="margin-bottom: 10px"  title="Import/Export Leads" href="{{ route('admin.marriage.create') }}">
						<i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>Create</strong>
					</a>
				</div>
			</div>
		</div>

		<table class="table table-hover table-no-border" id="leads-table">

			<thead>
				<tr class="bg-info">

					<th>ID</th>
					<th>Ref No</th>
					<th>Bride Name</th>
					<th>Groom Name</th>
					<th>Marriage Date</th>
					<th>Marriage Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($marriageregistration as $key=>$att)
				<tr>
					<td>{{ $att->id }}</td>
					<td>{{ $att->ref_no }}</td>
					<td>{{ $att->bride_fullname }}</td>
					<td>{{ $att->groom_fullname }}</td>
					<td>{{ $att->marriage_date }}</td>
					<td>{{ $att->marriage_type }}</td>
					<td>
						<a href="/admin/marriage/{{$att->id}}/edit"><i class="fa fa-edit"></i></a>
						<a href="{!! route('admin.marriage.confirm-delete', $att->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable"></i></a>
					</td>
				</tr>

				@endforeach

			</tbody>
		</table>
	</div>
</div>

@endsection
