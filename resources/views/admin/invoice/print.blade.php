<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ \Auth::user()->organization->organization_name }} | INVOICE</title>

    <!-- block from searh engines -->
    <meta name="robots" content="noindex">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Set a meta reference to the CSRF token for use in AJAX request -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons 4.7.0 -->
    <link href="{{ asset("/bower_components/admin-lte/font-awesome/css/all.css") }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.1 -->
    <link href="{{ asset("/bower_components/admin-lte/ionicons/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />

    <!-- Application CSS-->


<style type="text/css">
    @media print {
   body {
      -webkit-print-color-adjust: exact;
   }
}

.vendorListHeading th {
   background-color: #1a4567 !important;
   color: white !important;
}

table{
    border: 1px solid dotted !important;
    font-size: 14px !important;
    padding-top: 2px !important; /*cancels out browser's default cell padding*/
    padding-bottom: 2px !important; /*cancels out browser's default cell padding*/
}

td{
  border: 1px dotted #999 !important;
  padding-top: 2px !important; /*cancels out browser's default cell padding*/
  padding-bottom: 2px !important; /*cancels out browser's default cell padding*/
}

th{
  border: 1px dotted #999 !important;
    padding-top: 2px !important; /*cancels out browser's default cell padding*/
  padding-bottom: 2px !important; /*cancels out browser's default cell padding*/
}

.invoice-col{
      /*border: 1px dotted #1a4567 !important;*/
      font-size: 13px !important;
      margin-bottom: -20px !important;
}

 @page {
    size: auto;
    margin: 0;
  }

  body{
    padding-left: 1.3cm;
    padding-right: 1.3cm;
    padding-top: 1.3cm;
  }

  @media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}
</style>



</head>


<body onload="window.print();" cz-shortcut-listen="true" class="skin-blue sidebar-mini">

    <?php

        $loop = $print_no > 0 ? 1: 3;

     ?>

    <div class='wrapper'>


        @foreach(range(1,$loop) as $key)
        @if($key >= 2) <div class="pagebreak"> </div>@endif
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <div class="col-xs-3">
                          <img src="{{ '/org/'.auth()->user()->organization->logo }}">

                        </div>
                        <div class="col-xs-9">
                            <span class="pull-right">
                                <span>@if($print_no == 0 && $key <= 1) TAX Invoice

                                      @else Invoice @endif
                                </span>
                            </span>
                        </div>
                        <hr/>
                    </h2>

                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-xs-12">
                <div class="col-sm-4 invoice-col">

                    <address>
                        <span style="font-size: 15px; font-weight: bold" >{{ \Auth::user()->organization->organization_name }} </span><br>
                        {{ env('APP_ADDRESS1') }}<br>
                        {{ env('APP_ADDRESS2') }}<br>
                        Phone: {{ env('APP_PHONE1') }}<br>
                        Email: {{ env('APP_EMAIL') }}<br>
                        Seller's PAN: {{ \Auth::user()->organization->vat_id }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To:  Customer: #0{{ $ord->client_id }}
                    <address>

                       <span style="font-size: 15px; font-weight: bold"> {{ $ord->client->name }}</span><br />
                        Address: {!! nl2br($ord->address ) !!}<br>
                        Contact: {{ $ord->client->phone }}<br />
                        Cust. PAN: {!! $ord->client->vat !!}<br/>
                        <strong>Contact Person: {{ $ord->name }}</strong><br>
                       
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Bill No:</b> DTC/{{$ord->fiscal_year}}/00{{ $ord->bill_no }}
                    <br>


                    <b>Bill Date:</b> {{ TaskHelper::getNepaliDate($ord->bill_date) }}({{ $ord->bill_date }})<br>

                    <?php $timestamp = strtotime($ord->created_at) ?>
                    <b>Due:</b> {{ TaskHelper::getNepaliDate($ord->due_date) }}({{ $ord->due_date }})<br>
                    <b>Payment Terms :</b> {{ $ord->terms }} Days<br>
                    <b>Sales Order # :</b> {{ $ord->sales_order_no }} <br>
                    <b>Challan # :</b> @if($ord->challan_no) {{FinanceHelper::cur_fisc_yr()->fiscal_year}}-0{!! $ord->challan_no !!} @else 0 @endif


                    @if($print_no > 0)<br>
                    <b> Copy of original {{ $print_no }}</b>
                    @endif

                </div>
                <!-- /.col -->
            </div>
            </div>
            <!-- /.row -->
            <br/>
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-gray">
                            <tr class="vendorListHeading">
                                <th>S. No</th>
                                <th>Particulars</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Unit</th>
                                <th>Discount</th>
                                <th>Vat</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderDetails as $odk => $odv)
                            <tr>
                                <td>{{$odk+1}} </td>
                               @if($odv->is_inventory == 1)
                                <td>{{ $odv->product->name }}</td>
                                @elseif($odv->is_inventory == 0)
                                <td>{{ $odv->description }}</td>
                                @endif
                                <td>{{ number_format($odv->quantity,2) }}</td>
                                <td>{{ number_format($odv->price,2) }}</td>
                                <td>{{ $odv->units->name }}</td>
                                <td>{{ number_format($odv->dis_amount,2) }}</td>
                                <td>{{ number_format($odv->tax_amount,2) }}</td>
                                <td>{{ env('APP_CURRENCY').' '.number_format($odv->total,2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

 <?php

 function getPaisa($number) 

{   



    $no = round($number);

    $decimal = round($number - ($no = floor($number)), 2) * 100;    

    $words = array(

        0 => '',

        1 => 'One',

        2 => 'Two',

        3 => 'Three',

        4 => 'Four',

        5 => 'Five',

        6 => 'Six',

        7 => 'Seven',

        8 => 'Eight',

        9 => 'Nine',

        10 => 'Ten',

        11 => 'Eleven',

        12 => 'Twelve',

        13 => 'Thirteen',

        14 => 'Fourteen',

        15 => 'Fifteen',

        16 => 'Sixteen',

        17 => 'Seventeen',

        18 => 'Eighteen',

        19 => 'Nineteen',

        20 => 'Twenty',

        30 => 'Thirty',

        40 => 'Forty',

        50 => 'Fifty',

        60 => 'Sixty',

        70 => 'Seventy',

        80 => 'Eighty',

        90 => 'Ninety');

 

    $paise = ($decimal) ?  ' and ' .($words[$decimal - $decimal%10]) ." " .($words[$decimal%10]) .' Paisa'  : '';

    return $paise;

}




function numberFomatter($number)

{

    $constnum = $number;

   $no = floor($number);

   $point = round($number - $no, 2) * 100;

   $hundred = null;

   $digits_1 = strlen($no);

   $i = 0;

   $str = array();

   $words = array('0' => '', '1' => 'one', 

    '2' => 'two',

    '3' => 'three', 

    '4' => 'four', '5' => 'five', '6' => 'six',

    '7' => 'seven', '8' => 'eight', '9' => 'nine',

    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',

    '13' => 'thirteen', '14' => 'fourteen',

    '15' => 'fifteen', '16' => 'sixteen', 

    '17' => 'seventeen',

    '18' => 'eighteen', 

    '19' =>'nineteen', 

    '20' => 'twenty',

    '30' => 'thirty', 

    '40' => 'forty', 

    '50' => 'fifty',

    '60' => 'sixty', 

    '70' => 'seventy',

    '80' => 'eighty', 

    '90' => 'ninety');

   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');

   while ($i < $digits_1) {

     $divider = ($i == 2) ? 10 : 100;

     $number = floor($no % $divider);

     $no = floor($no / $divider);

     $i += ($divider == 10) ? 1 : 2;

     if ($number) {

        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

        $hundred = ($counter == 1 && $str[0]) ? '' : null;

        $str [] = ($number < 21) ? $words[$number] .

            " " . $digits[$counter] . $plural . " " . $hundred

            :

            $words[floor($number / 10) * 10]

            . " " . $words[$number % 10] . " "

            . $digits[$counter] . $plural . " " . $hundred;

     } else $str[] = null;

  }

  $str = array_reverse($str);

  $result = implode('', $str);

  $points = getPaisa($constnum);

  return $result . ' Rupees' .$points;
}


 ?>


            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-4" style="font-size: 11px !important">
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 0px;text-transform: capitalize;">
                        In Words: <?php
                        echo numberFomatter($ord->total_amount);
                        ?>
                    </p>

                    <br/><br/><br/><br/><br/>
                    {{ nl2br($ord->comment) }}<br/>
                    Printed by: {{\Auth::user()->username}}<br/>
                    Printed Time: {{ date("F j, Y, g:i a") }} <br/>
                    E. & O E
                    <br/>
                </div>
                <!-- /.col -->
                <div class="col-xs-8" style="margin-top: -10px !important">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:70%">Amount:</th>
                                    <td>{{ env('APP_CURRENCY').' '. number_format($ord->total_amount,2) }}</td>
                                </tr>
                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Discount:</th>
                                    <numbertd>{{ env('APP_CURRENCY').' '. number_format($ord->discount_amount,2) }}</td>
                                </tr>

                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Non Taxable Amount:</th>
                                    <td>{{ env('APP_CURRENCY').' '. number_format($ord->non_taxable_amount,2) }}</td>
                                </tr>
                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Taxable Amount:</th>
                                <td>{{ env('APP_CURRENCY').' '. number_format($ord->taxable_amount,2) }}</td>
                                </tr>
                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Tax Amount:</th>
                                    <td>{{ env('APP_CURRENCY').' '. number_format($ord->tax_amount,2) }}</td>
                                </tr>
                                 <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Total Amount:</th>
                                    <td><b>{{ env('APP_CURRENCY').' '. number_format($ord->total_amount,2) }}</b></td>
                                </tr>



                            </tbody>
                        </table>


                        <table class="table">
                            <tbody>
                            <tr style="padding:0px; margin:0px;">


                                    <th style="width:55%">
                                        For {{env('APP_COMPANY')}}<br/><br/><br><br>

                                        <br>______________________<br><span style="text-indent: 10px;">
                                    &nbsp;&nbsp;Authorised Signatory</span>

                                </th>
                                <td>
                                    Seal
                                </td>

                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- /.col -->
            </div>


<div class="row">
    <div class="col-xs-12">
    <p class="text-muted" style="margin-top: -5px !important; font-size: 11px !important; text-align: center !important">

                        <b>Thank you for choosing {{ env('APP_COMPANY')}}. If you have any query about this invoice. Please contact us.</b>
                    </p>
                </div>
</div>
            <!-- /.row -->

        </section>

        @endforeach

    </div><!-- /.col -->

</body>
