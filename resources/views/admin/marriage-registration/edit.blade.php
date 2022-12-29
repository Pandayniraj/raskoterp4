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
	.groom-style1{
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
					<form method="POST" action="{{route('admin.marriage.update',$marriageregistration->id)}}" enctype="multipart/form-data" >
						{{ csrf_field() }}

						<div class="">

							<div class="clearfix"></div>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-3 form-group" style="">
										<label for="ref_no"> Ref No.</label>
										<input class="form-control input-sm " name="ref_no" required type="text" value="{{ $marriageregistration->ref_no ?? '' }}">
									</div>

									<div class="col-md-3 form-group" style="">
										<label for="ward_no"> Ward No.</label>
										<input class="form-control input-sm " name="ward_no" required type="text" value="{{ $marriageregistration->ward_no ?? '' }}">
									</div>

									<div class="col-md-3 form-group" style="">
										<label for="darta_date"> Data Date</label>
										<input class="form-control input-sm datepicker" name="darta_date" required type="text" value="{{ $marriageregistration->darta_date ?? '' }}">
									</div>

									<div class="col-md-3 form-group" style="">
										<label for="marriage_date"> Marriage Date</label>
										<input class="form-control input-sm datepicker" name="marriage_date" required type="text" value="{{ $marriageregistration->marriage_date ?? '' }}">
									</div>

									<div class="col-md-3 form-group" style="">
										<label for="marriage_date">Marriage Type</label>
										<select required class="form-control input-sm" name="marriage_type" required>
											<option selected disabled >Select Type
											</option>
											<!-- @foreach($marriage_type as $type)
											<option value="{{$type->id}}" {{ $marriageregistration->ref_no == $type->id ? 'selected':'' }}>{{$type->title}}</option>
											@endforeach -->
											<option value="religious">Religious</option>
											<option value="court">Court</option>
										</select>
									</div>

									<div class="col-md-3 form-group" style="">
										<label for="local_registar"> Local Registar</label>
										<input class="form-control input-sm" name="local_registar" required type="text" value="{{ $marriageregistration->local_registar ?? '' }}">
									</div>

								</div>
							</div>


							<hr/>

							<table class="table table-hover table-bordered table-striped">
								<tr class="text-center">
									<td colspan="2" width="50%"><b>Groom Details:</b></td>
									<td colspan="2" width="50%"><b>Bride Details:</b></td>
								</tr>      
								<tr style="background-color: #7a7a7a26;">
									<td align="right" class="groom-style1">Groom Profile Photo:</td>    
									<td class="groom-style2">
										<div class="">
											<div class="small-12 medium-2 large-2 columns">
												<div class="circle">
													@if($marriageregistration->groom_photo != '')
													<img class="profile-pic bride-pic" src="{{$marriageregistration->groom_photo}}">
													@else
													<img class="profile-pic bride-pic" src="/images/profiles/default-profile.jpg">
													@endif
												</div>
												<div class="p-image">
													<i class="fa fa-camera upload-button upload-button-groom"></i>
													<input class="file-upload file-upload-groom" type="file" accept="image/*" name="groom_photo" value="{{ $marriageregistration->groom_photo ?? '' }}" />
												</div>
											</div>
										</div>
									</td>
									<td align="right" class="groom-style1">Bride Profile Photo:</td>    
									<td class="groom-style2">
										<div class="">
											<div class="small-12 medium-2 large-2 columns">
												<div class="circle">
													@if($marriageregistration->bride_photo != '')
													<img class="profile-pic bride-pic" src="{{$marriageregistration->bride_photo}}">
													@else
													<img class="profile-pic bride-pic" src="/images/profiles/default-profile.jpg">
													@endif
													
												</div>
												<div class="p-image">
													<i class="fa fa-camera upload-button upload-button-bride"></i>
													<input class="file-upload file-upload-bride" type="file" accept="image/*" name="bride_photo" value="{{ $marriageregistration->bride_photo ?? '' }}" />
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td align="right" class="groom-style1">Groom Full Name:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_fullname" required type="text" value="{{ $marriageregistration->groom_fullname ?? '' }}" placeholder="Groom Full Name">
									</td>
									<td align="right" class="groom-style1">Bride Full Name:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_fullname" required type="text" value="{{ $marriageregistration->bride_fullname ?? '' }}" placeholder="Bride Full Name">
									</td>
								</tr> 
								<tr>
									<td align="right" class="groom-style1">Groom Full Name Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_fullname_nepali" required type="text" value="{{ $marriageregistration->groom_fullname_nepali ?? '' }}" placeholder="Groom Full Name Nepali">
									</td>
									<td align="right" class="groom-style1">Bride Full Name Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_fullname_nepali" required type="text" value="{{ $marriageregistration->bride_fullname_nepali ?? '' }}" placeholder="Bride Full Name Nepali">
									</td>
								</tr> 
								<tr>
									<td align="right" class="groom-style1">Groom Date Of Birth:</td>
									<td class="groom-style2">
										<input class="form-control input-sm datepicker" name="groom_dob" required type="text" value="{{ $marriageregistration->groom_dob ?? '' }}" placeholder="Groom Date Of Birth">
									</td>
									<td align="right" class="groom-style1">Bride Date Of Birth:</td>
									<td class="groom-style2">
										<input class="form-control input-sm datepicker" name="bride_dob" required type="text" value="{{ $marriageregistration->bride_dob ?? '' }}" placeholder="Bride Date Of Birth">
									</td>
								</tr> 
								<tr>
									<td align="right" class="groom-style1">Groom Date Of Birth Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm datepicker" name="groom_dob_nepali" required type="text" value="{{ $marriageregistration->groom_dob_nepali ?? '' }}" placeholder="Groom Date Of Birth Nepali">
									</td>
									<td align="right" class="groom-style1">Bride Date Of Birth Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm datepicker" name="bride_dob_nepali" required type="text" value="{{ $marriageregistration->bride_dob_nepali ?? '' }}" placeholder="Bride Date Of Birth Nepali">
									</td>
								</tr> 
								<tr>
									<td align="right" class="groom-style1">Groom Citizenship Number:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_citizen_num" required type="text" value="{{ $marriageregistration->groom_citizen_num ?? '' }}" placeholder="Groom Citizenship Number">
									</td>
									<td align="right" class="groom-style1">Bride Citizenship Number:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_citizen_num" required type="text" value="{{ $marriageregistration->bride_citizen_num ?? '' }}" placeholder="Bride Citizenship Number">
									</td>
								</tr> 
								<tr>
									<td align="right" class="groom-style1">Groom Citizenship Number Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_citizen_num_nepali" required type="text" value="{{ $marriageregistration->groom_citizen_num_nepali ?? '' }}" placeholder="Groom Citizenship Number Nepali">
									</td>
									<td align="right" class="groom-style1">Bride Citizenship Number Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_citizen_num_nepali" required type="text" value="{{ $marriageregistration->bride_citizen_num_nepali ?? '' }}" placeholder="Bride Citizenship Number Nepali">
									</td>
								</tr>  
								<tr>
									<td align="right" class="groom-style1">Groom Permanent Address:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_perm_address" required type="text" value="{{ $marriageregistration->groom_perm_address ?? '' }}" placeholder="Groom Permanent Address">
									</td>
									<td align="right" class="groom-style1">Bride Permanent Address:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_perm_address" required type="text" value="{{ $marriageregistration->bride_perm_address ?? '' }}" placeholder="Bride Permanent Address">
									</td>
								</tr> 
								<tr>
									<td align="right" class="groom-style1">Groom Permanent Address Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_perm_address_nepali" required type="text" value="{{ $marriageregistration->groom_perm_address_nepali ?? '' }}" placeholder="Groom Permanent Address Nepali">
									</td>
									<td align="right" class="groom-style1">Bride Permanent Address Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_perm_address_nepali" required type="text" value="{{ $marriageregistration->bride_perm_address_nepali ?? '' }}" placeholder="Bride Permanent Address Nepali">
									</td>
								</tr>  
								<tr>
									<td align="right" class="groom-style1">Groom Father Name:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_fathername" required type="text" value="{{ $marriageregistration->groom_fathername ?? '' }}" placeholder="Groom Father Name">
									</td>
									<td align="right" class="groom-style1">Bride Father Name:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_fathername" required type="text" value="{{ $marriageregistration->bride_fathername ?? '' }}" placeholder="Bride Father Name">
									</td>
								</tr> 
								<tr>
									<td align="right" class="groom-style1">Groom Father Name Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_fathername_nepali" required type="text" value="{{ $marriageregistration->groom_fathername_nepali ?? '' }}" placeholder="Groom Father Name Nepali">
									</td>
									<td align="right" class="groom-style1">Bride Father Name Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_fathername_nepali" required type="text" value="{{ $marriageregistration->bride_fathername_nepali ?? '' }}" placeholder="Bride Father Name Nepali">
									</td>
								</tr> 
								<tr>
									<td align="right" class="groom-style1">Groom Mother Name:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_mothername" required type="text" value="{{ $marriageregistration->groom_mothername ?? '' }}" placeholder="Groom Mother Name">
									</td>
									<td align="right" class="groom-style1">Bride Mother Name:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_mothername" required type="text" value="{{ $marriageregistration->bride_mothername ?? '' }}" placeholder="Bride Mother Name">
									</td>
								</tr>
								<tr>
									<td align="right" class="groom-style1">Groom Mother Name Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_mothername_nepali" required type="text" value="{{ $marriageregistration->groom_mothername_nepali ?? '' }}" placeholder="Groom Mother Name Nepali">
									</td>
									<td align="right" class="groom-style1">Bride Mother Name Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_mothername_nepali" required type="text" value="{{ $marriageregistration->bride_mothername_nepali ?? '' }}" placeholder="Bride Mother Name Nepali">
									</td>
								</tr>
								<tr>
									<td align="right" class="groom-style1">Groom GrandFather Name:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_grandfather" required type="text" value="{{ $marriageregistration->groom_grandfather ?? '' }}" placeholder="Groom GrandFather Name">
									</td>
									<td align="right" class="groom-style1">Bride GrandFather Name:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_grandfather" required type="text" value="{{ $marriageregistration->bride_grandfather ?? '' }}" placeholder="Bride GrandFather Name">
									</td>
								</tr>   
								<tr>
									<td align="right" class="groom-style1">Groom GrandFather Name Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="groom_grandfather_nepali" required type="text" value="{{ $marriageregistration->groom_grandfather_nepali ?? '' }}" placeholder="Groom GrandFather Name Nepali">
									</td>
									<td align="right" class="groom-style1">Bride GrandFather Name Nepali:</td>
									<td class="groom-style2">
										<input class="form-control input-sm" name="bride_grandfather_nepali" required type="text" value="{{ $marriageregistration->bride_grandfather_nepali ?? '' }}" placeholder="Bride GrandFather Name Nepali">
									</td>
								</tr>    
							</table>


						</div>
						<div class="panel-footer footer">
							<button type="submit" class="btn btn-social btn-foursquare">
								<i class="fa fa-save"></i>Update 
							</button>

							<a class="btn btn-social btn-foursquare" href="/admin/marriage"> <i class="fa fa-times"></i> Cancel </a>

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

<script type="text/javascript">

	$(function() {
		$('.datepicker').datetimepicker({
			format: 'YYYY-MM-DD',
			sideBySide: true,
			allowInputToggle: true
		});

	});

</script>

<script type="text/javascript">
	$(document).ready(function() {
		var readURLGroom = function(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('.groom-pic').attr('src', e.target.result);
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
