<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">

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
      font-size: 5px !important;
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

.billfontsize{
    font-size: 11px !important;
}
</style>



</head>


<body onload="window.print();" cz-shortcut-listen="true" class="skin-blue sidebar-mini">

    <div class='wrapper'>
            <!-- title row -->
            <div class="print-head">                
                <div class="img-head">
                    <img src="{{ '/images/nepal.jpg'}}" style="height:100px; width:150px">

                
                    <div class="top-head" style="text-align: center; margin-top: -95px;">
                        <p><strong style="color:red !important; text-align:center;">????????????????????? ???????????????????????????</strong></p>
                        <p><strong style="color:red !important; text-align:center;">????????? ??????????????????????????????????????? ????????????????????????</strong></p>
                        <p><strong style="color:red !important; text-align:center;">??????.??????.??????. ???, ?????????????????????, ????????????????????? ??????????????????, ???????????????</strong></p>
                        <p><strong style="color:red !important; text-align:center;">(??????????????? ?????????????????? ????????? ??????????????????????????? ????????????)</strong></p>
                    </div>  
                    <!-- /.col -->
                </div>
            </div>
            <hr>
            @php
                $currentdate= date('Y-m-d', strtotime(\Carbon\Carbon::now()));
            @endphp
            <div class="row" style="margin-top: 10px;">
                <div class="col-xs-12 table-responsive">
                 <b>???.??????. : {{ $fiscalyear->fiscal_year }}</b> <span style="padding-left:200px;"> ???????????? : {{ \App\Helpers\TaskHelper::getNepaliDate($currentdate) }}</span><br>
                 <b>???.??????. :</b> 
                </div>
                
                <!-- /.col -->
            </div>
            <div class="row" style="margin-top:15px">
                <p style="text-align: center;font-weight:600;">????????????  :- : ???????????? ???????????? ???????????????????????? ???????????????????????? ??? </p>
            </div>
            <div class="row" style="margin-top: 10px;margin-left:2px">
                 <b>???????????? ???????????????????????? ????????????</b><br>
                 <b>{{ $plandetail->NameOfBank}}Bank</b><br>
                 <b>??????.??????.??????. ???, ?????????????????????</b> 
                <!-- /.col -->
            </div>
            <div class="row" style="margin-left: 10px;margin-top:20px">
               <div class="col-md-12"> <p style="text-indent:3em;">   ???????????????????????? ?????????????????? ?????? ????????????????????? ??????????????????????????? ????????? ?????? ??????????????? <strong>{{ $plandetail->Name }}</strong> ??????????????? ???????????? ??????????????? ??????????????? ????????????????????????
                ?????????????????????????????????????????? ????????????????????? ??????????????????????????? ???????????? ????????? ???????????? ?????????????????? ????????????????????? ????????? ????????????????????? ????????? ?????????????????? ??? ???
                 </p></div>
            </div>    
            <div class="row" style="margin-top:20px; margin-left:5px;">
                <b>???????????????</b><br>
                <span>????????????????????? : <strong>{{ $designation[1][0]->Name ?? '' }}</strong></span><br>
                <span>???????????? :-<strong>{{ $designation[2][0]->Name ?? '' }}</strong></span><br>
                <span>?????????????????????????????? :-<strong>{{ $designation[3][0]->Name ?? '' }}</strong></span><br>
                <span>????????????????????? <strong>?????? {{ $amount->appropriationamt ?? '' }}</strong></span><br>
                <span> ????????????????????? ??????????????? <strong>{{ date('Y-m-d',strtotime($planagreement->agreementdate)) ?? '' }}</strong></span><br> 
            </div>
            <div class="row" style="margin-top:35px; margin-left:5px;">    
                <span style="margin-top:10px">....................................</span> <span style=" margin-left:190px;margin- top:10px">...........................</span><br>
                <b style="text-align:center;">??????. ?????????????????? ??????????????????????????? ??????????????????</b>  <b style=" margin-left:105px;">?????????????????? ?????????</b>
            </div>
    </div><!-- /.col -->

</body>
