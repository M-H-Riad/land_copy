<html>
    <head>
        <style type="text/css">

            tbody {
                /*margin-top: 100mm;*/
            }


            *{
                /*font-size: 25px;*/
                /*margin-top: 10mm;*/
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
           
            .tp{
                border-top: 1px dotted red;
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
                border: 1px solid #cbd2db;
            }
            img{
                padding: 0px;
                margin: 0px;
            }
            .greenLine{
                border: 1px solid #cbd2db;
            }
            .borderBottom{
                border: none;
                border-bottom: 1px solid #cbd2db;
            }
            .grayBg{
                background-color: #edf0f4;
                color: black;
                font-family: Arial;
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
            .title, .page-title{
                font-weight: bold;
                font-family: Arial;
            }
            .engOnly{
                font-family: ver;
            }
            .w25{
                width: 25%;
            }
            .w50{
                width: 50%;
            }
            .w20{
                width: 20%;
            }
            .w5{
                width: 5%;
            }
            .w10{
                width: 10%;
            }
            .w35{
                width: 35%;
            }
            .w15{
                width: 15%;
            }
            .w33{
                width: 33%;
            }
            .noBorderTopBottom{
                border-bottom: none;
                border-top: none;
            }
            .noBorderLeftRight{
                border-left: none;
                border-right: none;
            }
            .noBorderRight{
                border-right: none;
            }
            .noBorderLeft{
                border-left: none;
            }
            span{
                /*font-size: 9px;*/
            }
            .right{
                text-align: right;

            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr id="a">
                    <th>Sl. No.</th>
                    <th>PF No</th>
                    <th>Name of Employee</th>
                    <th>Age</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Joining Date</th>
                    <th>Grade</th>
                    <th>Date of Birth</th>
                    <th>NID</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; ?>
                @foreach($data as $emp)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $emp["pf_no"] }}</td>
                        <td>{{ $emp["full_Name"] }}</td>
                        <td>{{ $emp["age"] }}</td>
                        <td>{{ $emp["designation"] }}</td>
						<td>{{ $emp["department"] }}</td>
						<td>{{ $emp["joining_date"] }}</td>
						<td>{{ $emp["grade"] }}</td>
						<td>{{ $emp["date_of_birth"] }}</td>
						<td>{{ $emp["nid"] }}</td>
                    </tr>
                @endforeach
                <tr>
                </tr>
            </tbody>
        </table>
    </body>
</html>