<html>
<head>
    <title>Income Tax Report</title>
    <link rel="stylesheet" href="{{asset('/custom/css/pdf-common.css')}}">

    <style type="text/css" href="">

        .summery-table table{
            /*width: 30%;*/
            /*border-collapse: collapse;*/
            font-family: sans-serif;
            line-height: 1.5;
            font-size: 12px;
            margin: 20px;
        }
        .summery-table{
            float: left;
            width: 32%;

        }
        .summery-table th{
            font-weight: bold;
        }
        .left{
            text-align: left;
        }
        th ,td {
            border: 1px solid #cbd2db!important;
            font-size: 12px;
        }
    </style>

</head>
<body>
<div style="width: 100%;font-size:10px;padding-bottom: 5px">
    Printing Date: {{date('d-m-Y h:i:s A')}}
</div>
@if(isset($employee))
    <table class="table">
        <tr>
            <th>Name of the Employee</th>
            <th>PFNO</th>
            <th>Taxpayer's Identification Number</th>
            <th>Amount of Tax Deducted (TK)</th>
            <th>Remarks</th>
        </tr>
        <tr>

            <td style="text-align: center">{{$employee->name}}</td>
            <td style="text-align: center">{{$employee->pfno}}</td>
            <td style="text-align: center">{{$employee->tin}}</td>
            <td style="text-align: center">{{number_format($total->income_tax_ded + $total->income_tax_arrear_ded,2)}}</td>
            <td style="text-align: center ;width: 15%"></td>
        </tr>

    </table>
    <div style="padding-top: 10px;padding-bottom: 10px">
        <p class="title" style="text-align: center"><strong>Particulars of Payments Including the above Amount</strong></p>
    </div>
@endif
@if(isset($incomeTaxes))

    <table>
        <thead>
        <tr>
            <th>Month</th>
            <th>Cheque No</th>
            <th>Date</th>
            <th>Total Amount(TK)</th>
            <th>Bank</th>
            <th>Branch</th>
            <th>Account No</th>
        </tr>
        </thead>
        <tbody>
        @foreach($incomeTaxes as $incomeTax)
            @foreach($itMonths as $key => $value)
                @if($value == $incomeTax->payroll_month_id)
                    <tr>
                        <td style="text-align: center; width:15%">{{$incomeTax->title}}</td>
                        <td style="text-align: center; width:15%">{{$incomeTax->cheque_no}}</td>
                        <td style="text-align: center; width:10%">{{$incomeTax->cheque_date}}</td>
                        <td style="text-align: center; width:20%">{{number_format($incomeTax->total_amount,2)}}</td>
                        <td style="text-align: center; width:12%">{{$incomeTax->relBank->bank_name}}</td>
                        <td style="text-align: center; width:15%">{{$incomeTax->relBranch->branch_name}}</td>
                        <td style="text-align: center; width:13%">{{$incomeTax->bank_account_no}}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach

        </tbody>

    </table>

@endif