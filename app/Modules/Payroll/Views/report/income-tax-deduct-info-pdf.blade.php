<html>
<head>
    <title>Income Tax Deduction Information - {{ $incomeTaxReport->title }}</title>
    <link rel="stylesheet" href="{{asset('/custom/css/pdf-common.css')}}">

    <style type="text/css" href="">

    </style>
</head>
<body>
@if(isset($incomeTaxes))
    <table>
        <thead>
        <tr>
            <th width="3%">Sl. No.</th>
            <th width="7%" style="text-align: left">
                Account No.
            </th>
            <th width="5%" style="text-align: left">

                P.F. NO.

            </th>
            <th width="14%" style="text-align: left">

                Name of Employee

            </th>
            <th width="15%" style="text-align: left">
                Designation
            </th>
            <th width="5%" style="text-align: left">
                Basic Pay
            </th>

            <th width="15%" style="text-align: left">
                Department
            </th>
            <th width="9%" style="text-align: left">
                Taxpayer's Id.No
            </th>
            <th  width="8%">
                <b>IT Deduct</b>
            </th>
            <th  width="9%">
                <b>IT Arrears Deduct</b>
            </th>
            <th width="10%">
                <b>Amount Tk Remark</b>
            </th>
        </tr>
        </thead>
        <tbody>
{{--        {{dd($incomeTaxes)}}--}}
        <?php
        $total = [

            'it_ded'               => 0, // $row['f_bonus'] + $total['f_bonus'],

        ];
        ?>
        @foreach($incomeTaxes as $key=>$row)

            <tr>
                <td>
                    {{++$key}}
                </td>
            <?php $empData = (array) json_decode($row->employee_data); ?>
                @if(isset($empData['name']))
                    <td class="left">
                        {{$empData['bank_acc']}}
                    </td>
                    <td class="left">
                        {{$empData['pfno']}}
                    </td>
{{--                {{dd($row->net_payable)}}--}}
                    <td class="left">
                        {{$empData['name']}}
                    </td>
                    <td class="left">
                        {{$empData['designation']}}
                    </td>
                    <td class="left">
                        {{$empData['basic_pay']}}
                    </td>
                    <td class="left">
                        {{$empData['department']}}
                    </td>
                @endif

                <td class="left">
                    {{ $row->tin }}
                </td>
                <td style="text-align: center;">
                    {{$row->it_ded ?? 0}}
                </td>
                <td style="text-align: center;">
                    {{$row->it_arrear_ded ?? 0}}
                </td>
                <td style="text-align: center;">
                    {{$row->it_ded + $row->it_arrear_ded}}
                </td>
{{--                {{dd($row)}}--}}
            </tr>
            <?php

            $total = [
                'it_ded'               => $row->it_ded + $row->it_arrear_ded + $total['it_ded'],
            ];
            ?>
        @endforeach
        </tbody>

        <tfoot>
        <tr class="right">
            <td> </td>
            <td colspan="9" style="text-align: right">
                <b >Grand Total Tk. :</b>
            </td>

            <td style="text-align: center;">
                <b> {{number($total['it_ded'])}}</b>
            </td>
        </tr>
        </tfoot>
    </table>
@endif