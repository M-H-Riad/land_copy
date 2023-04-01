<html>
<head>
    <title>Department Bonus Summery - {!! $monthData->title !!}</title>
    <link rel="stylesheet" href="{{asset('/custom/css/pdf-common.css')}}">

    <style type="text/css" href="">

    </style>
</head>
<body>
@if(isset($data))
    <table>
        <thead>
        <tr>
            <th colspan="5"><b>Bonus</b></th>
            <th ><b>DEDUCTION</b></th>
            <th></th>
        </tr>
        <tr>

            <th width="5%">Sl. No.</th>
            <th width="30%" style="text-align: center">
                Name of Division
            </th>
            <th width="10%">
                Division Code
            </th>
            <th width="10%">
                Total Employee
            </th>
            <th width="15%">
                Festival Bonus
            </th>
            <th width="15%">
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
            'festival_bonus'        => 0,
            'rev_stamp'             => 0,
            'net_payable'           => 0,
            'employees'             => 0,
        ];
        $i = 1;
        ?>
        @foreach($data as $row)
            <tr>
                <td>
                    {{$i++}}
                </td>
                <td style="text-align: center">
                    {{$row->department_name}}
                </td>
                <td style="text-align: center">
                    {{$row->old_id}}
                </td>
                <td style="text-align: center">
                    {{$row->employees}}
                </td>
                <td class="right">
                    {{number($row->festival_bonus)}}
                </td>
                <td class="right">
                    {{$row->rev_stamp >0 ? number($row->rev_stamp) : 0}}
                </td>
                <td class="right">
                    <b> {{$row->net_payable > 0 ?  number($row->net_payable) : number($row->festival_bonus)}}</b>
                </td>
            </tr>
            <?php
            $total = [
                'festival_bonus'        => $row->festival_bonus + $total['festival_bonus'],
                'rev_stamp'             => $row->rev_stamp + $total['rev_stamp'],
                'net_payable'           => ($row->net_payable > 0 ? $row->net_payable : $row->festival_bonus ) + $total['net_payable'],
                'employees'             => $row->employees + $total['employees']
            ];
            $row = []
            ?>
        @endforeach
        </tbody>

        <tfoot>
        <tr class="right">
            <td> </td>
            <td style="text-align: right" colspan="3">
                <strong>Total:</strong> Number of
                Employee >> {{$total['employees']}}
            </td>

            <td class="right">
                {{number($total['festival_bonus'])}}
            </td>
            <td class="right">
                {{ $total['rev_stamp'] > 0 ?  number($total['rev_stamp']) : 0 }}
            </td>

            <td class="right">
                {{number($total['net_payable'])}}
            </td>
        </tr>
        </tfoot>
    </table>
@endif