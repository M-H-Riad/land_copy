<html>
<head>
    <link rel="stylesheet" href="{{asset('/custom/css/pdf-common.css')}}">

    <style type="text/css" href="">

    </style>
</head>
<body>
@if(isset($payrollEmployee))
    <table>
        <thead>
        <tr>
            <th width="5%">Sl. No.</th>
            <th @if($db_field != 'it_ded') width="10%"  @endif  style="text-align: left">

                P.F. NO

            </th>
            <th @if($db_field != 'it_ded') width="12%"  @endif   style="text-align: left">
             Bank A/C No.
            </th>

            <th width="20%" style="text-align: left">

                Name of Employee

            </th>

            <th @if($db_field != 'it_ded') width="18%"  @endif  style="text-align: left">
                Designation
            </th>
            <th @if($db_field != 'it_ded') width="20%"  @endif style="text-align: left">
                Department
            </th>
            @if($db_field == 'it_ded')
                <th class="left">
                    Tin ID
                </th>

                <th class="left">
                    Basic Pay
                </th>
            @endif
            <th class="right" @if($db_field != 'it_ded')  width="15%" @else width="10%" @endif >
                <b>Amount</b>
            </th>
        </tr>
        </thead>
        <tbody>

        @foreach($payrollEmployee as $key=>$row)

            <tr>
                <td>
                    {{++$key}}
                </td>
                <td class="left">
                    {{$row->employee->pfno}}
                </td>
                <td class="left">
                    {{$row->employee->bank_account_no}}
                </td>

                <?php $empData = (array) json_decode($row->employee_data); ?>

                @if(isset($empData['name']))
                    <td class="left">
                        {{$empData['name']}}
                    </td>
                    <td class="left">
                        {{$empData['designation']}}
                    </td>

                    <td class="left">
                        {{$empData['department']}}
                    </td>
                @endif
                @if($db_field == 'it_ded')
                    <td class="left">
                        {{$row->employee->tin }}
                    </td>

                    <td class="left">
                        {{$empData['basic_pay']}}
                    </td>
                @endif

                <td class="right">
                    {{number($row->$db_field)}}
                </td>

            </tr>

        @endforeach
        </tbody>
    </table>
@endif