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
            <div id="CustomOrderFields" style="display: none;">
                <table class="table">
                    <tbody id="more-custom-tr">
                        <tr>

                            <td class="col-sm-1">
                                <input type="text" class="form-control" name="symbol_no[]" placeholder="Symbol No"  value="0"  step='any' autocomplete="off">
                            </td>

                            <td class="col-sm-2">
                                <input type="text" class="form-control product" name="description[]" value="" placeholder="Description" autocomplete="off">
                            </td>


                            <td class="col-sm-1">
                                <input type="text" class="form-control quantity" name="used_as[]" placeholder="Prayojan"  value="" required="required" autocomplete="off">
                            </td>
                            <td class="col-sm-1">
                                <input type="text" class="form-control amount" name="amount[]" placeholder="Amount"  value="0"  step='any' autocomplete="off">
                            </td>


                            <td class="col-sm-1">
                                <select class="form-control input-sm unit" name="unit[]" >
                                    <option disabled selected>Received Via</option>

                                    <option value="cash"> Cash </option>

                                    <option value="check"> Check </option>
                                    <option value="bank"> Bank </option>
                                    <option value="voucher"> Voucher </option>
                                    <option value="electronic"> Electronic </option>
                                    <option value="other"> Other </option>

                                </select>
                            </td>

                            <td class="col-sm-1">
                                <input type="text" class="form-control input-sm total" name="check_no[]" placeholder="Check No or Other Detail" value="" style="float:left; width:80%;">
                                <a href="javascript:void(1);" style="width: 10%;">
                                    <i class="remove-this btn btn-xs btn-danger icon fa fa-trash deletable" style="float: right; color: #fff;"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="col-md-12">
                <div class="">
                    <form method="POST" action="{{route('admin.localtax.update',$localtax->id)}}">
                        {{ csrf_field() }}

                        <div class="">

                         <div class="clearfix"></div>
                         <div class="col-md-12">


                            <div class="col-md-3 form-group" style="">
                                <label for="user_id"> रसिद नं.</label>
                                <input class="form-control input-sm " name="receipt_no" required type="text" placeholder="रसिद नं." value="{{ $localtax->receipt_no ?? ''  }}">
                            </div>

                            <div class="col-md-3 form-group" style="">
                                <label for="user_id"> इलेक्ट्रोनिक लेनदेन नं.</label>
                                <input class="form-control input-sm " name="electronic_trans_no" placeholder="इलेक्ट्रोनिक लेनदेन नं." value="{{ $localtax->electronic_trans_no ?? ''  }}" required type="text">
                            </div>

                            <div class="col-md-3 form-group" style="">
                                <label for="user_id"> कार्यालयको कोड नं.</label>
                                <input class="form-control input-sm " name="officer_code_number" placeholder="कार्यालयको कोड नं." value="{{ $localtax->officer_code_number ?? ''  }}" required type="text">
                            </div>

                            <div class="col-md-3 form-group" style="">
                                <label for="user_id"> करदाताको नाम</label>
                                <input class="form-control input-sm " name="customer_name" required type="text" placeholder="करदाताको नाम" value="{{ $localtax->customer_name ?? ''  }}">
                            </div>

                            <div class="col-md-3 form-group" style="">
                                <label for="user_id"> मिति</label>
                                <input class="form-control input-sm datepicker" name="date" required type="text" placeholder="मिति" value="{{ $localtax->date ?? ''  }}">
                            </div>



                            <div class="col-md-3 form-group" style="">
                                <label for="user_id">प्रवेश क्लर्क</label>
                                <select required class="form-control input-sm" name="entered_by" required id="">
                                    <option selected disabled >Select Person
                                    </option>
                                    @foreach($authority as $u)
                                    <option {{ $localtax->entered_by == $u->id ? 'selected':'' }} value="{{$u->id}}" >{{$u->username}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>




                        <div class="clearfix"></div><br/><br/>

                        <div class="col-md-12">
                            <a href="javascript:void(0)" class="btn btn-primary btn-xs" id="addCustomMore" style="float: right;margin-left:8px">
                                <i class="fa fa-plus"></i> <span>Add Items</span>
                            </a>
                        </div>


                        <hr/>
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-info">
                                    <th>प्रतीक नं </th>
                                    <th>वस्तु विवरण </th>
                                    <th>प्रयोजन *</th>
                                    <th>रकम</th>
                                    <th>मार्फत प्राप्त भएको</th>
                                    <th>जाँच # /अन्य</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="multipleDiv">

                                </tr>
                                @if(isset($localtaxdetail) && $localtaxdetail)
                                @foreach($localtaxdetail as $ld)
                                <tr>

                                    <td class="col-sm-1">
                                        <input type="text" class="form-control" name="symbol_no[]" placeholder="Symbol No"  value="{{ $ld->symbol_no ?? '' }}"  step='any' autocomplete="off">
                                    </td>

                                    <td class="col-sm-2">
                                        <input type="text" class="form-control product" name="description[]" value="{{ $ld->description ?? '' }}" placeholder="Description" autocomplete="off">
                                    </td>


                                    <td class="col-sm-1">
                                        <input type="text" class="form-control quantity" name="used_as[]" placeholder="Prayojan"  value="{{ $ld->used_as ?? '' }}" required="required" autocomplete="off">
                                    </td>
                                    <td class="col-sm-1">
                                        <input type="text" class="form-control amount" name="amount[]" placeholder="Amount"  value="{{ $ld->amount ?? '' }}"  step='any' autocomplete="off">
                                    </td>


                                    <td class="col-sm-1">
                                        <select class="form-control input-sm unit" name="unit[]" >
                                            <option disabled selected>Received Via</option>

                                            <option value="cash" {{ $ld->received_via == 'cash' ? 'selected' : '' }} > Cash </option>

                                            <option value="check" {{ $ld->received_via == 'check' ? 'selected' : '' }} > Check </option>
                                            <option value="bank" {{ $ld->received_via == 'bank' ? 'selected' : '' }} > Bank </option>
                                            <option value="voucher" {{ $ld->received_via == 'voucher' ? 'selected' : '' }} > Voucher </option>
                                            <option value="electronic" {{ $ld->received_via == 'electronic' ? 'selected' : '' }} > Electronic </option>
                                            <option value="other" {{ $ld->received_via == 'other' ? 'selected' : '' }} > Other </option>

                                        </select>
                                    </td>

                                    <td class="col-sm-1">
                                        <input type="text" class="form-control input-sm total" name="check_no[]" placeholder="Check No or Other Detail" value="{{ $ld->check_no ?? '' }}" style="float:left; width:80%;">
                                        <a href="javascript:void(1);" style="width: 10%;">
                                            <i class="remove-this btn btn-xs btn-danger icon fa fa-trash deletable" style="float: right; color: #fff;"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <td colspan="3" class="text-right">
                                    कुल:
                                    </td>
                                    <td>
                                       <input type="hidden" name="total_amount" class="total_amount" value="{{ $localtax->total_amount ?? ''  }}" required >
                                       <span class="total_amount_text">0</span>
                                   </td>
                               </tr>
                           </tbody>
                       </table>

                       <br/>

                       <div class="box">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <br>
                                <label for="comment">टिप्पणीहरू </label>
                                <small class="text-muted"></small>
                                <textarea rows="6" class="form-control TextBox comment" name="remarks">{{ $localtax->remarks ?? ''  }}</textarea>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="panel-footer footer">
                    <button type="submit" class="btn btn-social btn-foursquare">
                        <i class="fa fa-save"></i>Update {{ $_GET['type']}}
                    </button>

                    <a class="btn btn-social btn-foursquare" href="/admin/requisition"> <i class="fa fa-times"></i> Cancel </a>

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

<script>

    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
  }


  
  $("#addCustomMore").on("click", function () {

    $(".multipleDiv").after($('#CustomOrderFields #more-custom-tr').html());
    $(".multipleDiv").next('tr').find('select').select2({ width: '100%' });

    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD',
        sideBySide: true,
        allowInputToggle: true
    });
});

</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
    $(function() {
        $('.datepicker').datetimepicker({
          format: 'YYYY-MM-DD',
          sideBySide: true,
          allowInputToggle: true
      });

    });
    $(function() {
        $('.required_by').datetimepicker({
          format: 'YYYY-MM-DD',
          sideBySide: true,
          allowInputToggle: true
      });

    });


    var total = 0;
    total = calcTotal();
    $('.total_amount_text').text(total);
    $('.total_amount').val(total);
    $(document).on('keyup', '.amount', function () {
        var total = 0;
        total = calcTotal();
        $('.total_amount_text').text(total);
        $('.total_amount').val(total);
    });
    $(document).on('click', '.amount', function () {
        $(this).focus();
    });
    $(document).on('click', '.remove-this', function () {
        $(this).parent().parent().parent().remove();
        var total = 0;
        total = calcTotal();
        $('.total_amount_text').text(total);
        $('.total_amount').val(total);
    });
    function calcTotal(){
        var total = 0;
        $('.amount').each(function(){
            var amount = $(this).val();
            total = parseInt(total) + parseInt(amount);
        });
        return total;
    }


</script>

<script type="text/javascript">

    $(document).on('change', '.product_id', function () {
        console.log('hell')
        var parentDiv = $(this).parent().parent();
        $.ajax(
        {
            url: "/admin/getStockUnit",
            data: {product_id: $(this).val()},
            dataType: "json",
            success: function (data) {
                var unit = data.unit;
                var stock = data.stock;
                console.log(unit)
                parentDiv.find('.unit').val(unit).change()
                parentDiv.find('.stock').val(stock)
            }
        });

    });


    $(document).on('change','#source_id',function(){

        $('.multipleDiv').nextAll('tr').remove();

    });

</script>
@endsection
