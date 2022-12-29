@extends('layouts.master')
@section('content')

<style>
    .required { color: red; }
    .panel-custom .panel-heading {
        border-bottom: 2px solid #1797be;
        margin-bottom: 10px;
    }

    .btn-purple, .btn-purple:hover {
        color: #ffffff;
        background-color: #7266ba;
        border-color: transparent;
    }

    input.form-control {
     width: 85px;
        font-size: 12px;
        height: 26px;
    }
    table td{
        padding: 2px!important;
    }
    table{
        font-size: 12px!important;
    }
    /*table>tbody>tr>td{*/

    /*}*/
    .show_print { display: none; }
    .mr, #DataTables_length { margin-right: 10px !important; }
</style>

 <section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
            <h1>
                Update Check Individual Payroll Payment
                <small>{!! $page_description ?? "Page description" !!}</small>
            </h1>
            <p> Select Department and Month </p>

         {{-- {{ TaskHelper::topSubMenu('topsubmenu.payroll')}} --}}


            {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false)  !!}
        </section>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-custom" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <strong>Make Payment @if(\Request::get(payment_month)) of {{date('M Y', strtotime(\Request::get(payment_month)))}} @endif</strong>
                </div>
            </div>
            <div class="panel-body">
                <form id="attendance-form" role="form" enctype="multipart/form-data" action="/admin/payroll/create_payroll" method="get" class="form-horizontal form-groups-bordered">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <div >
                                <select class="form-control" name="division_id" required="" id="division_id">
                                    @foreach($divisions as $division)
                                        <option value="{{$division->id}}" @if(\Request::get('division_id') == $division->id) selected="selected" @endif>{{$division->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div >
                                <select class="form-control department" name="department_id" id="department" required>
                                    <option value="">Select Department</option>
{{--                                    @foreach($departments as $department)--}}
{{--                                        <option value="{{$department->departments_id}}" @if(\Request::get('department_id') == $department->departments_id) selected="selected" @endif>{{$department->deptname}}</option>--}}
{{--                                    @endforeach--}}
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-2">
                             <select name="year" class="form-control">
{{--                                  @foreach($fiscalyears as $year)--}}
                                   <option id="{{$fiscalyears->id}}">{{$fiscalyears->numeric_fiscal_year}}</option>
{{--                                  @endforeach--}}
                             </select>
                        </div>
                        <?php
                           $monthsName = ['Baisakh', 'Jestha', 'Ashadh', 'Shrawan', 'Bhadra', 'Ashwin', 'Kartik', 'Mangsir', 'Paush', 'Magh', 'Falgun', 'Chaitra'];
                        ?>
                        <div class="col-sm-2">
                             <select name="month" class="form-control" required>
                                 <option value="">Select Month</option>
                             @foreach($monthsName as $key=>$mnth)
                                   <option value="{{$key+1}}" @if(\Request::get('month') == $key+1) selected="selected" @endif >{{$mnth}}</option>
                                  @endforeach
                             </select>

                        </div>
                        <div class="col-sm-2">
                            <button type="submit" id="sbtn" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($users)

<div id="EmpprintReport">
    <div class="row">
        <div class="col-sm-12 std_print">
         <form method="post" action="{{route('admin.payrolllist.store')}}">
                        <div class="panel panel-custom table-responsive">
                           @csrf
                           <input type="hidden" name="year" value="{{\Request::get('year')}}">
                           <input type="hidden" name="month" value="{{\Request::get('month')}}">
                            <table class="table table-triped DatsaTables  dataTable no-footer dtr-inline" id="DataTables">
                              <thead>
                                 <tr>
                                    <td class="text-bold col-sm-1" style="min-width: 50px;">S.No</td>
                                    <td class="text-bold col-sm-1" style="min-width: 50px;">EMP ID</td>
                                    <td class="text-bold" style="min-width: 185px;">Name</td>
                                    <td class="text-bold" style="min-width: 120px;">Designation</td>
                                     <td class="text-bold"> Total Days</td>
                                     <td class="text-bold">Attendance</td>
                                    <td class="text-bold">Paid Leaves</td>
                                    <td class="text-bold">Absent Days</td>
{{--                                    <td class="text-bold">Payable Attendance</td>--}}
                                    <td class="text-bold">Actual Salary</td>
                                    <td class="text-bold">Basic Salary</td>
                                    <td class="text-bold">Grade</td>
                                    <td class="text-bold">PF Contribution</td>
                                     @foreach($allowances as $allowance)
                                    <td class="text-bold">{{$allowance}}</td>
                                     @endforeach
                                    <td class="text-bold text-success">Incentive</td>
                                    <td class="text-bold text-success">Dashain Allowance</td>
{{--                                     <td class="text-bold"> OT Hours </td>--}}
{{--                                     <td class="text-bold text-success">OT Amount</td>--}}

{{--                                     <td class="text-bold">Total</td>--}}
{{--                                    <td class="text-bold">2 hrs additional</td>--}}
{{--                                    <td class="text-bold">Total Salary</td>--}}
                                     <td class="text-bold">Payable Basic Salary</td>
                                     <td class="text-bold">Gross Salary</td>
                                     <td class="text-bold text-danger">Gratuity</td>
                                     <td class="text-bold text-danger">TDS</td>
                                     <td class="text-bold text-danger">SST</td>
                                     <td class="text-bold text-danger">P.F Deduction</td>
                                     <td class="text-bold text-danger">Insurance Prem.</td>
                                     <td class="text-bold text-danger">Adv. Deduction</td>
                                     <td class="text-bold text-danger">Loan Deduction</td>
                                     <td class="text-bold text-danger">Dormitory</td>
                                     <td class="text-bold text-danger">Meal</td>

{{--                                     <td class="text-bold">Errors Adjust(+/-)</td>--}}
{{--                                    <td class="text-bold text-success">Gratuity</td>--}}
{{--                                    <td class="text-bold  text-success">PF</td>--}}
{{--                                    <td class="text-bold">CTC</td>--}}
{{--                                    <td class="text-bold text-danger">Adv. Deduction</td>--}}
{{--                                    <td class="text-bold text-danger">P.F</td>--}}
{{--                                    <td class="text-bold text-danger">CIT</td>--}}
{{--                                    <td class="text-bold">Uniform Deduction</td>--}}
                                    <td class="text-bold">Monthly Payable</td>
{{--                                    <td class="text-bold text-danger">SST</td>--}}
                                     <td class="text-bold">Errors Adjust(+/-)</td>

                                     <td class="text-bold">Net Salary</td>
                                    <td class="text-bold">Remarks</td>
                                 </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $total_basic_sal = 0;
                                    $total_net_sal = 0;
                                    $total_overtime = 0;
                                    $total_fine = 0;
                                    $total_sal = 0;
                                ?>

                                  @if(count($users)>0)
                                @foreach($users as $sk => $sv)
                                    @if($sv->employeePayroll->template)
                                 <?php
                                  $template = $sv->employeePayroll->template;
//                                  $allowances = \PayrollHelper::getSalaryAllowance($template->salary_template_id);


                                     $pf_contribution=(5/100)*$template->basic_salary;
                                 $total_actual_salary=$pf_contribution+$template->basic_salary+$template->allowance()->sum('allowance_value');

                                  $emp_payroll = \App\Models\EmployeePayroll::where('user_id',$sv->id)->first();

                                  // dd($emp_payroll);

                                  $attendance = \App\Helpers\AttendanceHelper::getUserAttendanceHistroy($sv->id,$start_date,$end_date)->count();
                                  $overtime = \App\Helpers\TaskHelper::overtimedays($sv->id,$start_date,$end_date);

//                                  $annual_leave = \App\Helpers\TaskHelper::countUserLeave($sv->id,'ERL',$start_date,$end_date);
//
//                                  $sick_leave = \App\Helpers\TaskHelper::countUserLeave($sv->id,'SKL',$start_date,$end_date);
//
//                                  $phl = \App\Helpers\TaskHelper::countUserLeave($sv->id,'PTL',$start_date,$end_date);
//
//                                  $mol = \App\Helpers\TaskHelper::countUserLeave($sv->id,'MTL',$start_date,$end_date);
//
//                                  $lwp = \App\Helpers\TaskHelper::countUserLeave($sv->id,'LWP',$start_date,$end_date);
                                     $paid_leave_days=\App\Helpers\TaskHelper::countPaidLeaveDays($sv->id,$start_date,$end_date);

                                  $absent_days = $total_days - ($attendance +  $paid_leave_days);

                                  $payable_attendance = $attendance +  $paid_leave_days;


//                                 $emp_two_hours_additional = $emp_payroll->additional_2_hours;
//
//                                  foreach($allowances as $val){
//
//                                        if($val['allowance_label'] == 'D.A')
//                                            {
//                                                 $da = $val->allowance_value;
//                                            }
//
//
//                                       if($val['allowance_label'] == 'Other Allowance')
//                                            {
//                                                 $other_allowance = $val->allowance_value;
//                                            }
//                                      }

                                 ?>
                                 @endif
                                 <tr class="detail-tr">
                                    <td class="col-sm-1 text-center">{{$sk+1}}.
                                    </td>
                                    <td class="col-sm-1 text-center text-primary">#{{ $sv->emp_id}}
                                        <input type="hidden" name = "user_id[]" value="{{ $sv->id }}">
                                        <input type="hidden" name = "departments_id" value="{{ \Request::get('department_id') }}">
                                        <input type="hidden" name = "emp_marrital_status" class="emp_marrital_status" value="{{ $emp_payroll->marrital_option }}">
                                    </td>
                                    <td>{{ $sv->first_name.' '.$sv->last_name }}</td>
                                    <td>{{ $sv->designation->designations }}</td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Total Working Days" data-toggle="tooltip" name="total_days[]" value="{{$total_days}}" class="form-control total_days" readonly=""></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Attendance" data-toggle="tooltip" name="attendance[]" class="form-control" value="{{$attendance}}" readonly></td>
{{--                                    <td title = "{{ $sv->first_name.' '.$sv->last_name }} | Annual leave"><input type="number" name="anual_leave[]" class="form-control" value="{{$annual_leave}}" step=".01"></td>--}}
{{--                                    <td title = "{{ $sv->first_name.' '.$sv->last_name }} | sick leave"><input type="number" name="sick_leave[]" class="form-control" value="{{$sick_leave}}"></td>--}}
{{--                                    <td title = "{{ $sv->first_name.' '.$sv->last_name }} | phl"><input type="number" name="phl[]" class="form-control" value="{{$phl}}"></td>--}}
{{--                                    <td title = "{{ $sv->first_name.' '.$sv->last_name }}|  mol ml pl"><input type="number" name="mol_ml_pl[]" class="form-control" value="{{$mol}}"></td>--}}
{{--                                    <td title = "{{ $sv->first_name.' '.$sv->last_name }} | lwp"><input type="number" name="lwp[]" class="form-control" value="{{$lwp}}"></td>--}}

                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  Paid Leave Days" data-toggle="tooltip" name="paid_leaves[]" class="form-control" value="{{$paid_leave_days}}" readonly></td>
                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  Absent Days" data-toggle="tooltip" name="absent[]" class="form-control absent" value="{{$absent_days}}" readonly></td>
{{--                                    <td title = "{{ $sv->first_name.' '.$sv->last_name }} | late half days" data-toggle="tooltip"><input type="number" name="late_half_days[]" class="form-control"></td>--}}
{{--                                    <td ><input type="number" name="payable_attendance[]" title = "{{ $sv->first_name.' '.$sv->last_name }} | Payable Attendance" data-toggle="tooltip" class="form-control payable_attendance" value="{{$payable_attendance}}" readonly></td>--}}
                                    <td ><input type="number" name="actual_salary[]" title = "{{ $sv->first_name.' '.$sv->last_name }} | Actual Salary" data-toggle="tooltip" class="form-control actual_salary" value="{{$total_actual_salary}}" readonly></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Basic Salary" data-toggle="tooltip" name="t_basic[]" value = "{{$template->basic_salary}}" class="form-control t_basic" readonly=""></td>
                                     <td  data-toggle="tooltip"><input type="text" title = "{{ $sv->first_name.' '.$sv->last_name }} | Salary Grade" data-toggle="tooltip" name="salary_grade[]" value = "{{$template->salary_grade}}" class="form-control salary_grade" readonly=""></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | PF Contribution" data-toggle="tooltip" name="pf_contribution[]" value = "{{$pf_contribution}}" class="form-control pf_contribution" readonly=""></td>


                                    @foreach($allowances as $allowance)
                                        @if($template)
                                        <?php
                                         $data=$template->allowance->where('allowance_label',$allowance)->first();
                                        ?>
                                         @endif
                                     <td  data-toggle="tooltip">
                                         <input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | {{$allowance}}" data-toggle="tooltip" name="allowance_value[]" value = "{{$data->allowance_value}}" class="form-control allowances" readonly="">
                                         <input type="hidden" name="allowance_label[]" value = "{{$data->allowance_label}}"></td>
                                     @endforeach
{{--                                     <td  ><input data-toggle="tooltip" title = "{{ $sv->first_name.' '.$sv->last_name }} | da" type="number" name="da[]" value = "{{$da}}" class="form-control da" readonly=""></td>--}}
                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Incentive" data-toggle="tooltip" name="incentive[]" class="form-control incentive"></td>
                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Dashain Allowance" data-toggle="tooltip" name="dashain_allowance[]" class="form-control dashain_allowance"></td>
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | OT Hours" data-toggle="tooltip" name="ot_hours[]" class="form-control ot_hours"></td>--}}
{{--                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | OT Amount" data-toggle="tooltip" name="ot_amount[]" class="form-control ot_amount" readonly></td>--}}

                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Working days basic" data-toggle="tooltip" name="payable_basic[]" class="form-control working_days_basic" readonly=""></td>

                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | total after allowance" data-toggle="tooltip" name="total_after_allowance[]" class="form-control total_after_allowance"  readonly=""></td>

{{--                                    <td title = "{{ $sv->first_name.' '.$sv->last_name }} | additional attendance two hours" data-toggle="tooltip"><input type="number" name="additional_attendance_two_hours[]" class="form-control additional_attendance_two_hours" readonly=""></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | total salary" data-toggle="tooltip" name="total_salary[]" class="form-control total_salary" readonly=""></td>--}}

{{--                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Total Salary" data-toggle="tooltip" name="salary_for_the_month[]" class="form-control salary_for_the_month" readonly=""></td>--}}


                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Gratuity" data-toggle="tooltip" name="gratuity[]" class="form-control gratuity"></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | TDS" data-toggle="tooltip" name="tds[]" class="form-control tds"></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | SST" data-toggle="tooltip" name="sst[]" class="form-control sst" ></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  PF" data-toggle="tooltip" name="pf[]" class="form-control pf" readonly=""></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Insurance Premium" data-toggle="tooltip" name="insurance_premium[]" class="form-control insurance_premium"></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Advance Deduction" data-toggle="tooltip" name="advance_deduction[]" class="form-control advance_deduction"></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Loan Deduction" data-toggle="tooltip" name="loan_deduction[]" class="form-control loan_deduction"></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Dormitory" data-toggle="tooltip" name="dormitory[]" class="form-control dormitory"></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Meal" data-toggle="tooltip" name="meal[]" class="form-control meal"></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  Monthly payable amount" data-toggle="tooltip" name="monthly_payable_amount[]" class="form-control monthly_payable_amount" readonly=""></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  Error Adjustment" data-toggle="tooltip" name="error_adjust[]" class="form-control error_adjust"></td>
                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Net Salary" data-toggle="tooltip" name="net_salary[]" class="form-control net_salary" readonly=""></td>
                                     <td  data-toggle="tooltip"><input type="text" title = "{{ $sv->first_name.' '.$sv->last_name }} | Remarks" data-toggle="tooltip" name="remarks[]" class="form-control"></td>

{{--                                     <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  error adjustment" data-toggle="tooltip" name="error_adjust[]" class="form-control error_adjust"></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | Gratuity" data-toggle="tooltip" name="gratuity[]" class="form-control gratuity" readonly=""></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  PF" data-toggle="tooltip" name="pf[]" class="form-control pf" readonly=""></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | ctc" data-toggle="tooltip" name="ctc[]" class="form-control ctc" readonly=""></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | adv" data-toggle="tooltip" name="adv[]" class="form-control adv"></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | pf after ctc" data-toggle="tooltip" name="pf_after_ctc[]" class="form-control pf_after_ctc" readonly=""></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  cit" data-toggle="tooltip" name="cit[]" class="form-control cit"></td>--}}
{{--                                    <td title = "{{ $sv->first_name.' '.$sv->last_name }} |  Uniform deduction" data-toggle="tooltip"><input type="number" name="uniform_deduction[]" class="form-control uniform"></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} |  Monthly payable amount" data-toggle="tooltip" name="monthly_payable_amount[]" class="form-control monthly_payable_amount" readonly=""></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | sst" data-toggle="tooltip" name="sst[]" class="form-control sst" step=".01"></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="number" title = "{{ $sv->first_name.' '.$sv->last_name }} | net salary" data-toggle="tooltip" name="net_salary[]" class="form-control net_salary" readonly=""></td>--}}
{{--                                    <td  data-toggle="tooltip"><input type="text" title = "{{ $sv->first_name.' '.$sv->last_name }} | remarks" data-toggle="tooltip" name="remarks[]" class="form-control"></td>--}}
                                 </tr>


                                <?php
                                    $total_basic_sal = $total_basic_sal + $template->basic_salary;
                                    $total_net_sal = $total_net_sal + $net_salary;
                                    $total_overtime =  $total_overtime+$overtime_money;

                                ?>
                                 @endforeach
                                  @else
                              <tr>
                                  <td colspan="29">No Employees found for the selected department and month...</td>
                              </tr>
                                      @endif

                              </tbody>
                                 {{--}} <tr>
                                    <td colspan="2"></td>
                                    <td style="float: right">Total</td>
                                    <td>{{ $total_basic_sal }}</td>
                                    <td>{{ $total_net_sal }}</td>
                                    <td>{{ $total_overtime }}</td>
                                    <td>{{ $total_fine }}</td>
                                    <td>{{ $total_sal }}</td>
                                 </tr> --}}
                           </table>
                        </div>
                <input type="submit" value="Run Payroll" class="btn btn-primary">
             <a href="/admin/payroll/list_payroll" class="btn btn-danger">Cancel</a>
        </form>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="payment_show" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">

        </div>
    </div>
</div>
@endsection


<!-- Optional bottom section for modals etc... -->
@section('body_bottom')

<!-- SELECT2-->
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/select2/css/select2.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/select2/css/select2-bootstrap.css") }}">
<script src="{{ asset("/bower_components/admin-lte/select2/js/select2.js") }}"></script>



<script type="text/javascript">

      $(document).ready(function(e){
          $('.detail-tr').each(function(e){
             var t_basic = $(this).find('.t_basic').val();
             // var other_allowance = $(this).find('.other_allowance').val();
             // var da = $(this).find('.da').val();
              var allowances=0;
              $('.allowances').each(function (){
                  allowances += Number($(this).val())
              })
              var pf_contribution=$('.pf_contribution').val()
              var incentive=$('.incentive').val()
              var dashain_allowance=$('.dashain_allowance').val()
              // var ot_amount=$('.ot_amount').val()

              var total_days={!! $total_days !!}

                  // var payable_attendance = $(this).find('.payable_attendance').val();

                  var absent_days=$(this).find('.absent').val();
              var absent_basic_deduction = Number(t_basic)/Number(total_days)*Number(absent_days);

              var working_days_basic = Number(t_basic)-Number(absent_basic_deduction);

              $(this).find('.working_days_basic').val(working_days_basic.toFixed(2));

              var total_salary = (Number(working_days_basic)+Number(allowances)+Number(pf_contribution)+Number(incentive)+Number(dashain_allowance));
              $(this).find('.total_after_allowance').val(total_salary.toFixed(2));







             // $(this).find('.total_salary').val(total_salary.toFixed(2));

             // var salary_for_the_month = Number(total_salary)/Number(total_days) * Number(payable_attendance);
             // $(this).find('.salary_for_the_month').val(salary_for_the_month.toFixed(2));


             // var gratuity = Number(working_days_basic)*8.33/100;
             // $(this).find('.gratuity').val(gratuity.toFixed(2));

              var gratuity=$(this).find('.gratuity').val()
              var sst=$(this).find('.sst').val()
              var tds=$(this).find('.tds').val()



             var pf = Number(t_basic)*10/100;
             $(this).find('.pf').val(Number(pf.toFixed(2)));

              var insurance_premium=$(this).find('.insurance_premium').val()
              var advance_deduction=$(this).find('.advance_deduction').val()
              var loan_deduction=$(this).find('.loan_deduction').val()
              var dormitory=$(this).find('.dormitory').val()
              var meal=$(this).find('.meal').val()


             var all_deductions=Number(gratuity)+Number(sst)+Number(tds)+Number(pf)+Number(insurance_premium)+Number(advance_deduction)+Number(loan_deduction)+Number(dormitory)+Number(meal)
             // var ctc = Number(salary_for_the_month) + Number(gratuity)+Number(pf);
             // $(this).find('.ctc').val((Number(ctc)).toFixed(2));
             //
             // $(this).find('.pf_after_ctc').val((Number(pf*2)).toFixed(2));

              var salary_after_deduction=Number(total_salary)-Number(all_deductions)
            // var monthly_payable_amount = Number(ctc)-Number(pf*2);
             $(this).find('.monthly_payable_amount').val((Number(salary_after_deduction)).toFixed(2));

              var adjustment=$(this).find('.error_adjust').val()
              var salary_after_adjustment=Number(salary_after_deduction)+Number(adjustment);

              $(this).find('.net_salary').val((Number(salary_after_adjustment)).toFixed(2));



          {{--var tax_band = {!!json_encode($tax_band)!!};--}}

        {{--    var sst_amount=0;--}}

        {{--    var selected_band=''--}}

        {{--    var user_marital_status = $(this).find('.emp_marrital_status').val();--}}

        {{--    tax_band.every((item)=>{--}}
        {{--        if (user_marital_status==item.marital_status&&((monthly_payable_amount*12>item.from_amount&&monthly_payable_amount*12<=item.to_amount)||--}}
        {{--        (monthly_payable_amount*12>item.from_amount&&item.to_amount==null))--}}
        {{--            ) {--}}
        {{--            selected_band=item--}}
        {{--        return false--}}
        {{--        }--}}
        {{--        return true--}}
        {{--    })--}}


        {{--    tax_band.every((item)=>{--}}
        {{--        if (user_marital_status==item.marital_status&&item.id==selected_band.id) {--}}

        {{--            sst_amount+=(item.tax_percentage/100)*monthly_payable_amount--}}
        {{--            return false;--}}
        {{--        }--}}
        {{--        else if(user_marital_status==item.marital_status&&item.id!=selected_band.id){--}}

        {{--        monthly_payable_amount=monthly_payable_amount-(item.to_amount-item.from_amount)--}}
        {{--        sst_amount+=(item.tax_percentage/100)*(item.to_amount-item.from_amount)--}}
        {{--        return true--}}
        {{--    }--}}
        {{--    return true--}}
        {{--    })--}}
        {{--     $(this).find('.sst').val(Number(sst_amount).toFixed(2));--}}
        {{--     $(this).find('.net_salary').val((Number(monthly_payable_amount-sst_amount)).toFixed(2));--}}

         });

      });

      // $.ajax()


    $(function() {

        $('#payment_month').datetimepicker({
            format: 'YYYY-MM',
            sideBySide: true
        });

        $('.select_box').select2({
            theme: 'bootstrap',
        });

        $('[data-toggle="tooltip"]').tooltip();



    $(document).on('input', '.gratuity,.incentive,.dashain_allowance,.ot_hours,.tds,.sst,.pf,.insurance_premium,.advance_deduction,.loan_deduction,.dormitory,.meal,.error_adjust', function() {
        var parentDiv=$(this).parent().parent();

        var t_basic = parentDiv.find('.t_basic').val();
        // var other_allowance = $(this).find('.other_allowance').val();
        // var da = $(this).find('.da').val();
        var allowances=0;
        parentDiv.find('.allowances').each(function (){
            allowances += Number($(this).val())
        })
        var pf_contribution=parentDiv.find('.pf_contribution').val()
        var incentive=parentDiv.find('.incentive').val()
        var dashain_allowance=parentDiv.find('.dashain_allowance').val()
        // var ot_hours = parentDiv.find('.ot_hours').val();
        // var ot_amount = t_basic/(365*8)*1.5*ot_hours;
        // parentDiv.find('.ot_amount').val(ot_amount.toFixed(2));

        var total_days={!! $total_days !!}

            // var payable_attendance = parentDiv.find('.payable_attendance').val();

        var absent_days=parentDiv.find('.absent').val();
        var absent_basic_deduction = Number(t_basic)/Number(total_days)*Number(absent_days);

        var working_days_basic = Number(t_basic)-Number(absent_basic_deduction);

        parentDiv.find('.working_days_basic').val(working_days_basic.toFixed(2));


        // var working_days_basic = Number(t_basic)/Number(total_days)*Number(payable_attendance);

        // parentDiv.find('.working_days_basic').val(working_days_basic.toFixed(2));

        var total_salary = (Number(working_days_basic)+Number(allowances)+Number(pf_contribution)+Number(incentive)+Number(dashain_allowance));

        parentDiv.find('.total_after_allowance').val(total_salary.toFixed(2));



        var gratuity=parentDiv.find('.gratuity').val()

        var sst=parentDiv.find('.sst').val()
        var tds=parentDiv.find('.tds').val()



        var pf = Number(t_basic)*10/100;
        parentDiv.find('.pf').val(Number(pf.toFixed(2)));

        var insurance_premium=parentDiv.find('.insurance_premium').val()
        var advance_deduction=parentDiv.find('.advance_deduction').val()
        var loan_deduction=parentDiv.find('.loan_deduction').val()
        var dormitory=parentDiv.find('.dormitory').val()
        var meal=parentDiv.find('.meal').val()


        var all_deductions=Number(gratuity)+Number(sst)+Number(tds)+Number(pf)+Number(insurance_premium)+Number(advance_deduction)+Number(loan_deduction)+Number(dormitory)+Number(meal)
        // var ctc = Number(salary_for_the_month) + Number(gratuity)+Number(pf);
        // parentDiv.find('.ctc').val((Number(ctc)).toFixed(2));
        //
        // parentDiv.find('.pf_after_ctc').val((Number(pf*2)).toFixed(2));

        var salary_after_deduction=Number(total_salary)-Number(all_deductions)
        // var monthly_payable_amount = Number(ctc)-Number(pf*2);
        parentDiv.find('.monthly_payable_amount').val((Number(salary_after_deduction)).toFixed(2));

        var adjustment=parentDiv.find('.error_adjust').val()
        var salary_after_adjustment=Number(salary_after_deduction)+Number(adjustment);

        parentDiv.find('.net_salary').val((Number(salary_after_adjustment)).toFixed(2));


        //t_basic
        // var t_basic=parentDiv.find('.t_basic').val();
        // // var other_allowance=parentDiv.find('.other_allowance').val();
        // // var da=parentDiv.find('.da').val();
        // // var additional_two_hours=parentDiv.find('.additional_attendance_two_hours').val();
        // // var total = (Number(t_basic)+Number(other_allowance)+Number(da));
        //
        // var allowances=0;
        // $('.allowances').each(function (){
        //     allowances += $(this).val()
        // })
        // var total = (Number(t_basic)+Number(allowances));
        // parentDiv.find('.total_after_allowance').val(total.toFixed(2));
        // //total already claculated
        //
        // var total_salary = (Number(total));
        // parentDiv.find('.total_salary').val(total_salary.toFixed(2));



        // var total_days=parentDiv.find('.total_days').val();
        // var payable_attendance=parentDiv.find('.payable_attendance').val();
        //
        // var salary_for_the_month = Number(total_salary)/Number(total_days) * Number(payable_attendance);
        // parentDiv.find('.salary_for_the_month').val(salary_for_the_month);
        // var working_days_basic = Number(t_basic)/Number(total_days)*Number(payable_attendance);
        //
        // parentDiv.find('.working_days_basic').val(Number(t_basic)/Number(total_days)*Number(payable_attendance));


        // var ot_hours = parentDiv.find('.ot_hours').val();
        // var ot_amount = t_basic/(365*8)*1.5*ot_hours;
        // parentDiv.find('.ot_amount').val(ot_amount.toFixed(2));

        // var error_adjust = parentDiv.find('.error_adjust').val();
        // var gratuity = Number(working_days_basic)*8.33/100;
        // parentDiv.find('.gratuity').val((Number(gratuity)).toFixed(2));
        // var pf = Number(t_basic)*10/100;
        // parentDiv.find('.pf').val(Number(t_basic)*10/100);
        //
        // var ctc = Number(salary_for_the_month) + Number(ot_amount) + Number(error_adjust) + Number(gratuity)+Number(pf);
        // parentDiv.find('.ctc').val(ctc.toFixed(2));
        //
        // var advanced = parentDiv.find('.adv').val();
        // parentDiv.find('.pf_after_ctc').val((Number(t_basic)*2*10/100).toFixed(2));
        // var cit = parentDiv.find('.cit').val();
        // // var uniform = parentDiv.find('.uniform').val();
        //
        // var monthly_payable_amount = Number(ctc)-Number(advanced)-Number(pf*2)-Number(cit);
        // parentDiv.find('.monthly_payable_amount').val((Number(monthly_payable_amount)).toFixed(2));

        // var sst = parentDiv.find('.sst').val();
        // parentDiv.find('.net_salary').val(Number(monthly_payable_amount)-Number(sst));

        {{--var tax_band = {!!json_encode($tax_band)!!};--}}

        {{--    var sst_amount=0;--}}

        {{--    var selected_band=''--}}

        {{--    var user_marital_status = parentDiv.find('.emp_marrital_status').val();--}}
        {{--     tax_band.every((item)=>{--}}
        {{--        if (user_marital_status==item.marital_status&&((monthly_payable_amount*12>item.from_amount&&monthly_payable_amount*12<=item.to_amount)||--}}
        {{--        (monthly_payable_amount*12>item.from_amount&&item.to_amount==null))--}}
        {{--            ) {--}}
        {{--            selected_band=item--}}
        {{--        return false--}}
        {{--        }--}}
        {{--        return true--}}
        {{--    })--}}


        {{--    tax_band.every((item)=>{--}}
        {{--        if (user_marital_status==item.marital_status&&item.id==selected_band.id) {--}}

        {{--            sst_amount+=(item.tax_percentage/100)*monthly_payable_amount--}}
        {{--            return false;--}}
        {{--        }--}}
        {{--        else if(user_marital_status==item.marital_status&&item.id!=selected_band.id){--}}

        {{--        monthly_payable_amount=monthly_payable_amount-(item.to_amount-item.from_amount)--}}
        {{--        sst_amount+=(item.tax_percentage/100)*(item.to_amount-item.from_amount)--}}
        {{--        return true--}}
        {{--    }--}}
        {{--    return true--}}
        {{--    })--}}
        {{--     parentDiv.find('.sst').val(Number(sst_amount).toFixed(2));--}}
        {{--     $(this).find('.net_salary').val((Number(monthly_payable_amount-sst_amount)).toFixed(2));--}}

      });
    });
</script>
<script type="text/javascript">
    $(function() {

        $('#payment_month').datetimepicker({
            format: 'YYYY-MM',
            sideBySide: true
        });

        $('.select_box').select2({
            theme: 'bootstrap',
        });

        $('[data-toggle="tooltip"]').tooltip();


        // $(document).on('input', '.ot_hours,.payable_attendance,.t_basic,.other_allowance,.da,.additional_attendance_two_hours,.error_adjust,.adv,.cit,.uniform,.sst', function() {
        //     var parentDiv=$(this).parent().parent();
        //     var t_basic=parentDiv.find('.t_basic').val();
        //     // var other_allowance=parentDiv.find('.other_allowance').val();
        //     // var da=parentDiv.find('.da').val();
        //     // var additional_two_hours=parentDiv.find('.additional_attendance_two_hours').val();
        //
        //     // var total = (Number(t_basic)+Number(other_allowance)+Number(da));
        //     var allowances=0;
        //     $('.allowances').each(function (){
        //         allowances += $(this).val()
        //     })
        //     var total = (Number(t_basic)+Number(allowances));
        //     parentDiv.find('.total_after_allowance').val(total.toFixed(2));
        //
        //     var total_salary = (Number(total));
        //     parentDiv.find('.total_salary').val(total_salary.toFixed(2));
        //
        //
        //
        //     var total_days=parentDiv.find('.total_days').val();
        //     var payable_attendance=parentDiv.find('.payable_attendance').val();
        //
        //     var salary_for_the_month = Number(total_salary)/Number(total_days) * Number(payable_attendance);
        //     parentDiv.find('.salary_for_the_month').val(salary_for_the_month.toFixed(2));
        //     var working_days_basic = Number(t_basic)/Number(total_days)*Number(payable_attendance);
        //
        //     parentDiv.find('.working_days_basic').val(working_days_basic.toFixed(2));
        //
        //
        //     var ot_hours = parentDiv.find('.ot_hours').val();
        //     var ot_amount = t_basic/(365*8)*1.5*ot_hours;
        //     parentDiv.find('.ot_amount').val(ot_amount.toFixed(2));
        //
        //
        //     var error_adjust = parentDiv.find('.error_adjust').val();
        //     var gratuity = Number(working_days_basic)*8.33/100;
        //     parentDiv.find('.gratuity').val((Number(gratuity)).toFixed(2));
        //     var pf = Number(t_basic)*10/100;
        //     parentDiv.find('.pf').val(Number(t_basic)*10/100);
        //
        //     var ctc = Number(salary_for_the_month) + Number(ot_amount) + Number(error_adjust) + Number(gratuity)+Number(pf);
        //     parentDiv.find('.ctc').val(ctc.toFixed(2));
        //
        //     var advanced = parentDiv.find('.adv').val();
        //     parentDiv.find('.pf_after_ctc').val((Number(t_basic)*2*10/100).toFixed(2));
        //     var cit = parentDiv.find('.cit').val();
        //     var uniform = parentDiv.find('.uniform').val();
        //
        //     var monthly_payable_amount = Number(ctc)-Number(advanced)-Number(pf*2)-Number(cit);
        //     parentDiv.find('.monthly_payable_amount').val((Number(monthly_payable_amount)).toFixed(2));
        //
        //     var sst = parentDiv.find('.sst').val();
        //     parentDiv.find('.net_salary').val((Number(monthly_payable_amount)-Number(sst)).toFixed(2));
        //
        //
        // });
    });

    $(document).ready(function (){
        var division_id = $('#division_id').val();
        setDepartments(division_id)
    })
    $('#division_id').change(function(){
        var division_id = $(this).val();
        getDepartments(division_id)

    });
    function getDepartments(division_id){
        $.get(`/admin/get-departments/${division_id}`,function(res){
            let dept = res.data;
            var options = '<option value="">Select Department</option>';
            for(let u of dept){
                options = options + `<option value='${u.departments_id}'>${u.deptname}</option>`
            }
            $('#department').html(options);
        }).fail(function(){
            alert("Failed To Load");
        });
    }
    function setDepartments(division_id){
        var dept_id={!! json_encode(Request::get('department_id')) !!}

        $.get(`/admin/get-departments/${division_id}`,function(res){
            let dept = res.data;
            var options = '<option value="">Select Department</option>';
            for(let u of dept){
                options = options + `<option value='${u.departments_id}'>${u.deptname}</option>`
            }
            $('#department').html(options).val(dept_id);
        }).fail(function(){
            alert("Failed To Load");
        });
    }

</script>

@endsection
