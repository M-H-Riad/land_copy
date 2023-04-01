<html>
<head>
    <title>@if(isset($bonusData)){!!  $bonusData->title !!} - @endif Festival Bonus Report</title>
    <link rel="stylesheet" href="{{asset('/custom/css/pdf-common.css')}}">

    <style type="text/css" href="">

    </style>
</head>
<body>
@if(isset($data))
    <table>
        <thead>
        <tr>
{{--            <th colspan="7"><b>MIS & Billing Department</b></th>--}}
            <th colspan="10"><b>Bonus</b></th>

        </tr>
        <tr>
            <th width="5%">Sl. No.</th>
            <th width="15%" style="text-align: left">
                Name of Employee
            </th>
            <th width="7%" style="text-align: left">
                PF No.
            </th>
            <th width="17%" style="text-align: left">
                Designation
            </th>
            <th width="5%" style="text-align: left">
              Grade
            </th>
            <th width="11%" style="text-align: left">
                Bank A/C No
            </th>
            <th width="9%">
                Basic Pay
            </th>
            <th width="10%">
               Festival Bonus
            </th>
            <th width="8%">
                Rev.Stamp
            </th>
            <th>
                <b>Net Payable</b>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = [

            'bonus'               => 0,
            'rev_stamp'           => 0,
            'net_payable'         => 0,

        ];
        ?>
        @foreach($data as $key=>$row)
            <tr>
                <td>
                    {{++$key}}
                </td>
                    <?php $empData = json_decode($row->employee_data); ?>
                    @if(isset($empData->name))
                <td>
                        {{$empData->name}}

                </td>
                <td class="left">
                    {{$empData->pfno}}
                </td>
                <td class="left">
                    {{$empData->designation}}
                </td>
                    <td class="left">
                    {{$empData->grade}}
                </td>
                <td class="left">
                    {{$empData->bank_acc}}
                </td>
                @endif
                <td class="right">
                    {{number($row->basic_pay)}}
                </td>
                <td class="right">
                    {{number($row->bonus)}}
                </td>
                <td class="right">
                    {{$row->rev_stamp >0 ? number($row->rev_stamp) : 0}}
                </td>
                <td class="right">
                    <b> {{$row->net_payable > 0 ?  number($row->net_payable) : number($row->bonus)}}</b>
                </td>
            </tr>
            <?php
            $row = $row->toArray();
            $total = [
                'bonus'               => $row['bonus'] + $total['bonus'],
                'rev_stamp'           => $row['rev_stamp'] + $total['rev_stamp'],
                'net_payable'         => ($row['net_payable'] > 0 ? $row['net_payable'] :  $row['bonus']) + $total['net_payable'],
            ];
            ?>
        @endforeach
        </tbody>

        <tfoot>
        <tr class="right">
            <td> </td>
            <td colspan="6" style="text-align: right">
                <b >Total:</b>
            </td>

            <td class="right">
                <b> {{number($total['bonus'])}}</b>
            </td>
            <td class="right">
                <b> {{ $total['rev_stamp'] > 0 ? number($total['rev_stamp']) : 0 }}</b>
            </td>
            <td class="right">
                <b> {{number($total['net_payable'])}}</b>
            </td>
        </tr>
        </tfoot>
    </table>
@endif