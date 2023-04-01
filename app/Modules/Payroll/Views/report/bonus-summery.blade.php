<html>
<head>
    <title>Festival Bonus Report</title>
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
@if(isset($departmentGroup))
<div style="width: 50%;font-size:10px; margin-left: 20px;">
    Summary for: <b>{{$departmentGroup->group_name}}</b>
</div>
@endif
@if(isset($data))

    <div style="width: 100%;margin-left: 20px;padding: 10px 0px;">
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
                <td>{{$bonusData->title}} (Bonus)</td>
                <td class="right">{{numberWithZero($data->festival_bonus)}}</td>
            </tr>
            <tr>
                <td>{{$i++}}</td>
                <td>Rev. Stamp (Deduction)</td>
                <td class="right">{{numberWithZero($data->rev_stamp)}}</td>
            </tr>
            <tr>
                <td>{{$i++}}</td>
                <td>Net Payable Amount</td>
                <td class="right">{{numberWithZero($data->net_payable > 0 ? $data->net_payable : $data->festival_bonus )}}</td>
            </tr>
        </table>
        <?php
        $poisaNumber = 0;
        $amount = $data->net_payable > 0 ? $data->net_payable : $data->festival_bonus;
        $poisa = explode('.',number($amount));
        if(isset($poisa[1])){
            $poisaNumber = $poisa[1];
        }
        ?>
        <p style="font-size: 11px;padding-top: 10px">In Word:<br/> {{convert_number(($data->net_payable > 0 ? $data->net_payable : $data->festival_bonus)) .' taka and '.convert_number($poisaNumber)}} Poisha</p>
    </div>
@endif