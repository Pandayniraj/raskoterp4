@extends('layouts.master')

@section('head_extra')
<!-- Select2 css -->
@include('partials._head_extra_select2_css')

<style>
	.panel .mce-panel {
		border-left-color: #fff;
		border-right-color: #fff;
	}

	.panel .mce-toolbar,
	.panel .mce-statusbar {
		padding-left: 20px;
	}

	.panel .mce-edit-area,
	.panel .mce-edit-area iframe,
	.panel .mce-edit-area iframe html {
		padding: 0 10px;
		min-height: 350px;
	}

	.mce-content-body {
		color: #555;
		font-size: 14px;
	}

	.panel.is-fullscreen .mce-statusbar {
		position: absolute;
		bottom: 0;
		width: 100%;
		z-index: 200000;
	}

	.panel.is-fullscreen .mce-tinymce {
		height:100%;
	}

	.panel.is-fullscreen .mce-edit-area,
	.panel.is-fullscreen .mce-edit-area iframe,
	.panel.is-fullscreen .mce-edit-area iframe html {
		height: 100%;
		position: absolute;
		width: 99%;
		overflow-y: scroll;
		overflow-x: hidden;
		min-height: 100%;
	}

	.footer {
		position: fixed;
		left: 0;
		bottom: 0;
		width: 100%;
		background-color: #efefef;
		color: white;
		text-align: center;
	}
	.product-td .select2-container{
		width: 295px!important;
	}
	.remove-this{
		padding-top: 6px !important;
		padding-bottom: 6px !important;
	}

	body {
		background-color: #efefef;
	}

	.profile-pic {
		width: 200px;
		max-height: 200px;
		display: inline-block;
	}

	.file-upload {
		display: none !important;
	}
	.circle {
		border-radius: 100% !important;
		overflow: hidden;
		width: 128px;
		height: 128px;
		border: 2px solid rgba(255, 255, 255, 0.2);
		position: relative;
		top: 10px;
	}
	img {
		max-width: 100%;
		height: auto;
	}
	.p-image {
		position: relative;
		bottom: 25px;
		left: 99px;
		color: #666666;
		transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
	}
	.p-image:hover {
		transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
	}
	.upload-button {
		font-size: 1.2em;
	}

	.upload-button:hover {
		transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
		color: #999;
	}
	.style1{
		vertical-align: middle !important;
		/*font-weight: 600;*/
	}


</style>
@endsection

@section('content')
<link href="/bower_components/admin-lte/select2/css/select2.min.css" rel="stylesheet" />
<script src="/bower_components/admin-lte/select2/js/select2.min.js"></script>

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
	<h1>
		{{ $page_title ?? "Page Title"}}
		<small> {{ $page_description ?? "Page Description" }}</small>
	</h1>
	{!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false)  !!}
</section>


<div class='row'>
	<div class='col-md-12'>
		<div class="box box-header">
			<div id="orderFields" style="display: none;">

			</div>

			<div class="col-md-12">
				<div class="">
					<form method="POST" action="{{route('admin.migration.update',$migrationregistration->id)}}" enctype="multipart/form-data" >
						{{ csrf_field() }}

						<div class="">

							<div class="clearfix"></div>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-3 form-group" style="">
										<label for="ref_no"> Ref No.</label>
										<input class="form-control input-sm " name="ref_no" required type="text" value="{{ $migrationregistration->ref_no ?? '' }}">
									</div>

									<div class="col-md-3 form-group" style="">
										<label for="ward_no"> Ward No.</label>
										<input class="form-control input-sm " name="ward_no" required type="text" value="{{ $migrationregistration->ward_no ?? '' }}">
									</div>

									<div class="col-md-3 form-group" style="">
										<label for="reg_date"> Registration Date (Nepali)</label>
										<input class="form-control input-sm nepali-registration-datepicker" id="nepali-registration-datepicker" name="reg_date" required type="text" value="{{ date('Y-m-d', strtotime($migrationregistration->reg_date)) ?? '' }}">
									</div>

									<div class="col-md-3 form-group" style="">
										<label for="reg_date_english"> Registration Date</label>
										<input class="form-control input-sm datepicker" name="reg_date_english" required type="text" value="{{ $migrationregistration->reg_date_english ?? '' }}">
									</div>

								</div>
							</div>

							<hr/>

							<table class="table table-hover table-bordered table-striped">
								<tr class="text-center">
									<td colspan="4" width="100%"><b>Migration Details:</b></td>
								</tr>      
								<tr>
									<td align="right" class="style1">Full Name:</td>
									<td class="style2">
										<input class="form-control input-sm" name="fullname" required type="text" value="{{ $migrationregistration->fullname ?? '' }}" placeholder="Full Name">
									</td>
									<td align="right" class="style1">Full Name Nepali:</td>
									<td class="style2">
										<input class="form-control input-sm" name="fullname_nepali" required type="text" value="{{ $migrationregistration->fullname_nepali ?? '' }}" placeholder="Full Name Nepali">
									</td>
								</tr> 
								<tr>
									<td align="right" class="style1">Date Of Birth:</td>
									<td class="style2">
										<input class="form-control input-sm datepicker" id="datepicker" name="dob" required type="text" value="{{ $migrationregistration->dob ?? '' }}" placeholder="Date Of Birth">
									</td>
									<td align="right" class="style1">Date Of Birth Nepali:</td>
									<td class="style2">
										<input class="form-control input-sm nepali-datepicker" id="nepali-datepicker" name="dob_nepali" required type="text" value="{{ date('Y-m-d', strtotime($migrationregistration->dob_nepali)) ?? '' }}" placeholder="Date Of Birth Nepali">
									</td>
								</tr> 
								<tr>
									<td align="right" class="style1">Gender:</td>
									<td class="style2">
										<select required class="form-control input-sm" name="gender" required>
											<option selected disabled >Select
											</option>
											<option value="male" {{ $migrationregistration->gender == 'male' ? 'selected': '' }} >Male</option>
											<option value="female" {{ $migrationregistration->gender == 'female' ? 'selected': '' }} >Female</option>
											<option value="others" {{ $migrationregistration->gender == 'others' ? 'selected': '' }} >Others</option>
										</select>
									</td>
									<td align="right" class="style1">Gender Nepali:</td>
									<td class="style2">
										<select required class="form-control input-sm" name="gender_nepali" required>
											<option selected disabled >Select
											</option>
											<option value="पुरुष" {{ $migrationregistration->gender_nepali == 'पुरुष' ? 'selected': '' }} >पुरुष</option>
											<option value="महिला" {{ $migrationregistration->gender_nepali == 'महिला' ? 'selected': '' }} >महिला</option>
											<option value="अन्य" {{ $migrationregistration->gender_nepali == 'अन्य' ? 'selected': '' }} >अन्य</option>
										</select>
									</td>
								</tr>
								<tr>
									<td align="right" class="style1">Citizenship Number:</td>
									<td class="style2">
										<input class="form-control input-sm" name="citizenship_num" required type="text" value="{{ $migrationregistration->citizenship_num ?? '' }}" placeholder="Citizenship Number">
									</td>
									<td align="right" class="style1">Citizenship Number Nepali:</td>
									<td class="style2">
										<input class="form-control input-sm" name="citizenship_num_nepali" required type="text" value="{{ $migrationregistration->citizenship_num_nepali ?? '' }}" placeholder="Citizenship Number Nepali">
									</td>
								</tr>   
								<tr>
									<td align="right" class="style1">Permanent Address:</td>
									<td class="style2">
										<input class="form-control input-sm" name="perm_address" required type="text" value="{{ $migrationregistration->perm_address ?? '' }}" placeholder="Permanent Address">
									</td>
									<td align="right" class="style1">Permanent Address Nepali:</td>
									<td class="style2">
										<input class="form-control input-sm" name="perm_address_nepali" required type="text" value="{{ $migrationregistration->perm_address_nepali ?? '' }}" placeholder="Permanent Address Nepali">
									</td>
								</tr> 
								<tr>
									<td align="right" class="style1">Father Name:</td>
									<td class="style2">
										<input class="form-control input-sm" name="fathername" required type="text" value="{{ $migrationregistration->fathername ?? '' }}" placeholder="Father Name">
									</td>
									<td align="right" class="style1">Father Name Nepali:</td>
									<td class="style2">
										<input class="form-control input-sm" name="fathername_nepali" required type="text" value="{{ $migrationregistration->fathername_nepali ?? '' }}" placeholder="Father Name Nepali">
									</td>
								</tr> 
								<tr>
									<td align="right" class="style1">Mother Name:</td>
									<td class="style2">
										<input class="form-control input-sm" name="mothername" required type="text" value="{{ $migrationregistration->mothername ?? '' }}" placeholder="Mother Name">
									</td>
									<td align="right" class="style1">Mother Name Nepali:</td>
									<td class="style2">
										<input class="form-control input-sm" name="mothername_nepali" required type="text" value="{{ $migrationregistration->mothername_nepali ?? '' }}" placeholder="Mother Name Nepali">
									</td>
								</tr>
								<tr>
									<td align="right" class="style1">Migrated From:</td>
									<td class="style2">
										<input class="form-control input-sm" name="migrated_from" required type="text" value="{{ $migrationregistration->migrated_from ?? '' }}" placeholder="Migrated From">
									</td>
									<td align="right" class="style1">Migrated From Nepali:</td>
									<td class="style2">
										<input class="form-control input-sm" name="migrated_from_nepali" required type="text" value="{{ $migrationregistration->migrated_from_nepali ?? '' }}" placeholder="Migrated From Nepali">
									</td>
								</tr>
								<tr>
									<td align="right" class="style1">Local Registrar Name:</td>
									<td class="style2">
										<input class="form-control input-sm" name="local_registar_name" required type="text" value="{{ $migrationregistration->local_registar_name ?? '' }}" placeholder="Local Registrar Name">
									</td>
									<td align="right" class="style1">Local Registrar Name Nepali:</td>
									<td class="style2">
										<input class="form-control input-sm" name="local_registar_name_nepali" required type="text" value="{{ $migrationregistration->local_registar_name_nepali ?? '' }}" placeholder="Local Registrar Name Nepali">
									</td>
								</tr>   
							</table>


						</div>
						<div class="panel-footer footer">
							<button type="submit" class="btn btn-social btn-foursquare">
								<i class="fa fa-save"></i>Update 
							</button>

							<a class="btn btn-social btn-foursquare" href="/admin/birth"> <i class="fa fa-times"></i> Cancel </a>

						</div>
					</form>
				</div>
			</div>

		</div><!-- /.box-body -->
	</div><!-- /.col -->

</div><!-- /.row -->
@endsection

@section('body_bottom')
<!-- form submit -->
@include('partials._body_bottom_submit_bug_edit_form_js')
/* Use online reference */

<link href="http://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v3.7.min.css" rel="stylesheet" type="text/css"/>

<script src="http://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v3.7.min.js" type="text/javascript"></script>


<script type="text/javascript">

	$(function() {
		$('.datepicker').datetimepicker({
			format: 'YYYY-MM-DD',
			sideBySide: true,
			allowInputToggle: true,
			
		});

		// $('#datepicker').on('change', function(){
		// 	/* Select your element */
		// 	var mainInput = document.getElementById("datepicker");
		// 	alert(mainInput);
		// 	/* Initialize Datepicker with options */
		// 	// mainInput.nepaliDatePicker({
		// 	// 	dateFormat: 'YYYY-MM-DD',
		// 	// 	disableBefore: "2020-01-01",
		// 	// 	disableAfter: "2078-11-29",
		// 	// 	ndpYear: true,
		// 	// 	ndpMonth: true,
		// 	// 	onChange: function() {
		// 	// 		var object_bs = NepaliFunctions.ConvertToDateObject(mainInput.value, "YYYY-MM-DD");
		// 	// 		var object_ad = NepaliFunctions.BS2AD({year: object_bs.year, month: object_bs.month, day: object_bs.day})
		// 	// 		var format_ad = NepaliFunctions.ConvertDateFormat({year: object_ad.year, month: object_ad.month, day: object_ad.day}, "YYYY-MM-DD")
		// 	// 		$('.datepicker').val(format_ad);
		// 	// 	}
		// 	// });
		// });

	});

	/* Select your element */
	var mainInput = document.getElementById("nepali-datepicker");
	/* Initialize Datepicker with options */
	mainInput.nepaliDatePicker({
		// unicodeDate: true,
		dateFormat: 'YYYY-MM-DD',
		disableBefore: "2020-01-01",
		disableAfter: "2078-11-29",
		ndpYear: true,
		ndpMonth: true,
		onChange: function() {
			var object_bs = NepaliFunctions.ConvertToDateObject(mainInput.value, "YYYY-MM-DD");
			var object_ad = NepaliFunctions.BS2AD({year: object_bs.year, month: object_bs.month, day: object_bs.day})
			var format_ad = NepaliFunctions.ConvertDateFormat({year: object_ad.year, month: object_ad.month, day: object_ad.day}, "YYYY-MM-DD")
			$('.datepicker').val(format_ad);
		}
	});

	/* Select your element */
	var regDate = document.getElementById("nepali-registration-datepicker");
	/* Initialize Datepicker with options */
	regDate.nepaliDatePicker({
		// unicodeDate: true,
		dateFormat: 'YYYY-MM-DD',
		disableBefore: "2020-01-01",
		disableAfter: "2078-11-29",
	});
	

	// NepaliFunctions.BS2AD({year: 2058, month: 2, day: 19})


</script>

<script type="text/javascript">
	$(document).ready(function() {
		var readURL= function(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('.pic').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		$(".file-upload-groom").on('change', function(){
			readURLGroom(this);
		});

		$(".upload-button-groom").on('click', function() {
			$(".file-upload-groom").click();
		});

		var readURLBride = function(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('.bride-pic').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		$(".file-upload-bride").on('change', function(){
			readURLBride(this);
		});

		$(".upload-button-bride").on('click', function() {
			$(".file-upload-bride").click();
		});
	});


</script>
@endsection
