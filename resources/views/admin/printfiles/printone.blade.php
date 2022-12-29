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
                        <p><strong style="text-align: center;">योजना सम्झौता फारम</strong></p>
                    </div>  
                    <!-- /.col -->
                </div>
            </div>
       
            <div class="row" style="margin-top: 10px;">
                <div class="col-xs-12">
                    <p><strong>१. सम्झौता गर्ने पक्ष र योजना:</strong></p>
                    <p style="text-indent: 1.5em"><strong>(क). उपभोक्ता समिती / समुदायमा आधारित संस्था / लाभग्राही समूह(श्रम रोजगार बैंक)को विवरण:</strong></p> 
                    <p style="text-indent: 2.5em">१. नाम: <strong>{{ $plandetail->Name ?? '' }}</strong></p>
                    <p style="text-indent: 2.5em">२. ठेगाना: <strong>{{ $plandetail->Address ?? '' }}</strong></p>
                </div>
                <?php
                    $originaltext= $plandetail->Name;
                    $replaced_value=str_replace("उपभोक्ता समिती","", $originaltext);
                ?>
                <div class="col-xs-12" style="margin-top:10px">
                    <p style="text-indent: 1.5em"><strong>(ख). आयोजनाको बिबरण:</strong></p>
                    <p style="text-indent: 2.5em">१. नाम: <strong>{{ $replaced_value ?? '' }}</strong></p>
                    <p style="text-indent: 2.5em">२. ठेगाना: <strong>{{ $plandetail->Address ?? '' }}</strong></p>
                    <p style="text-indent: 2.5em">३. उद्देश्य:<strong>{{ $plan->purpose ??'' }}</strong></p>
                    <p style="text-indent: 2.5em">४. आयोजना स्वीकृत गर्ने निकाय: <strong>रास्कोट नगरपालिक</strong></p>
                    <p style="text-indent: 2.5em">५. आयोजना शुरू हुने मिति: <strong>{{ date('Y-m-d', strtotime($planagreement->startdate)) ?? '' }}</strong></p>
                    <p style="text-indent: 2.5em">६. आयोजना सम्पन्न हुने मिति: <strong>{{ date('Y-m-d', strtotime($planagreement->completiondate)) ?? '' }}</strong></p>
                </div>
                <div class="col-xs-12" style="width:90%">
                    <p><strong>२. आयोजना लागत सम्बन्धी विवरण: </strong></p>
                    <p style="text-indent: 1.5em">क. आयोजनाको लागत अनुमान : <strong>रू. {{ $costdetail->totalcost ?? 0 }}</strong></p>
                    <p style="text-indent: 1.5em"><strong>ख. लागत व्यहोर्ने स्रोतहरू:</strong></p>
                    <table class="table table-bordered" style="width=90%;margin-left:20px;">
                    <tr>
                        <th style="width:65%">विवरण</th>
                        <th style="width:35%">रकम</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td>कार्यालयबाट स्वीकृत रकम </td>
                            <td><strong>{{$costdetail->grantamt ?? 0  }}</strong></td>
                        </tr>
                        <tr>
                            <td>अन्य निकायबाट प्राप्त रकम </td>
                            <td><strong>{{ $costdetail->othergrant ?? 0 }}</strong></td>
                        </tr>
                        <tr>
                            <td>अन्य साझेदारी रकम :</td>
                            <td>{{ $costdetail->partnershipamt ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>समितिबाट नगद साझेदारी रकम</td>
                            <td><strong>{{$costdetail->partnershiporg ?? 0  }}</strong></td>
                        </tr>
                        <tr>
                            <td>कन्टिजेन्सी सहितको कुल रकम </td>
                            <td><strong>{{$costdetail->totalcontingency ?? 0 }}</strong></td>
                        </tr>
                        <tr>
                            <td>कन्टिजेन्सी कट्टी रकम</td>
                            <td><strong>{{ $costdetail->contingencyamt ?? 0 }}</strong></td>
                        </tr>
                        <tr>
                            <td>मर्मत सम्भार/वातावरण संरक्षण कट्टी रकम</td>
                            <td><strong>{{ $costdetail->grantamt ?? 0 }}</strong></td>
                        </tr>
                        <tr>
                            <td>कार्यालयले बेहोर्ने कुल रकम</td>
                            <td><strong>{{ $costdetail->amtbyoffice ?? 0 }}</strong></td>
                        </tr>
                        <tr>
                            <td>समितिबाट जनश्रमदान रकम</td>
                            <td><strong>{{ $costdetail->labordonation ?? 0 }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>कुल लागत अनुमान रकम</strong></td>
                            <td><strong>{{ $costdetail->totalcost ?? 0 }}</strong></td>
                        </tr>
                    </tbody>
                    </table>   
                    
                    <p style="text-indent: 1.5em"><strong>ग. निर्माण समाग्रीहरुको बिबरण:</strong></p>
                    <table class="table table-bordered table-dark" style="width=90%;margin-left:20px;">
                        <tr>
                            <th style="width:20%">स्रोत </th>
                            <th style="width:45%">सामाग्रीको नाम</th>
                            <th style="width:20%">परिमाण</th>
                            <th style="width:10%">एकाई</th>
                        </tr>
                        <tbody>
                        </tbody>
                    </table>

                    <p style="text-indent: 1.5em"><strong>घ. आयोजनाबाट लाभान्वित हुने:</strong></p>
                    <p style="text-indent: 2.5em">१. घरपरिवार संख्या: <strong>{{ $planagreement->householdnumber ?? 0 }}</strong></p>
                    <p style="text-indent: 2.5em">२. जनसंख्या: <strong>{{ $planagreement->population ?? 0 }}</strong> जन</p>
                    <p style="text-indent: 2.5em">३. समुदाय:</p>
                    <p style="text-indent: 2.5em">४. अन्य समुदाय:</p>

                    <p><strong>३. उपभोक्ता समिती र समुदायमा आधारित संस्था । गैरसहकारी संस्था सम्बन्धी बिबरण</strong></p>
                    <p style="text-indent: 1.5em">क. समिती गठन भएको मिती: <strong>{{ $plandetail->EstablishedDate ?? 0}}</strong></p>
                    <p style="text-indent: 1.5em">ख. उपभोक्ता समितीको पदाधिकारीहरुको बिबरण</p>
                    <?php
                        $sn=1;
                    ?>
                    <table class="table table-bordered table-dark" style="margin-left:20px">
                        <tr>
                            <td>क्र.स</td>
                            <td>नाम थर</td>
                            <td>पद</td>
                            <td>बुवा/पतिको नाम थर</td>
                            <td>बाजे/ससुराको नाम थर</td>
                            <td>ठेगान</td>
                            <td>नागरिकता नं.</td>
                            <td>सम्पर्क न</td>
                            <td>हस्ताक्षर</td>
                        </tr>
                        <tbody>
                            @foreach($consumerdetail as $detail)
                            <tr>
                                <td>{{ $sn}}</td>
                                <td>{{ $detail->Name }}</td>
                                <td>{{ $detail->post->Name ?? '' }}</td>
                                <td>{{ $detail->FatherName ?? '' }}</td>
                                <td>{{ $detail->GrandFatherName ?? '' }}</td>
                                <td>{{ $detail->Address ?? '' }}</td>
                                <td>{{ $detail->AccountNumber ?? '' }}</td>
                                <td>{{ $detail->ContactNumber ?? '' }}</td>
                                <td></td>
                            </tr>
                            {{ $sn++ }}
                            @endforeach
                        </tbody>
                    </table>
                    <p style="text-indent: 1.5em">ग. समिती गठन गर्दा उपस्थीत संख्या: <strong>{{ $plandetail->NoOfPresentMember ?? 0 }}</strong> जन</p> 
                    <p style="text-indent: 1.5em">घ. अनुपस्थित संख्या: </p>    
                    <p><strong>५.उपभोक्ता समिती / समुदायमा आधारित संस्था / लाभग्राही समूह(श्रम रोजगार बैंक)ले पाउने किस्ता बिबरण:</strong></p>
                    <table class="table table-bordered table-dark" style="margin-left:20px">
                        <tr>
                            <th>मित</th>
                            <th>विवरण</th>
                            <th>रकम</th>
                            <th>कैफियत</th>

                        </tr>
                    </table>
                    <p><strong>६. आयोजना मर्मत सम्भार व्यहर्ने व्यवस्था:</strong></p>
                    <p style="text-indent: 1.5em"> क. मर्मत सम्भारको जिम्मा लिने समिती वा संस्थाको नाम: <strong>{{ $replaced_value ?? '' }}</strong></p>
                    <p style="text-indent: 1.5em">ख. जनश्रमदान (श्रमशक्ती संख्या)</p>
                    <p style="text-indent: 1.5em">ग. सेवा शुल्कबाट:</p>
                    <p style="text-indent: 1.5em">घ. दस्तुर चन्दाबाट:</p>
                    <p style="text-indent: 1.5em">ङ. लागत सहभागिता वा अनुदानबाट:</p>
                    <p style="text-indent: 1.5em">च. व्याज वा अन्य वचत:</p>

                    <p><strong>७. अन्य (प्राविधिक र व्यवस्थापन सम्वन्धि) विवरण:</strong></p>
                    <p style="text-indent: 1.5em">क.</p>
                    <p style="text-indent: 1.5em">ख.</p>
                    <p style="text-indent: 1.5em">ग.</p>
                    <p style="text-indent: 1.5em">घ.</p>
                    <p style="text-indent: 1.5em">ङ.</p>

                    <p><strong>सम्झौताका शर्तहर</strong></p>
                    <p>१. आयोजना मिति <strong>{{ date('Y-m-d', strtotime($planagreement->startdate))?? '' }}</strong> देखि शुरु गरी मिति <strong>{{ date('Y-m-d', strtotime($planagreement->completiondate)) ?? 0 }}</strong> सम्ममा पुरा गर्नु पर्नेछ ।</p>
                    <p>२. प्राप्त रकम तथा निर्माण सामाग्री सम्वन्धित आयोजनाको उद्धेश्यका लागि मात्र प्रयोग गर्नुपर्नेछ ।</p>
                    <p>३. नगदी, जिन्सी सामानको प्राप्ती, खर्च र बाँकी तथा आयोजनाको प्रगति विवरण राख्नु पर्नेछ ।</p>
                    <p>४. आम्दानी खर्चको विवरण र कार्यप्रगतिको जानकारी उपभोक्ता समूहमा छलफल गरी अर्को किस्ता माग गर्नु पर्नेछ ।</p>
                    <p>५. आयो जनाको कुल लागत भन्दा घटी लागतमा आयो जना सम्पन्न भएको अवस्थामा सो मुताविकनै अनुदान र श्रमदानको प्रतिशत निर्धारण गरी
                        भुक्तानी लिनु पर्नेछ ।</p>
                    <p>६. उपभोक्ता समितिले प्राविधिकको राय, परामर्श एवं निर्देशन अनुरुप काम गर्नु पर्नेछ ।</p>
                    <p>७. उपभोक्ता समितिले आयोजनासंग सम्वन्धित विल, भरपाईहरु, डोर हाजिरी फारामहरु, जिन्सी नगदी खाताहरु, समिति/समुहको निर्णय
                        पुस्तिका आदि कागजातहरु कार्यालयले मागेको बखत उपलव्ध गराउनु पर्नेछ र त्यसको लेखापरीक्षण पनि गराउनु पर्नेछ ।</p>
                    <p> ८. कुनै सामाग्री खरिद गर्दा आन्तरिक राजस्व कार्यालयबाट स्थायी लेखा नम्वर र मुल्य अभिबृद्धि कर दर्ता प्रमाण पत्र प्राप्त व्यक्ति वा फर्म संस्था
                        वा कम्पनीबाट खरिद गरी सोही अनुसारको विल भरपाई आधिकारीक व्यक्तिबाट प्रमाणित गरी पेश गर्नु पर्नेछ ।</p>
                    <p>९. मूल्य अभिबृद्धि कर (VAT)लाग्ने बस्तु तथा सेवा खरिद गर्दा रु २०,०००।– भन्दा बढी मूल्यको सामाग्रीमा अनिवार्य रुपमा मूल्य अभिबृद्धि कर
                        दर्ता प्रमाणपत्र प्राप्त गरेका व्यक्ति फर्म संस्था वा कम्पनीबाट खरिद गर्नु पर्नेछ । साथै उक्त विलमा उल्लिखित मु.अ.कर बाहेकको रकममा १.५%
                        अग्रीम आयकर बापत करकट्टि गरी बाँकी रकम मात्र सम्वन्धित सेवा प्रदायकलाई भुक्तानी हुनेछ । रु २०,०००।– भन्दा कम मूल्यको सामाग्री
                        खरिदमा पान नम्वर लिएको व्यक्ति वा फर्मबाट खरिद गर्नु पर्नेछ । अन्यथा खरिद गर्ने पदाधिकारी स्वयम् जिम्मेवार हुनेछ ।</p>
                    <p>१०. डोजर रोलर लगायतका मेशिनरी सामान भाडामा लिएको एवम् घर बहालमा लिई विल भरपाई पेश भएको अवस्थामा १०% प्रतिशत घर भाडा
                        कर एबम् बहाल कर तिर्नु पर्नेछ ।</p>
                    <p>११. प्रशिक्षकले पाउने पारिश्रमिक एवम् सहभागीले पाउने भत्तामा प्रचलित नियमानुसार कर लाग्नेछ ।</p>
                    <p>१२. निर्माण कार्यको हकमा शुरु लागत अनुमानका कुनै आईटमहरुमा परिर्वतन हुने भएमा अधिकार प्राप्त व्यक्ति÷कार्यालयबाट लागत अनुमान
                        संसोधन गरे पश्चात मात्र कार्य गराउनु पर्नेछ । यसरी लागत अुनमान संशोधन नगरी कार्य गरेमा उपभोक्ता समिति÷समुहनै जिम्मेवार हुनेछ ।</p>
                    <p>१३. उपभोक्ता समितिले काम सम्पन्न गरिसकेपछि बाँकी रहन गएका खप्ने सामानहरु मर्मत संभार समिति गठन भएको भए सो समितिलाई र सो
                        नभए सम्वन्धित कार्यालयलाई बुझाउनु पर्नेछ । तर मर्मत समितिलाई बुझाएको सामानको विवरण एक प्रति सम्वन्धित कार्यालयलाई जानकारीको
                        लागि बुझाउनु पर्नेछ ।</p>
                    <p> १४. सम्झौता बमोजिम आयोजना सम्पन्न भएपछि अन्तिम भुक्तानीको लागि कार्यसम्पन्न प्रतिवेदन, नापी किताव, प्रमाणित विल भरपाई, योजनाको
                        फोटो, सम्वन्धित उपभोक्ता समितिले आयोजना संचालन गर्दा भएको आय व्ययको अनुमोदन सहितको निर्णय, उपभोक्ता भेलाबाट भएको
                        सार्वजनिक लेखा परीक्षणको निर्णयको प्रतिलिपी तथा सम्वन्धित कार्यालयको वडा कार्यालयको सिफारिस सहित अन्तिम किस्ता भुक्तानीको लागि
                        निवेदन पेश गर्नु पर्नेछ ।</p>
                    <p>१५. आयोजना सम्पन्न भएपछि कार्यालयबाट जाँचपास गरी फरफारकको प्रमाणपत्र लिनु पर्नेछ । साथै आयोजानाको आवश्यक मर्मत संभारको
                        व्यवस्था सम्वन्धित उपभोक्ताहरुले नै गर्नु पर्नेछ ।</p>
                    <p> १६. आयोजना कार्यान्वयन गर्ने समुह वा उपभोक्ता समितिले आयोजनाको भौतिक तथा वित्तीय प्रगती प्रतिवेदन अनुसूची ६ को ढाँचामा सम्झौतामा
                        तोकिए बमोजिम कार्यालयमा पेश गर्नु पर्नेछ ।</p>
                    <p> १७. आयोजनाको दीगो सञ्चालन तथा मर्मत संभारको व्यवस्था गर्नु पर्नेछ ।
                       </p></p>
                    <p> १८. आयोजनाको सवै काम उपभोक्ता समिति÷समुहको निर्णय अनुसार गर्नु गराउनु पर्नेछ ।</p>
                   
                    <p><strong>कार्यालयको जिम्मेवारी तथा पालना गरिने शर्तहरुः</strong></p>
                        <p>१. आयोजनाको वजेट, उपभोक्ता समितिको काम, कर्तव्य तथा अधिकार, खरिद, लेखाङ्कन, प्रतिवेदन आदि विषयमा उपभोक्ता समितिका
                        पदाधिकारीहरुलाई अनुशिक्षण कार्यक्रम सञ्चालन गरिनेछ ।</p>
                        <p>२. आयो जनामा आवश्यक प्राविधिक सहयोग कार्यालयबाट उपलव्ध गराउन सकिने अवस्थामा गराईनेछ र नसकिने अवस्था भएमा उपभोक्ता
                        समितिले बाह्य बजारबाट सेवा परामर्श अन्तर्गत सेवा लिन सक्नेछ ।</p>
                        <p>३. आयोजनाको प्राविधिक सुपरिवेक्षणका लागि कार्यालयको तर्फबाट प्राविधिक खटाईनेछ । उपभोक्ता समितिबाट भएको कामको नियमित
                        सुपरिवेक्षण गर्ने जिम्मेवारी निज प्राविधिकको हुनेछ ।</p>
                        <p>४. पेश्की लिएर लामो समयसम्म आयोजना संचालन नगर्ने उपभोक्ता समितिलाई कार्यालयले नियम अनुसार कारवाही गर्नेछ ।</p>
                        <p>५. श्रममुलक प्रविधिबाट कार्य गराउने गरी लागत अनुमा न स्वीकृत गराई सोही बमोजिम सम्झौता गरी मेशिनरी उपकरणको प्रयोगबाट कार्य गरेको
                        पाईएमा त्यस्तो उपभोक्ता समितिसंग सम्झौता रद्ध गरी उपभोक्ता समितिलाई भुक्तानी गरिएको रकम मुल्यां कन गरी बढी भएको रकम सरकारी
                        बाँकी सरह असुल उपर गरिनेछ ।</p>
                        <p>६. आयोजना सम्पन्न भएपछि कार्यालयबाट जाँच पास गरी फरफारक गर्नु पर्नेछ ।</p>
                        <p>७. आवश्यक कागजात संलग्न गरी भुक्तानी उपलव्ध गराउन सम्वन्धित उपभोक्ता समितिबाट अनुरोध भई आएपछि उपभोक्ता समितिको बैंक
                        खातामा भुक्तानी दिनु पर्नेछ ।</p>
                        <p>८. यसमा उल्लेख नभएका कुराहरु प्रचलित कानून वमोजिम हुनेछ ।</p>
                        <p>माथि उल्लेख भए बमोजिम शर्तहरु पालना गर्न हामी निम्न पक्ष मन्जुर गर्नेछौं ।</p>   
                </div>   
                <!-- /.col -->
                <div class="col-xs-6">
                    <span><strong>उपभोक्ता समिति/गै.स.स.को तर्फबाट :</strong></span><br>
                    <span><strong>दस्तखत :</strong></span><br>
                    <span><strong>नाम थर :{{ $designation[1][0]->Name ?? '' }}</strong></span><br>
                    <span><strong>नापद : </strong>अध्यक्ष</span><br>
                    <span><strong>ठेगाना :{{ $designation[1][0]->Address ?? '' }}</strong></span><br>
                    <span><strong>सम्पर्क नं.:{{ $designation[1][0]->ContactNumber ?? '' }}</strong> </span><br>
                    <span><strong>मिति : </strong></span><br>
                    <span><strong>न.पा.को तर्फबाट:</strong></span><br>
                    <span><strong>दस्तखत : </strong></span><br>
                    <span><strong>नाम थर :जवान सिंह वम</strong> </span><br>
                    <span><strong>पद : नि.प्रमुख प्रशासकीय अधिकृत</strong> </span><br>
                    <span><strong>ठेगाना : आर.सी.पी. ५ कालिकोट</strong> </span><br>
                    <span><strong>सम्पर्क नं.: ९८४८३०१५०४</strong>  </span>
                </div>
                <div class="col-xs-6">
                    <span><strong>योजना शाखाको तर्फबाट</strong></span><br>
                    <span><strong>दस्तखत :</strong></span><br>
                    <span><strong>नाम थर : </strong>कम्मर शाह</span><br>
                    <span><strong>पद : </strong>योजना शाखा सहायक</span><br>
                    <span><strong>ठेगाना : </strong>आर.सी.पी. ५ कालिकोट</span><br>
                    <span><strong>सम्पर्क नं.: ९८४८३०५००२</strong></span><br>
                    <span><strong>मिति :</span>
                </div>
            </div>
          
    </div><!-- /.col -->

</body>
