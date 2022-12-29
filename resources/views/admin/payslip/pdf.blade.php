<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ env('APP_COMPANY')}} | Payslip</title>
    <style type="text/css">
        @font-face {
            font-family: Arial;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        /*.item-detail td,th{*/
        /*    border:1px solid #eee;*/
        /*}*/
        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 18cm;
            height: 24.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 5px;
        }

        .border-table th,
        .border-table td {
            padding: 3px;
            text-align: left;
            border: 1px solid #AAAAAA!important;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: left;
        }

        table td h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        /*table tbody tr:last-child td {*/
        /*    border: none;*/
        /*}*/

        /*table tfoot td {*/
        /*    padding: 5px 10px;*/
        /*    background: #FFFFFF;*/
        /*    border-bottom: none;*/
        /*    font-size: 1em;*/
        /*    white-space: nowrap;*/
        /*    border-top: 1px solid #AAAAAA;*/
        /*}*/

        /*table tfoot tr:first-child td {*/
        /*    border-top: none;*/
        /*}*/

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1em;
            /*border-top: 1px solid #57B223;*/
            font-weight: bold;

        }

        /*table tfoot tr td:first-child {*/
        /*    border: none;*/
        /*}*/

        .text-center {
            text-align: center;
        }

        .bg-gray {
            background-color: #d2d6de !important;
        }

        div {
            line-height: 18px;
        }
    </style>
</head>
<body>
<?php
$chosen_date = explode('-', $slip->payroll->date);
$year = $chosen_date[0];
$month = $chosen_date[1];
$monthsName = ['Baisakh', 'Jestha', 'Ashadh', 'Shrawan', 'Bhadra', 'Ashwin', 'Kartik', 'Mangsir', 'Paush', 'Magh', 'Falgun', 'Chaitra'];

?>
            <h2 class="page-header">
                <div style="text-align: center;">
                    <div style="font-weight:bold">
                        {{$slip->payroll->department->division->name}}
                    </div>
                    <h3>
                    <div style="font-weight:bold">
                        Salary Summary
                    </div>
                    <div style="font-weight:bold">
                        For the month of {{$monthsName[$month-1]}}, {{$year}}
                    </div>
                    </h3>
                </div>
            </h2>
            <!-- info row -->
                <table>
                    <tr>
                        <td style="width: 50%;">
                            <strong>Name: </strong>{{$slip->user->full_name}}
                        </td>
                        <td style="width: 50%;">
                            <strong>Emp. Id:</strong> {{$slip->user->emp_id}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">
                            <strong>Designation: </strong>{{$slip->user->designation->designations}}
                        </td>
                        <td style="width: 50%;">
                            <strong>Department:</strong> {{$slip->user->department->deptname}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">
                            <strong>Marital Status: </strong>{{$slip->user->emp_id}}
                        </td>
                        <td style="width: 50%;">
                            <strong>Payable Days:</strong> {{$slip->paid_leaves+($slip->attendance)}}
                        </td>
                    </tr>
                </table>

<div style="width: 100%; display: table;margin-top: 20px">
    <div style="display: table-row">
        <div style="width: 48%;display: table-cell">
<table class="border-table">
    <thead>
    <tr>
{{--        <th style="text-align: right;width:5%">S.No</th>--}}
        <th  style="font-weight:bold;width:30%">Salary & Allowances</th>
        <th  style="font-weight:bold;width:20%">Amount({{env('APP_CURRENCY')}})</th>
{{--        <th style="width:25%">Deduction</th>--}}
    </tr>
    </thead>
    <tbody>
    <?php
    $sno=1;

    ?>

    @foreach($slip->paidAllowances as $odk => $odv)
        <tr>
{{--            <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
            <td  style="width:30%">{{$odv->salary_payment_allowance_label}}</td>
            <td  style="width:20%">{{$odv->salary_payment_allowance_value}}</td>
{{--            <td style="width:25%">-</td>--}}
        </tr>
    @endforeach
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">PF Contribution</td>
        <td  style="width:20%">{{$slip->pf_contribution}}</td>
{{--        <td style="width:25%">-</td>--}}
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">Incentive</td>
        <td  style="width:20%">{{$slip->incentive}}</td>
{{--        <td style="width:25%">-</td>--}}
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">Dashain Allowance</td>
        <td  style="width:20%">{{$slip->dashain_allowance}}</td>
{{--        <td style="width:25%">-</td>--}}
    </tr>
    <tr>
        <?php
        $allowance_sum=$slip->paidAllowances->sum('salary_payment_allowance_value');
        $total_allowance=$slip->dashain_allowance+$slip->incentive+$slip->pf_contribution+$allowance_sum;
        ?>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="font-weight:bold;width:30%">Total</td>
        <td  style="font-weight:bold;width:20%">{{$total_allowance}}</td>
{{--        <td style="width:25%">-</td>--}}
    </tr>
    </tbody>
</table>
        </div>
    <div style="width: 4%;display: table-cell"></div>
        <div style="width: 48%;display: table-cell">
        <table class="border-table">
    <thead>
    <tr>
        {{--        <th style="text-align: right;width:5%">S.No</th>--}}
        <th  style="font-weight:bold;width:30%">Deductions</th>
        <th  style="font-weight:bold;width:20%">Amount({{env('APP_CURRENCY')}})</th>
        {{--        <th style="width:25%">Deduction</th>--}}
    </tr>
    </thead>
    <tbody>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">PF Deduction</td>
{{--        <td  style="width:20%">-</td>--}}
        <td style="width:25%">{{$slip->pf}}</td>
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">Insurance</td>
{{--        <td  style="width:20%">-</td>--}}
        <td style="width:20%">{{$slip->insurance_premium}}</td>
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">Loan</td>
{{--        <td  style="width:20%">-</td>--}}
        <td style="width:20%">{{$slip->loan_deduction}}</td>
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">Advance</td>
{{--        <td  style="width:20%">{{$slip->advance_deduction}}</td>--}}
        <td style="width:20%">{{$slip->advance_deduction}}</td>
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">Dormitory</td>
{{--        <td  style="width:20%">{{$slip->dormitory}}</td>--}}
        <td style="width:20%">{{$slip->dormitory}}</td>
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">Meal</td>
{{--        <td  style="width:20%">{{$slip->meal}}</td>--}}
        <td style="width:20%">{{$slip->meal}}</td>
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">Gratuity</td>
{{--        <td  style="width:20%">{{$slip->gratuity}}</td>--}}
        <td style="width:20%">{{$slip->gratuity}}</td>
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">TDS</td>
{{--        <td  style="width:20%">-</td>--}}
        <td style="width:20%">{{$slip->tds}}</td>
    </tr>
    <tr>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="width:30%">SST</td>
{{--        <td  style="width:20%">-</td>--}}
        <td style="width:20%">{{$slip->sst}}</td>
    </tr>
    <tr>
        <?php
        $total_deduction=$slip->sst+$slip->tds+$slip->gratuity+$slip->meal+$slip->dormitory+
            $slip->advance_deduction+$slip->loan_deduction+$slip->insurance_premium+$slip->pf;
        ?>
{{--        <td style="text-align: center;width:5%">{{$sno++}}</td>--}}
        <td  style="font-weight:bold;width:30%">Total</td>
{{--        <td  style="width:20%">-</td>--}}
        <td style="font-weight:bold;width:20%">{{number_format($total_deduction,2)}}</td>
    </tr>
    </tbody>
</table>
        </div>
</div>
</div>

<div style="width: 100%; display: table;justify-content: space-between">
    <div style="display: table-row">
    <div style="font-weight: bold;display: table-cell">Thank you very much for your endeavour !</div>
    <div style="font-weight: bold;display: table-cell;text-align: right">Net Salary Payable: {{$slip->net_salary}}</div>
    </div>
</div>
<hr style="margin-bottom: 20px">
                <div style="width: 100%; display: table;">
                    <div style="display: table-row">
                <div style="width: 33%;display: table-cell">
                    <div style="margin-top: 5px;" >______________</div>
                    <div style="font-weight: bold;">Finance Manager</div>
                </div>
                    <div style="width: 33%;display: table-cell;">
                        <div style="margin-top: 5px;">______________</div>
                        <div style="font-weight: bold;">General Manager</div>
                       </div>
                    <div style="width: 33%;display: table-cell">
                        <div>
                            <div style="margin-top: 5px;">______________</div>
                            <div style="font-weight: bold;">Receiver's Signature</div>
                            </div>
                    </div>
            </div>
                </div>
</body>
</html>
