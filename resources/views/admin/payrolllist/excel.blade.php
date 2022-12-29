<?php
$allowances = ['Dearness Allowance', 'Transportation Allowance', 'Telephone Allowance', 'Managerial Allowance', 'Other Allowance',
    'Driver Allowance'];
?>
<?php
$chosen_date = explode('-', $payroll->date);
$year = $chosen_date[0];
$month = $chosen_date[1];
$monthsName = ['Baisakh', 'Jestha', 'Ashadh', 'Shrawan', 'Bhadra', 'Ashwin', 'Kartik', 'Mangsir', 'Paush', 'Magh', 'Falgun', 'Chaitra'];

?>
<table class="table table-triped DatsaTables  dataTable no-footer dtr-inline" id="DataTables">
    <thead>
    <tr>
        <th style="font-weight: bold;" colspan="15" align="center">Salary Summary</th>
        <th style="font-weight: bold;" colspan="15" align="center">For the month of {{$monthsName[$month-1]}}, {{$year}}</th>
    </tr>
    <tr></tr>
    <tr>
        <th style="font-weight: bold;">Division: {{$payroll->department->division->name}}</th>
    </tr>
    <tr>
        <th style="font-weight: bold;">Department: {{$payroll->department->deptname}}</th>
    </tr>
    <tr></tr>
    <tr>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold col-sm-1">S.No</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold col-sm-1" >EMP ID</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9;min-width: 185px;" class="text-bold">Name</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9;min-width: 120px;" class="text-bold">Designation</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold"> Total Days</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Attendance</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Paid Leaves</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Absent Days</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Actual Salary</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Basic Salary</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Grade</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">PF Contribution</td>
        @foreach($allowances as $allowance)
            <td class="text-bold" style="font-weight: bold;border: 1px solid black;background: #359cd9">
                {{$allowance}}
            </td>
        @endforeach
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-success">Incentive</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-success">Dashain Allowance</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Payable Basic Salary</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Gross Salary</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">Gratuity</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">TDS</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">SST</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">P.F Deduction</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">Insurance Prem.</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">Adv. Deduction</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">Loan Deduction</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">Dormitory</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold text-danger">Meal</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Monthly Payable</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Errors Adjust(+/-)</td>

        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Net Salary</td>
        <td style="font-weight: bold;border: 1px solid black;background: #359cd9" class="text-bold">Remarks</td>
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

    @foreach($payrolldetails as $sk => $sv)
        <tr>
            <td style="border: 1px solid black;" class="col-sm-1 text-center">{{$sk+1}}.
            </td>
            <td style="border: 1px solid black;" class="col-sm-1 text-center text-primary">#{{ $sv->user->emp_id}}
            </td>
            <td style="border: 1px solid black;">{{ $sv->user->first_name.' '.$sv->user->last_name }}</td>
            <td style="border: 1px solid black;">{{ $sv->user->designation->designations }}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->total_days}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->attendance}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->paid_leaves}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->absent}}</td>
            <td style="border: 1px solid black;">{{$sv->actual_salary}}
            </td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->t_basic}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->salary_grade}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->pf_contribution}}</td>


            @foreach($sv->paidAllowances as $allowance)
                <td data-toggle="tooltip" style="border: 1px solid black;">
                    {{$allowance->salary_payment_allowance_value}}
                </td>
            @endforeach
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->incentive}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->dashain_allowance}}
            </td>

            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->payable_basic}}</td>

            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->total_after_allowance}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->gratuity}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->tds}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->sst}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->pf}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->insurance_premium}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->advance_deduction}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->loan_deduction}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->dormitory}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->meal}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->monthly_payable_amount}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->error_adjust}}
            </td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->net_salary}}</td>
            <td style="border: 1px solid black;" data-toggle="tooltip">{{$sv->remarks}}</td>
        </tr>


        <?php
        $total_basic_sal = $total_basic_sal + $template->basic_salary;
        $total_net_sal = $total_net_sal + $net_salary;
        $total_overtime = $total_overtime + $overtime_money;

        ?>

    @endforeach

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
