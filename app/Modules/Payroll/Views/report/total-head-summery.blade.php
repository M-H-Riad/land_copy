<html>
<head>
    <title>Monthly Salary Report : {{$monthData->title}} </title>
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
    </style>
</head>
<body>
{{--<div style="width: 50%;font-size:10px; margin-left: 20px;">--}}
{{--    Summary for: <b>{{$monthData->title}}</b>--}}
{{--</div>--}}
@if(isset($data))
    <div class="summery-table">

        <table>
            <tr>
                <th class="left">#</th>
                <th class="left">Salary & Allowance</th>
                <th class="right">Amount</th>
            </tr>

            <?php $rows = $payrollHeads->where('type','allowance'); ?>
            <?php $total = 0;?>
            @foreach($rows as $key=>$row)

                <tr>
                    <td>{{++$key}}</td>
                    <td class="left">{{$row->title}}</td>
                    <td class="right">@if($row->db_field){{numberWithZero( $data->{$row->db_field} ) }}@endif</td>
<!--                    --><?php //$total += $data->{$row->db_field} ?>
                </tr>
            @endforeach

            <tr>
                <td>{{++$key}}</td>
                <td class="left"> Pension Reserve Amount</td>
                <?php $pra =  ($data->basic_pay * 35)/100;  $totalGross = $data->gross_pay + $pra ;?>
                <td class="right">{{ numberWithZero($pra) }}</td>
            </tr>

            <tr>
                <td class="left"></td>
                <td class="left"><b>Total</b></td>
                <td class="right"><b>{{numberWithZero( $totalGross ) }}</b></td>
            </tr>

        </table>
    </div>
    <div class="summery-table">

        <table>
            <tr>
                <th class="left">#</th>
                <th class="left">Deduction</th>
                <th class="right">Amount</th>
            </tr>
            <?php $total = 0;?>
            <?php $i=0; ?>
            <?php $rows = $payrollHeads->where('type','deduction'); ?>
            @foreach($rows as $key=>$row)

                <tr>
                    <td>{{++$i}}</td>
                    <td class="left">{{$row->title}}</td>
                    <td class="right">@if($row->db_field){{numberWithZero( $data->{$row->db_field} ) }}@endif</td>

<!--                    --><?php //$total += $data->{$row->db_field} ?>
                </tr>
            @endforeach

            <tr>
                <td>{{++$i}}</td>
                <td class="left"> Pension Reserve Amount</td>
                <?php $totalDeduction = $data->total_ded + $pra ;?>
                <td class="right">{{ numberWithZero($pra)  }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="left"><b>Total</b></td>
                <td class="right"><b>{{numberWithZero( $totalDeduction ) }}</b></td>
            </tr>
        </table>
    </div>
    <div class="summery-table">
        <table>
            <tr>
                <th colspan="3">Summary</th>
            </tr>

            <?php $i=1; ?>
            <tr>
                <td>{{$i++}}</td>
                <td>Total Employee</td>
                <td class="right">{{$data->employees}}</td>
            </tr>
            <tr>
                <td>{{$i++}}</td>
                <td>Gross Pay</td>
                <td class="right">{{numberWithZero($totalGross)}}</td>
            </tr>
            <tr>
                <td>{{$i++}}</td>
                <td>Total Deduction</td>
                <td class="right">{{numberWithZero($totalDeduction)}}</td>

            </tr>
            <tr>
                <td>{{$i++}}</td>
                <td>Net Payable Amount</td>
                @php  $netPayable = $totalGross - $totalDeduction @endphp
                <td class="right">{{numberWithZero($netPayable)}}</td>
            </tr>
        </table>
        <?php
        $poisaNumber = 0;
        $poisa = explode('.',number($netPayable));
        if(isset($poisa[1])){
            $poisaNumber = $poisa[1];
        }
        ?>
        <span style="font-size: 11px">In Word:<br/> {{convert_number(($netPayable)) .' taka and '.convert_number($poisaNumber)}} Poisha</span>
    </div>
@endif