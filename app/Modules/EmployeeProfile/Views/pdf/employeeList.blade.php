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
                    <th style="width: 3%;">Sl. No.</th>
                    <th style="width: 24%;">
                        Name of Employee <br/>Designation <br/>Department <br/>
                        <table class="no-border">
                            <tr><th>Joining Date</th><th class="right">Birth Date</th></tr>
                        </table>
                    </th>
                    <th style="width: 18%;">Father's Name <br>Mother's Name <br>Name of Spouse <br>Name of Nominee</th>
                    <th style="width: 19%;">
                        Present Address
                        <table class="no-border">
                            <tr><th>Phone No.</th><th class="right">Blood Gr.</th></tr>
                        </table>
                    </th>
                    <th style="width: 19%;">
                        Permanent Address
                        <table class="no-border">
                            <tr><th>Mobile No.</th><th class="right">Passport No.</th></tr>
                        </table>
                    </th>
                    <th style="width: 17%;">Marital Status <br>Gender <br>Religion <br>Qualification</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; ?>
                @foreach($data as $emp)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ $emp["full_Name"] }} <br>
                            {{ $emp["designation"] }} <br>
                            {{ $emp["department"] }} <br>
                            <table class="no-border">
                                <tr><th>{{ $emp["joining_date"] }}</th><th class="right">{{ $emp["date_of_birth"] }}</th></tr>
                            </table>
                        </td>
                        <td>
                            {{ $emp["father_name"] }} <br>
                            {{ $emp["mother_name"] }} <br>
                            {{ $emp["spouse_name"] }} <br>
                            {{ $emp["spouse_name"] }} <br>
                        </td>
                        <td>
                            {{ $emp["present_zip_code"] }} {{ $emp["present_post_office"] }} {{ $emp["present_thana"] }} {{ $emp["present_district"] }} {{ $emp["present_division"] }}
                            <table class="no-border">
                                <tr><th>{{ $emp["present_mobile"] }}</th><th class="right">{{ $emp["blood_group"] }}</th></tr>
                            </table>
                        </td>
                        <td>
                            {{ $emp["permanent_zip_code"] }} {{ $emp["permanent_post_office"] }} {{ $emp["permanent_thana"] }} {{ $emp["permanent_district"] }} {{ $emp["permanent_division"] }}                            
                            <table class="no-border">
                                <tr><th>{{ $emp["permanent_mobile"] }}</th><th class="right">{{ $emp["passport_no"] }}</th></tr>
                            </table>
                        </td>
                        <td>
                            {{ $emp["marital_status"] }} <br>
                            {{ $emp["gender"] }} <br>
                            {{ $emp["religion"] }} <br>
                            {{ $emp["qualification"] }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                </tr>
            </tbody>
        </table>
    </body>
</html>