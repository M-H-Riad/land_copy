<html>
<head>
    <style type="text/css">

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
        }

    </style>
</head>
<body>
    <?php $i=1; $grandTotal = 0 ;  $void_date = Date('d M,Y', strtotime("+3 days")); ?>
    @foreach($departments as $department)
        @if($department->overtimeEmployee->count())
            @php $total = 0 ; @endphp
            @foreach($department->overtimeEmployee as $employee)
                @php
                    $total += $employee->overtime ;
                @endphp

            @endforeach
            <?php
            $poisaNumber = 0;
            $poisa = explode('.',number($total));
            if(isset($poisa[1])){
                $poisaNumber = $poisa[1];
            }
            ?>
            @if($department_id && $i=1)
                <div style="font-size: 13px;">

                    <p>Memo No. @if($overtimeDepartment->memo_no) {{$overtimeDepartment->memo_no}} @endif</p>
                    <br>  <br>
                    <p>The Manager</p>
                    <p>Janata Bank Limited</p>
                    <p>Karwan Bazar Corporate Branch</p>
                    <p>Dhaka</p>
                    <br>
                    <p><strong>Subject: Advice for Transfer of Tk.={{$total}} Only</strong></p>
                    <p> ({{convert_number(($total)) .' Taka and '.convert_number($poisaNumber)}} Poisha only)</p>
                    <p>@if($void_date)(This advice will be automatically void on or after date <strong> {{ $void_date }}</strong>.) @else &nbsp;@endif </p>
                    <br><br>
                    <p>Dear Sir :</p>
                    <br>
                    <p>We are pleased to authorize your good bank to make transfer of Tk.=<strong>{{$total}}</strong>   ({{convert_number(($total)) .' Taka and '.convert_number($poisaNumber)}} Poisha)
                        from <strong> Account Number {{$overtimeDepartment->bank_account_number}} </strong> , OT to the <strong> {{$department->overtimeEmployee->count()}} employees </strong> of DWASA as per attached statement.
                        This is Overtime Bill of {{ $department->department_name }} Dhaka WASA for the month of <strong> {{$title}} </strong> .</p>

                    <br><br>
                    <p>You are requested to activate the above advice immediately with confirmation to the undersigned.</p>
                    <br><br>
                    <p style="text-align: center">Best regards,</p>
                    <br>
                    <table style="border: none">
                        <tr>
                            <td style="text-align: center; border: none">
                                <br/>
                                _________________________________<br/>
                                @if($total <= 50000)
                                    Accounts Officer
                                @elseif ($total > 50000 && $total <= 100000)
                                    Deputy Chief Accounts Officer
                                @else
                                    Chief Accounts Officer
                                @endif


                                <br/>
                                Dhaka WASA
                            </td>
                            <td style="text-align: center;border: none">
                                <br/>
                                _________________________________<br/>
                                @if($total <= 50000)
                                    Deputy Chief Accounts Officer
                                @elseif ($total > 50000 && $total <= 100000)
                                    Chief Accounts Officer
                                @else
{{--                                    Commercial Manager--}}
                                    Director (Finance)
                                @endif
                                <br/>
                                Dhaka WASA
                            </td>
                        </tr>
                    </table>

                    <br><br><br><br>

                    <p>Department name: {{ $department->department_name }}</p>
                    <br>

                    <p> Subject : Overtime Allowance for the month of {{$title}}</p>
                    <br>
                </div>
            @else
                <p style="padding-top: 5px;padding-bottom: 2px"><strong>{{ $department->department_name }}</strong></p>
            @endif
                <table>
                    <thead>
                    <tr>
                        <th>S/L.</th>
                        <th>A/C No.</th>
                        <th>T24 A/C No.</th>
                        <th>PFNO </th>
                        <th>Name </th>
                        <th>Designation</th>
                        <th>Basic Pay</th>
                        <th>S.Hr</th>
{{--                        <th>D.Hr</th>--}}
                        <th>Arrears</th>
                        <th>R.Stamp</th>
                        <th style="text-align: right">NetPay</th>
                    </tr>
                    </thead>
                    <tbody>

                @foreach($department->overtimeEmployee as $employee)
                  @php $info = json_decode($employee->employee_data) @endphp
                  <tr>
                            <td style="width: 5%!important;">{{ $i++ }}</td>
                            <td style="width: 9%!important;">{{ trim($info->bank_account_no)}}</td>
                            <td style="width: 10%!important;">{{ trim($info->bank_account_no_t24)}}</td>
                            <td style="width: 6%!important;">{{ trim($info->pfno)}}</td>
                            <td style="width: 18%!important;">{{  $info->first_name . ' ' . $info->middle_name . ' ' . $info->last_name  }}</td>
                            <td style="width: 18%!important;">{{$employee->designation->title}} </td>
                            <td style="width: 8%!important;">{{$employee->basic_pay}} </td>
                            <td style="width: 5%!important;">{{  $employee->type == "Single" ? $employee->hours : 0 }}  </td>
{{--                            <td style="width: 5%!important;">{{  $employee->type == "Double" ? $employee->hours : 0 }}  </td>--}}
                            <td style="width: 8%!important;"> {{ $employee->allowance }}  </td>
                            <td style="width: 5%!important;"> 10  </td>
                            <td style="width: 8%!important;text-align: right">{{ $employee->overtime }}  </td>
                  </tr>
                @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="10" style="text-align: right">

                            <strong> {{ $department_id ? 'Total': 'Department Total'  }}:</strong>
                        </td>
                        <td style="text-align: right">
                           <strong> {{ $total }}</strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
               @php
                 $grandTotal += $total;
               @endphp
        @endif
    @endforeach
    @if($department_id)
        <p style="text-align: right;    font-size: 13px;">In Word:  {{convert_number(($total)) .' Taka and '.convert_number($poisaNumber)}} Poisha Only</p>
     @else <p style="text-align: right;    font-size: 13px;"><strong >Grand Total : {{$grandTotal}}</strong></p>@endif
</body>
</html>