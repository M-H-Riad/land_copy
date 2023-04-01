<html>
<head>
    <title>Bank Report - @if(isset($departmentGroup)) {{trim($departmentGroup->group_name)}} @else WASA & Drainage @endif  {!!   ' '.  $monthData->title !!} Bonus</title>
    <link rel="stylesheet" href="{{asset('/custom/css/pdf-common.css')}}">

    <style type="text/css" href="">

    </style>
</head>
<body>
@if(isset($results))
    <table>
        <thead>
        <tr>
            <th width="5%">Sl. No.</th>

            <th width="15%" style="text-align: left">
                Account No.
            </th>
            <th width="15%" style="text-align: left">
                T 24 Account
            </th>
            <th width="10%" style="text-align: left">
                PFNO
            </th>
            <th width="20%" style="text-align: left">
                Name of Employee
            </th>
            <th width="20%" style="text-align: left">
                Designation
            </th>

            <th>
                <b>Net Payable</b>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = [

            'net_payable'               => 0, // $row['f_bonus'] + $total['f_bonus'],

        ];
        ?>
        @foreach($results as $key=>$row)

            <tr>
                <td>
                    {{++$key}}
                </td>
                    <td class="left">
                        {{$row->bank_account_no}}
                    </td>
                    <td class="left">
                        {{$row->bank_account_no_t24}}
                    </td>
            <?php $empData = (array) json_decode($row->employee_data); ?>
{{--                {{dd($row->net_payable)}}--}}
                @if(isset($empData['name']))
                    <td class="left">
                        {{$empData['pfno']}}
                    </td>
                    <td class="left">
                        {{$empData['name']}}
                    </td>
                    <td class="left">
                        {{$empData['designation']}}
                    </td>
                @endif
                <td class="right">
                    {{  $row->net_payable > 0 ? number($row->net_payable) : number($row->bonus)   }}
                </td>

            </tr>
            <?php

            $total = [
                'net_payable'               => ($row->net_payable > 0 ? $row->net_payable : $row->bonus) + $total['net_payable'],
            ];
            ?>
        @endforeach
        </tbody>

        <tfoot>
        <tr class="right">
            <td> </td>
            <td colspan="5" style="text-align: right">
                <b >Total:</b>
            </td>

            <td class="right">
                <b> {{number($total['net_payable'])}}</b>
            </td>
        </tr>
        </tfoot>
    </table>
@endif