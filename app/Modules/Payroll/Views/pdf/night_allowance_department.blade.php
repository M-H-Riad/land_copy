<html>
<head>
    <style type="text/css">
        body{
            font-family: sans-serif;
        }
        table{
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
        }
        thead { display: table-header-group }
        table tr{
            /*margin-top: 5px;*/
        }

        th{

            /*border: 1px solid #cbd2db;*/
            font-size: 11px;
            text-align: left;
            border: none;
            border-bottom: 2px dotted #cbd2db;
        }
        table.no-border th{
            border: none;
        }
        td{
            padding-left: 2px;
            font-size: 11px;
            vertical-align: top;
            color: #000000;
            border: none;
            border-bottom: 2px dotted #cbd2db;
        }

        h2{
            color: black;
            font-weight: normal;
        }
        p{
            color: black;
            margin: 0px;
            padding: 0px;
            line-height: 1.5;
        }

    </style>
</head>
<body>

<?php  $i = 1; $void_date =   request('date') != null ?  Date('d M,Y', strtotime(request('date')))  :  Date('d M,Y', strtotime("+3 days")); $totalNight = 0?>

    @if($nightAllowanceEmployee->count() >0 )
        @php $total = 0 ; @endphp
        @foreach($nightAllowanceEmployee as $employee)
            @php
                $total      += $employee->night_allowance ;
                $totalNight += $employee->nights ;
            @endphp

        @endforeach
        <?php
        $poisaNumber = 0;
        $poisa = explode('.',number($total));
        if(isset($poisa[1])){
            $poisaNumber = $poisa[1];
        }

        ?>
            <div style="font-size: 13px;">

                <p>Memo No. @if($nightAllowanceDepartment->memo_no) {{ $nightAllowanceDepartment->memo_no }} @endif</p>
                <br>  <br>
                <p>The Manager</p>
                @if($dG != null)
                    <p> {{ $dG->bank }}</p>
                    <p> {{ $dG->branch }}</p>
                    <p> {{ $dG->location }}</p>
                @else
                    <p>Janata Bank Limited</p>
                    <p>Karwan Bazar Corporate Branch</p>
                    <p>Dhaka</p>
                @endif
                <br>
                <p><strong>Subject: Advice for Transfer of Tk.={{$total}} Only</strong></p>
                <p> ({{convert_number(($total)) .' Taka and '.convert_number($poisaNumber)}} Poisha only)</p>
                <p>@if($void_date)(This advice will be automatically void on or after date   <strong> {{ $void_date }}</strong>.) @else &nbsp;@endif </p>
                <br><br>
                <p>Dear Sir :</p>
                <br>
                <p>We are pleased to authorize your good bank to make transfer of Tk.=<strong> {{$total}}</strong>  ({{convert_number(($total)) .' Taka and '.convert_number($poisaNumber)}} Poisha)
                    from<strong>  Account Number {{$nightAllowanceDepartment->bank_account_number}}</strong> , Night Bill to the<strong>  {{$nightAllowanceEmployee->count()}} employees </strong> of DWASA as per attached statement.
                    This is Night Allowance Bill of {{ $nightAllowanceDepartment->title }} Dhaka WASA for the month of <strong>{{$title}}</strong>.</p>

                <br><br>
                <p>You are requested to activate the above advice immediately with confirmation to the undersigned.</p>
                <br><br> <br><br>
                <p style="text-align: center">Best regards,</p>
                <br>  <br>
                <table style="border: none">
                    <tr>
                        <td style="text-align: center; border: none">
                            <br/>
                            _________________________________<br/>
                            @if($total <= 300000)
                                Accounts Officer<br/>or<br/>Finance Officer
                            @elseif ($total > 300000 && $total <= 1000000)
                                Deputy Chief Accounts Officer<br/>or<br/>Deputy Chief Finance Officer
                            @else
                                Chief Accounts Officer
                            @endif
                            <br/>
                            Dhaka WASA
                        </td>
                        <td style="text-align: center;border: none">
                            <br/>
                            _________________________________<br/>
                            @if($total <= 300000)
                                Deputy Chief Accounts Officer<br/>or<br/>>Deputy Chief Finance Officer
                            @elseif ($total > 300000 && $total <= 1000000)
                                Chief Accounts Officer
                            @else
                                Director (Finance)<br/>or<br/>Deputy Managing Director (Finance)
                            @endif
                            <br/>
                            Dhaka WASA
                        </td>
                    </tr>
                </table>
                <br><br><br><br><br>
                <br><br><br><br><br>
                <br><br><br><br><br>
                <br><br><br><br><br>

                <p>Department name: {{ $nightAllowanceDepartment->title }}</p>
                <p> Subject: Night Allowance for the month of {{$title}}</p>
                <br>
            </div>

        <table>
            <thead>
            <tr>
                <th>S/L.</th>
                <th>A/C No.</th>
                <th>T24 A/C No.</th>
                <th>PFNO </th>
                <th>Name </th>
                <th>Designation</th>
                <th>Night</th>
                <th>Arrears</th>
                <th>R.Stamp</th>
                <th style="text-align: right">NetPay</th>
            </tr>
            </thead>
            <tbody>

            @foreach($nightAllowanceEmployee as $employee)
                @php $info = json_decode($employee->employee_data) @endphp
                <tr>
                    <td style="width: 5%!important;">{{ $i++ }}</td>
                    <td style="width: 10%!important;">{{ trim($info->bank_account_no)}}</td>
                    <td style="width: 12%!important;">{{ trim($info->bank_account_no_t24)}}</td>
                    <td style="width: 6%!important;">{{ trim($info->pfno)}}</td>
                    <td style="width: 18%!important;">{{  $info->first_name . ' ' . $info->middle_name . ' ' . $info->last_name  }}</td>
{{--                    <td style="width: 18%!important;">{{$employee->designation->title}} </td>--}}
                    <td style="width: 18%!important;">{{ isset($info->old_designation) ? trim($info->old_designation) : $employee->designation->title}}</td>
                    <td style="width: 7%!important;">{{$employee->nights}}  </td>
                    <td style="width: 10%!important;">{{$employee->allowance}} </td>
                    <td style="width: 5%!important;"> 10  </td>
                    <td style="width: 10%!important;text-align: right">{{ $employee->night_allowance }}  </td>
                </tr>

            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" style="text-align: right">

                    <strong> {{ $department_id ? 'Total Nights': 'Department Total Nights'  }}:</strong>
                </td>
                <td >
                    <strong> {{ $totalNight }}</strong>
                </td>
                <td colspan="2" style="text-align: right">

                    <strong> {{ $department_id ? 'Total': 'Department Total'  }}:</strong>
                </td>
                <td style="text-align: right">
                    <strong> {{ $total }}</strong>
                </td>
            </tr>
            </tfoot>
        </table>

    @endif

    @if( $total > 0) <p style="text-align: right;    font-size: 13px;">In Word:  {{convert_number(($total)) .' Taka and '.convert_number($poisaNumber)}} Poisha only.</p>@endif

</body>
</html>