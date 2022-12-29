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
				<b><font size="4">घरधुरी सर्वेक्षण </font></b>
				<div style="display: inline; float: right;">
					<a class="btn btn-success btn-sm" style="margin-bottom: 10px"  title="Import/Export Leads" href="{{ route('household.create') }}">
						<i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>Create</strong>
					</a>
				</div>
			</div>

			<div class="col-md-12">
				<form method="GET" action="{{ route('household.index') }}">
					<table class="table table-hover table-no-border" style="margin-bottom: 20px;">
						<tr>
							<td><input type="text" class="form-control" name="uttardata_contact_no" placeholder="उत्तरदाता/सम्पर्क नं." value="{{ Request::get('uttardata_contact_no') }}"></td>
							<td>
								<select class="form-control" name="main_caste">
									<option value="">जात/जाति</option>
									
									@foreach ($castes as $id => $cast)
										<option value="{{ $id }}" {{ ($id==Request::get('main_caste'))? 'selected' : '' }}>{{ $cast }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control" name="mobile_no">
									<option value="">शैक्षिकस्तर छान्नुहोस्</option>
									
									@foreach ($educations as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('mobile_no'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control" name="occupation">
									<option value="">पेशा/व्यवसाय छान्नुहोस्</option>
									
									@foreach ($occupations as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('occupation'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
						</tr>

						<tr>
							<td>
								<select class="form-control" name="if_connected_with_any_institution_name_it">
									<option value="">आवध संघ/संस्थामा छान्नुहोस्</option>
									
									@foreach ($institutes as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('if_connected_with_any_institution_name_it'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control" name="how_long_months_does_your_production_or_income_feed_your_family">
									<option value="">आफ्नो उत्पादन/आम्दानीले खान पुग्ने छान्नुहोस्</option>
									
									@foreach ($timePeriods as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('how_long_months_does_your_production_or_income_feed_your_family'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control" name="types_of_your_house_jog">
									<option value="">घरको जग छान्नुहोस्</option>
									
									@foreach ($houseBasements as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('types_of_your_house_jog'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control" name="roof_types_of_your_home">
									<option value="">घरको छानाको प्रकार छान्नुहोस्</option>
									
									@foreach ($roofTypeOfHouses as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('roof_types_of_your_home'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
						</tr>

						<tr>
							<td>
								<select class="form-control" name="source_of_firewood">
									<option value="">चुलोको प्रकार छान्नुहोस्</option>
									
									@foreach ($stoveTypes as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('source_of_firewood'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control" name="type_of_toilet">
									<option value="">शौचालयको प्रकार छान्नुहोस्</option>
									
									@foreach ($toiletTypes as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('type_of_toilet'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control" name="source_of_drinking_water">
									<option value="">खानेपानीको मुख्य स्रोत छान्नुहोस्</option>
									
									@foreach ($sourceOfDrinkingWaters as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('source_of_drinking_water'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control" name="ward_no">
									<option value="">वडा नं. छान्नुहोस्</option>
									
									@foreach ($wardNos as $id => $value)
										<option value="{{ $id }}" {{ ($id==Request::get('ward_no'))? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</td>
						</tr>

						<tr>
							<td></td>
							<td></td>
							<td></td>

							<td class="text-right">
								<button class="btn btn-success">Search</button>
								<a href="{{ route('household.index') }}" class="btn btn-primary">Cancel</a>
							</td>

						</tr>

					</table>
				</form>

				
			</div>
		</div>

		<table class="table table-hover table-no-border" id="leads-table">

			<thead>
				<tr class="bg-info">
					<th>क्र.सं.</th>
					<th>घरमुलीको नाम</th>
					<th>सम्पर्क नं.</th>
					<th>संख्या</th>
					<th>खानेपानीको मुख्य स्रोत</th>
					<th>मुख्य इन्धन</th>
					<th>उपभोग सुविधाहरु</th>
					<th>आम्दानी</th>
					<th>खर्च</th>
					<th>घरको स्वामित्व</th>
					<th width="8%">सेटिङ</th>
				</tr>
			</thead>
			<tbody>
				@foreach($households as $household)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $household->uttardata_name }}</td>
					<td>{{ $household->mobile_no }}</td>
					<td>{{ $household->family_number_with_gharmuli }}</td>
					<td>{{ $household->source_of_drinking_water }}</td>
					<td>{{ $household->main_fuel_for_cooking_food }}</td>
					<td>{{ $household->consumption_of_services_in_family }}</td>
					<td>{{ $household->yearly_income_of_family }}</td>
					<td>{{ $household->yearly_expenses_of_family }}</td>
					<td>{{ $household->possession_of_your_home }}</td>
					<td>
						<a href="{{ route('household.edit', $household->id) }}"><i class="fa fa-edit"></i></a>
						<a href="{{ route('household.show', $household->id) }}"><i class="fa fa-eye"></i></a>
						<a href="{{ url('admin/household/destroy/'. $household->id) }}"  title="{{ trans('general.button.delete') }}" onclick="return confirm('Do you want to delete this data ?');"><i class="fa fa-trash-o deletable"></i></a>
					</td>
				</tr>

				@endforeach

			</tbody>
		</table>
	</div>

	<div class="box box-footer">
		<div class="row">
			<div class="col-md-12 text-right">
				{!! $households->links() !!}
			</div>
		</div>
	</div>
</div>

@endsection
