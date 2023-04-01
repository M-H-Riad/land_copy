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

            border: 1px solid #cbd2db;
            font-size: 11px;
            text-align: left;
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
            /*border: 1px solid #cbd2db;*/
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

    <?php $i=1; ?>
    @foreach($designations as $designation)
        @if($designation->employee->count())

   <p><strong>{{ $designation->title }}</strong></p>
                <table>
                    <tbody>
                @foreach($designation->employee as $employee)

                        <tr>
                            <td style="width: 8%!important;">{{ $i++ }}</td>
                            <td style="width: 17%!important;">{{ trim($employee->bank_account_no)}}</td>
                            <td style="width: 25%!important;">{{  $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name  }}</td>
                            <td style="width: 10%!important;">{{$employee->current_basic_pay}} </td>
                            <td style="width: 20%!important;">{{ trim($designation->title) }}  </td>
                            <td style="width: 20%!important;">{{ trim($employee->department->department_name) }}  </td>
                        </tr>

                @endforeach
                    </tbody>
                </table>

        @endif
    @endforeach

</body>
</html>