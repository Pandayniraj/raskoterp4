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
       
            <div class="row" style="margin-top: 10px;">
                <div class="col-xs-12 table-responsive">
                 <b>प.सं. :{{ $fiscalyear->fiscal_year ?? '' }}</b> <span style="padding-left:200px;"> मिति : {{ date('Y-m-d',strtotime($planagreement->agreementdate)) }}</span><br>
                 <b>च.नं. :</b> 
                </div>
                
                <!-- /.col -->
            </div>
            <div class="row" style="margin-top:15px">
                <p style="text-align: center;font-weight:600;">विषय  :-योजना सम्झौता गरी कार्यादेश दिइएको बारे । </p>
            </div>
            <?php
                $originaltext= $plandetail->Name;
                $replaced_value=str_replace("उपभोक्ता समिती","", $originaltext);
            ?>
            <div class="row" style="margin-top: 10px;margin-left:2px">
                 <b>श्री <strong>{{  $replaced_value }}</strong></b><br>
                 <b>{{ $plandetail->Address ?? '' }}</b> 
                <!-- /.col -->
            </div>
            <div class="row" style="margin-left: 10px;margin-top:20px">
               <div class="col-md-12"> <p style="text-indent:3em;">   प्रस्तुत विषयमा <strong>{{  $replaced_value }}</strong>, नगरकार्यपालिको कार्यालयबाट तपशिलका विवरण बमो जिम योजना सम्झौता गरी योजना
                सञ्चालनको ला गि कार्यादेश दिइएको छ । साथै योजनाका कागजातहरु यसैपत्रसाथ सम्लग्न राखी पठाइएको छ । नगरपालिका, सम्वन्धित वडा
                कार्यलय तथा खटिएका प्राविधिकको रेखदेख एवं सुपरीवेक्षणमा लागत अनुमान वमोजिमको कार्य तोकिएको गुणस्तर र परिमाणमा सम्पन्न गर्नुहुन
                जानकारी गराइन्छ । </p></div>
            </div>   
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-responsive">
                        <tr>
                            <th style="width:10%">सि.न</th>
                            <th style="wdith:65%">विषय/विवरण</th>
                            <th style="width:25%">रकम</th>
                        </tr> 
                        <tbody>
                            <tr>
                                <td>१</td>
                                <td>आर्थिक वर्ष : <strong>{{ $fiscalyear->fiscal_year ?? '' }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>२</td>
                                <td>आयोजनाको नाम : {{ $replaced_value }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>३</td>
                                <td>ठेगान : <strong>{{ $plandetail->Address ?? '' }}</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>४</td>
                                <td>कार्यक्रमको नाम : </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>५</td>
                                <td>उपभोक्ता समितिको नाम : <strong>{{ $plandetail->Name }}</strong> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>६</td>
                                <td>उपभोक्ता समितिको बैक खाता न : <strong>{{ $plandetail->BankAccountNo ?? '' }}</strong> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>७</td>
                                <td>उपभोक्ता समितिसंग सम्झौता मित : <strong>{{ date('Y-m-d',strtotime($planagreement->agreementdate)) }}</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>८</td>
                                <td>उपभोक्ता समितिको निर्णय मित : <strong>{{ date('Y-m-d',strtotime($planagreement->startdate)) }}</strong> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>९</td>
                                <td>कार्यालयबाट स्वीकृत रकम : </td>
                                <td><strong>{{  $costdetail->grantamt ?? 0   }}</strong></td>
                            </tr>
                            <tr>
                                <td>१०</td>
                                <td>अन्य निकायबाट प्राप्त रकम : </td>
                                <td><strong>{{ $costdetail->othergrant ?? 0 }}</strong></td>
                            </tr>
                            <tr>
                                <td>११</td>
                                <td>अन्य साझेदारी रकम : </td>
                                <td><strong>{{ $costdetail->partnershipamt ?? 0 }}</strong></td>
                            </tr>
                            <tr>
                                <td>१२</td>
                                <td>समितिबाट नगद साझेदारी रकम : </td>
                                <td><strong>{{ $costdetail->partnershiporg ?? 0 }}</strong></td>
                            </tr>
                            <tr>
                                <td>१३</td>
                                <td>कुल रकम : </td>
                                <td><strong>{{$costdetail->totalcontingency ?? 0 }}</strong></td>
                            </tr>
                            <tr>
                                <td>१४</td>
                                <td>कन्टिजेन्सी कट्टी रकम (4.00%)  : </td>
                                <td><strong>{{ $costdetail->contingencyamt ?? 0 }}</strong></td>
                            </tr>
                            <tr>
                                <td>१५</td>
                                <td>कार्यालयले बेहोर्ने कुल रकम : </td>
                                <td><strong>{{ $costdetail->amtbyoffice }}</strong></td>
                            </tr>
                            <tr>
                                <td>१६</td>
                                <td>समितिबाट जनश्रमदान रकम : </td>
                                <td><strong>{{ $costdetail->labordonation ?? 0 }}</strong></td>
                            </tr>
                            <tr>
                                <td> १७</td>
                                <td> कुल लागत अनुमान रकम  : </td>
                                <td><strong>{{ $costdetail->totalcost ?? 0 }}</strong></td>
                            </tr>

                        </tbody>
                    </table>
                </div>   
            </div> 
            <div class="row" style="margin-top:15px;">
                <span>...............................</span><br>
                <p style="margin-left:10px">जवान सिंह वम, 
                    नि. प्रमुख
                    प्रशासकिय अधिकृत</p><br>
                    <p style="margin-top:10px;margin-left:10px"> वोधार्थ –: श्री प्राबिधिक शाखा साईट प्राविधिकतोकी इष्टिमेट डिजाइन अनुसारको गुणस्तर सुनिशित गर्नुहुन
                        र सोको जानकारी गराउन हुन |</p>
            </div>
    </div><!-- /.col -->

</body>
