<html>
<head>
    <title>Bank Report - {{trim($departmentGroup->group_name)  .' '.  $monthData->title }}</title>
    {{--    <link rel="stylesheet" href="{{asset('/custom/css/pdf-common.css')}}">--}}

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
            line-height: 1.8;
        }

    </style>
</head>
<body>

@if(isset($results))

    @php $total = 0 ; $i = 0 ; $void_date =   request('date') != null ?  Date('d M,Y', strtotime(request('date')))  :  Date('d M,Y', strtotime("+3 days"));@endphp
    @foreach($results as $row)
        @php
            $i++;
           $total += $row->net_payable ;
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
        <div style="width: 40%;text-align: right;float: right">
            {{date('F d,Y')}}
        </div>
        <p>Memo No. 46.113.317.00.00.{{date('Y')}}/</p>

        <br>  <br>
        <p>The Manager</p>
        <p> {{ $departmentGroup->bank }}</p>
        <p> {{ $departmentGroup->branch }}</p>
        <p> {{ $departmentGroup->location }}</p>
        <br>
        <p><strong>Subject: Advice for Transfer of Tk.={{number($total)}} Only</strong></p>
        <p> ({{convert_number(($total)) .' Taka and '.convert_number($poisaNumber)}} Poisha only)</p>
        <p>@if($void_date)(This advice will be automatically void on or after date <strong> {{ $void_date }}</strong>.) @else &nbsp;@endif </p>
        <br><br>
        <p>Dear Sir :</p>
        <br>
        <p>We are pleased to authorize your good bank to make transfer of Tk.=<strong>{{number($total)}}</strong> ({{convert_number(($total)) .' Taka and '.convert_number($poisaNumber)}} Poisha)
            from <strong>Account Number  {{$departmentGroup->ac_number}}</strong>, to the <strong>{{ $i }} employees</strong> of DWASA as per attached statement.
            This is salary & allowance of {{ $departmentGroup->group_name }} Division for the month of <strong>{{$monthData->title}}</strong>.</p>

        <br><br>
        <p>You are requested to activate the above advice immediately with confirmation to the undersigned.</p>
        <br><br>  <br>  <br>
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
    </div>

@endif
</body>
</html>