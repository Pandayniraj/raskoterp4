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
                        <p><strong style="color:red !important; text-align:center;">रास्कोट नगरपालिका</strong></p>
                        <p><strong style="color:red !important; text-align:center;">नगर कार्यपालिकाको कार्यालय</strong></p>
                        <p><strong style="color:red !important; text-align:center;">आर.सी.पी. ५, कालिकोट, कर्णाली प्रदेश, नेपाल</strong></p>
                        <p><strong style="color:red !important; text-align:center;">(योजना अनुगमन तथा मूल्यांकन शाखा)</strong></p>
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
                 <b>प.सं. :{{ $fiscalyear->fiscal_year }} </b> <span style="padding-left:200px;"> मिति : {{ \App\Helpers\TaskHelper::getNepaliDate($currentdate) }}</span><br>
                 <b>च.नं. :</b> 
                </div>
                
                <!-- /.col -->
            </div>
            <div class="row" style="margin-top:15px">
                <p style="text-align: center;font-weight:600;">विषय  :- खाता संचालक परिवर्तन सम्वन्धम । </p>
            </div>
            <div class="row" style="margin-top: 10px;margin-left:2px">
                 <b>श्री प्रवन्धक ज्यू</b><br>
                 <b>{{ $plandetail->NameOfBank }}</b><br>
                 <b>आर.सी.पी. ५, कालिकोट</b> 
                <!-- /.col -->
            </div>
            <div class="row" style="margin-left: 10px;margin-top:20px">
               <div class="col-md-12"> <p style="text-indent:3em;">   प्रस्तुत विषयमा यस रास्कोट नगरपालिका वडा नं स्थित <strong>{{ $plandetail->Name }}</strong> नाममा त्यस वैकमा तपसिल वमोजिमको
                खाता नं. <strong>{{ $plandetail->BankAccountNo }}</strong> पदाधिकारीहरुको संयुक्त दस्तखतवाट खाता संचालन हुदै आएकोमा उल्लेखित उपभोक्ता समितिको पदाधिकारीहरु हेरफेर
                भई पुन वैक खाता संचालकहरु परिवर्तन गर्नु पर्ने भएको हूदा निम्नानुसारका पदाधिकारीहरुको संयुक्त दस्तखतवाट खाता संचालन हुने व्यवस्था
                मिलाई दिनु सिफारिस साथ अनुरोध छ । </p></div>
            </div>    
            <div class="row" style="margin-top:20px; margin-left:5px;">
                <b style="font-size: 15px;">तपसिल</b><br>
                <b>पहिलेको खाता संचालक</b><br>
                <span>अध्यक्ष : ........</span><br>
                <span>सचिव :- ...........</span><br>
                <span>कोषाध्यक्ष :- .....................</span><br><br>

                <b>हालको खाता संचालक</b><br>
                <span>अध्यक्ष : <strong>{{ $designation[1][0]->Name ?? '' }}</strong></span><br>
                <span>सचिव :- <strong>{{ $designation[2][0]->Name ?? '' }}</strong>...........</span><br>
                <span>कोषाध्यक्ष :- <strong>{{ $designation[3][0]->Name ?? '' }}</strong>.....................</span><br> 
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                <span>.....................................</span></div>
               <div class="col-md-12"  style="text-align: center"> <b>प्रमुख प्रशासकीय अधिकृत</b></div>
            </div>
    </div><!-- /.col -->

</body>
