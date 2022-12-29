
<style type="text/css">
  .nav-stacked>li>a {

    line-height: 6px !important;
}
.product-img img {
    width: 30px !important;
    height: 30px !important;
}
.mncount {
  height: 10px;
  width: 28px;
  display: table-cell;
  text-align: center;
  vertical-align: middle;
  border-radius: 50%;
  background: #e5e5e5;
  font-size: 12px;
  font-weight: normal !important;
}
</style>

{{-- @if($isShiftStart ) --}}
@if($userAtt && date('w') > 0 && date('w') < 6)
    <div class="box-widget" style="padding-bottom: 20px">
<div class="box-footer">
        <div style="font-weight:bold; font-size: 16px; padding-bottom: 15px; border-bottom: 1px lightgray solid">
             <span class="box-title text"> Missing Attendance <span class="fa-stack">
    <!-- The icon that will wrap the number -->
    
                    <!-- a strong element with the custom content, in this case a number -->
    <span class="mncount">
       {{count($userAtt)+count($leftCheckin)}}
    </span>
</span></span>
        </div>




        @if($missing_details == 'clock_out')
            <a href="{!! route('admin.adjust_adjustment.detail_modal') !!}?type=clock_out" data-toggle="modal" data-target="#modal_dialog" title="Attendance Adjustment">
                <div class="box-body">
                    <p class="text-center text-black"><span class="material-icons">
rule</span> Adjust Attendance </p>
                </div>
            </a>

        @elseif($missing_details == 'clock_in')
            <a href="{!! route('admin.adjust_adjustment.detail_modal') !!}?type=clock_in" data-toggle="modal" data-target="#modal_dialog" title="Attendance Adjustment">

                <div class="box-body">
                    <p class="text-center text-black"><span class="material-icons">
rule</span> Adjust Attendance </p>
                </div>
            </a>
        @elseif($missing_details == 'yesterday_out')
            <a href="{!! route('admin.adjust_adjustment.detail_modal') !!}?type=yesterday_out" data-toggle="modal" data-target="#modal_dialog" title="Attendance Adjustment">

                <div class="box-body">
                    <p class="text-center text-black"><span class="material-icons">
rule</span> Adjust Attendance </p>
                </div>
            </a>
        @endif
    </div></div>
@endif



<div class="box-widget" style="padding-bottom: 20px">

<div class="box-footer">
      



<div class="box-footer">
      <div style="font-weight:bold; font-size: 16px; padding-bottom: 15px; border-bottom: 1px lightgray solid">
                     <span>Attendance Summary</span>
                 </div>
   <!-- /.box-header -->
   <div class="box-body">
      <div class="row">
         <div class="col-md-12">
            <div class="chart-responsive">
               <canvas id="pieChart" height="80" width="154" style="width: 180px; height: 90px;"></canvas>
            </div>
            <!-- ./chart-responsive -->
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.box-body -->
   <div class="box-footer no-padding">
      <ul class="nav nav-pills nav-stacked">
         <li><a href="javascript::void()" data-toggle="popover" title="Present Employee" data-placement="left" data-type='presentUser' data-html="true" >Present
            <span class="pull-right ">{{ count($present_user) }}</span></a>
         </li>
         <li><a href="javascript::void()"  data-toggle="popover" title="Absent Employee" data-placement="left" data-type='absentUser' data-html="true" >Absent <span class="pull-right ">{{ count($absent_user) }}</span></a>
         </li>
         <li><a href="javascript::void()" data-type='leaveUser'  data-toggle="popover" data-placement="left" title="Leave Employee"   data-html="true" >Leave
            <span class="pull-right"> {{ count($on_leave) }}</span></a>
         </li>
      </ul>
   </div>
   <!-- /.footer -->
</div></div>

@if($travel_request->isNotEmpty() && count($travel_request) > 0)
   <div class="box-widget" style="padding-bottom: 20px">
<div class="box-footer">
       
        <div style="font-weight:bold; font-size: 16px; padding-bottom: 15px; border-bottom: 1px lightgray solid">
                     <span class="material-icons">
directions</span> Outstation Request
                 </div>
        <!-- /.box-header -->
       
        <div class="box-body">
            <ul class="products-list product-list-in-box">

                @foreach($travel_request as $act)
                    <?php $user = TaskHelper::getUser($act->staff_id); ?>
                    <li class="item">
                        <div class="product-img">
                            <img class="direct-chat-img" src="{{ \TaskHelper::getProfileImage($act->staff_id) }}" alt="Image">
                        </div>
                        <div class="" style="margin-left: 37px">
                            <a href="/admin/travel_request_modal/{{ $act->id }}" class="product-title" title="Outstation Request" data-toggle="modal" data-target="#modal_dialog">
                                {{ $user->first_name." ".$user->last_name }}
                            </a>
                            </span>
                            <span class="product-description">
                                    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($act->created_at))->diffForHumans() }}.
                                </span>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div></div>
        <!-- /.box-body -->
        <!-- /.box-footer -->
    </div>
@endif
@if($add_attendance->isNotEmpty() && count($add_attendance) > 0)
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-flash"></i> Attendance Add Request</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="products-list product-list-in-box">

                @foreach($add_attendance as $act)
                    <?php $user = TaskHelper::getUser($act->user_id); ?>
                    <li class="item">
                        <div class="product-img">

                            <img src="{{ \TaskHelper::getUserImages($act->user_id) }}"  alt="Image">
                        </div>
                        <div class="product-info">
                            <a href="/admin/attendance_request_proxy_modal/{{ $act->id }}" class="product-title" title="{{$act->attendance_status==2?'Clock out': 'Clock in'}}" data-toggle="modal" data-target="#modal_dialog">
                                {{ $user->first_name." ".$user->last_name }}
                            </a>
                            </span>
                            <span class="product-description">
                     {{ \Carbon\Carbon::createFromTimeStamp(strtotime($act->created_at))->diffForHumans() }}...
                    </span>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
        <!-- /.box-body -->
        <!-- /.box-footer -->
    </div>
@endif
@if($attendance)
<div class="box-widget" style="padding-bottom: 20px">
<div class="box-footer">
      <div style="font-weight:bold; font-size: 16px; padding-bottom: 15px; border-bottom: 1px lightgray solid">
                     <span> Time Change Request</span>
                 </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ul class="products-list product-list-in-box">

            @foreach($attendance as $act)
                <?php $user = TaskHelper::getUser($act->user_id); ?>
                <li class="item">
                    <div class="product-img">
                                <img class="direct-chat-img" src="{{ \TaskHelper::getProfileImage($act->user_id) }}" alt="Product Image">
                            </div>
                    <div class="" style="margin-left: 37px">
                        <a href="/admin/timechange_request_modal/{{ $act->id }}" class="" title="Approve" data-toggle="modal" data-target="#modal_dialog">
                            {{ $user->first_name." ".$user->last_name }}
                        </a>
                    </span>
                        <span class="product-description">
                     {{ \Carbon\Carbon::createFromTimeStamp(strtotime($act->created_at))->diffForHumans() }}...
                    </span>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>
    <!-- /.box-body -->
    <!-- /.box-footer -->
</div></div>
@endif

<div class="box-widget" style="padding-bottom: 20px">
<div class="box-footer">
      <div style="font-weight:bold; font-size: 16px; padding-bottom: 15px; border-bottom: 1px lightgray solid">
                     <span> On Leave</span>
                 </div>
   <!-- /.box-header -->
   <div class="box-body no-padding">
      <ul class="users-list clearfix">
         @foreach($on_leave as $ol)
         <li>
            <img src="{{ \TaskHelper::getUserImages($bd->id) }}" alt="User Image" width="50px" height="50px"
               style="border-radius: 50%;max-width: 100%;height: auto;">
         </li>
         @endforeach
      </ul>
      <!-- /.users-list -->
   </div>
   <!-- /.box-body -->
   <!-- /.box-footer -->
</div></div>

<div class="box-widget" style="padding-bottom: 20px">
<div class="box-footer">
      <div style="font-weight:bold; font-size: 16px; padding-bottom: 15px; border-bottom: 1px lightgray solid">
                     <span> Birthdays</span>
                 </div>
   <!-- /.box-header -->
   <div class="box-body no-padding">
      <ul class="users-list clearfix">
         @foreach($birthdays as $bd)
         <li  data-toggle="tooltip"  data-original-title="{{ $bd->first_name }}  {{ $bd->last_name }} {{ $bd->birthdayDate }} " title="{{ $bd->first_name }}  {{ $bd->last_name }} {{ $bd->birthdayDate }} ">


                                <img class="direct-chat-img" src="{{ \TaskHelper::getProfileImage($bd->id) }}" alt="Product Image">

         </li>
         @endforeach
      </ul>
      <!-- /.users-list -->
   </div>
</div></div>

<div class="box-widget" style="padding-bottom: 20px">
<div class="box-footer">
      <div style="font-weight:bold; font-size: 16px; padding-bottom: 15px; border-bottom: 1px lightgray solid">
                     <span> Anniversary</span>
                 </div>


   <!-- /.box-header -->
   <div class="box-body no-padding">
      <ul class="users-list clearfix">
         @foreach($aniversary as $bd)
         <li  title="{{ $bd->user->first_name }}  {{ $bd->user->last_name }} on  {{ date('dS M', strtotime($bd->join_date)) }}" data-toggle="tooltip"  data-original-title="{{ $bd->user->first_name }}  {{ $bd->user->last_name }} on  {{ date('dS M', strtotime($bd->join_date)) }}">
            <img class="direct-chat-img" src="{{ \TaskHelper::getProfileImage($bd->user->id) }}" alt="Product Image">

         </li>
         @endforeach
      </ul>
      <!-- /.users-list -->
   </div>
</div></div>

<div class="box-widget">
<div class="box-footer">
   <div class="">
     <div style="font-weight:bold; font-size: 16px; padding-bottom: 15px; border-bottom: 1px lightgray solid">
                     <span>Holidays</span>
                 </div>

   </div>
   <!-- /.box-header -->
   <div class="box-body">
      <ul class="products-list product-list-in-box">
         @foreach($holidays as $hd)
         <li class="item">
            <div class="product-img">
               <img src="{{ TaskHelper::getDateAttribute(date('d', strtotime($hd->start_date))) }}" title="{{date('dS M Y', strtotime($hd->start_date))}}" data-toggle="tooltip"  data-original-title="3{{date('dS M Y', strtotime($hd->start_date))}}">
               <a href="#" data-toggle="modal" data-target="#saveLogo">
               <small data-letters="{!! date('d M', strtotime($hd->start_date)) !!}"></small>
               </a>
            </div>
            <div class="" style="margin-left: 37px">
               <a href="javascript:void(0)" class="" title="{{date('dS M Y', strtotime($hd->start_date))}}">{{ $hd->event_name }}</a>
               <span class="product-description">
               {{ \Carbon\Carbon::createFromTimeStamp(strtotime($hd->start_date))->diffForHumans() }}...
               </span>
            </div>
         </li>
         @endforeach
      </ul>
   </div>
   <!-- /.box-body -->
   <!-- /.box-footer -->
</div>
</div>
<div id='presentUser' style="display: none;">
   <div style="max-height: 500px; overflow-y: scroll;">
      <table class="table table-striped" >
         <tr>
            <td>Username</td>
            <td>Department</td>
         </tr>
         @foreach($present_user as $key=>$useratt)
         <tr style="font-size: smaller;">
            <td>{{ ++$key }}</td>
            <td>{{ $useratt->first_name }} {{ $useratt->last_name }}</td>
            <td>{{$useratt->department->deptname ?? '-'}}</td>
         </tr>
         @endforeach
      </table>
   </div>
</div>
<div id='absentUser' style="display: none;">
   <div style="max-height: 500px; overflow-y: scroll;">
      <table class="table table-striped" >
         <tr>
            <td>S.N</td>
            <td>Username</td>
            <td>Department</td>
         </tr>
         @foreach($absent_user as $key=>$useratt)
         <tr style="font-size: smaller;">
            <td>{{ ++$key }}</td>
            <td>{{ $useratt->first_name }} {{ $useratt->last_name }}</td>
            <td>{{$useratt->department->deptname ?? '-'}}</td>
         </tr>
         @endforeach
      </table>
   </div>
</div>
<div id='leaveUser' style="display: none;">
   <div style="max-height: 500px; overflow-y: scroll;">
      <table class="table table-striped" >
         <tr>
            <td>S.N</td>
            <td>Username</td>
            <td>Department</td>
         </tr>
         @foreach($on_leave as $key=>$useratt)
         <?php  $useratt = $useratt->user; ?>
         <tr style="font-size: smaller;">
            <td>{{ ++$key }}</td>
            <td>{{ $useratt->first_name }} {{ $useratt->last_name }}</td>
            <td>{{$useratt->department->deptname ?? '-'}}</td>
         </tr>
         @endforeach
      </table>
   </div>
</div>
<script src="{{ asset ("/bower_components/highcharts/highcharts.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/highcharts/funnel.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/highcharts/highcharts-3d.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/highcharts/exporting.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/highcharts/export-data.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/chartjs/Chart.min.js") }}" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function(){
       $(document).on('hidden.bs.modal', '#modal_dialog', function(e) {
           $('#modal_dialog .modal-content').html('');
       });



       $('[data-toggle="popover"]').each(function(){


       let id = `#${$(this).attr('data-type')}`;
       var popovercont = $(this);
       $(this).attr('data-content',$(id).html());
       // setTimeout(function(){
       //    popovercont.popover({ container: 'body'});

       // },500);

       });

       $('[data-toggle="popover"]').popover({
           container: 'body'
       });


          //-------------
       //- PIE CHART -
       //-------------
       // Get context with jQuery - using jQuery's .get() method.
       var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
       var pieChart = new Chart(pieChartCanvas);
       var PieData = [
           {
               value: {{ count($absent_user) }},
               color: "#f56954",
               highlight: "#f56954",
               label: "Absent"
           },
           {
               value:  {{ count($present_user) }},
               color: "#00a65a",
               highlight: "#00a65a",
               label: "Present"
           },
           {
               value: {{ count($on_leave) }},
               color: "#f39c12",
               highlight: "#f39c12",
               label: "On Leave"
           }
       ];
       var pieOptions = {
           //Boolean - Whether we should show a stroke on each segment
           segmentShowStroke: true,
           //String - The colour of each segment stroke
           segmentStrokeColor: "#fff",
           //Number - The width of each segment stroke
           segmentStrokeWidth: 1,
           //Number - The percentage of the chart that we cut out of the middle
           percentageInnerCutout: 50, // This is 0 for Pie charts
           //Number - Amount of animation steps
           animationSteps: 100,
           //String - Animation easing effect
           animationEasing: "easeOutBounce",
           //Boolean - Whether we animate the rotation of the Doughnut
           animateRotate: true,
           //Boolean - Whether we animate scaling the Doughnut from the centre
           animateScale: false,
           //Boolean - whether to make the chart responsive to window resizing
           responsive: true,
           // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
           maintainAspectRatio: false,
           //String - A legend template
           legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
           //String - A tooltip template
           tooltipTemplate: "<%=value %> <%=label%> users"
       };
       //Create pie or douhnut chart
       // You can switch between pie and douhnut using the method below.
       pieChart.Doughnut(PieData, pieOptions);
       //-----------------
       //- END PIE CHART -





   });
   const dateRange = {
       <?php $currentFiscalyear = FinanceHelper::cur_fisc_yr();?>
       min_date: `{{ $currentFiscalyear->start_date }}`,
       max_date: `{{ $currentFiscalyear->end }}`,
   }

   $('.clock_time').datetimepicker({
       format: 'HH:mm:ss',
       sideBySide: true
   });
   $('.clock_date').datetimepicker({
       format: 'YYYY-MM-DD',
       sideBySide: true,
       maxDate : new Date(),
       allowInputToggle: true,
       daysOfWeekDisabled:[0,6],
   });

</script>
