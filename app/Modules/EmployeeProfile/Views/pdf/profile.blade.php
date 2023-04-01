<html>
<head>
<title>Profile of {!! $employee->first_name or '' !!} {!! $employee->mitdle_name or '' !!} {!! $employee->last_name or '' !!}</title>
<style type="text/css">
   *{
      font-size: 10px;
   }
   table{
      width: 100%;
      margin: 0 auto;
      border-collapse: collapse;
   }
   table tr{
      margin-top: 5px;
   }
   th{
       font-weight: normal;
   }
   td{
       padding-left: 2px;
      font-size: 10px;
      vertical-align: top;
      color: #000000;
      border: none;
      /*border: 1px solid #ccc;*/
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
   .w25{
      width: 25%;
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
      font-size: 9px;
   }
   .text-center{
      text-align: center;
   }
</style>
</head>
<body>
<!-- Header -->
@include('EmployeeProfile::pdf.modules.header')

<!-- Personal Info -->
<br>@include('EmployeeProfile::pdf.modules.personal')

<!-- Present Address -->
<?php $present_address = $employee->address->where('address_type','Present')->last(); ?>
<?php $permanent_address = $employee->address->where('address_type','Permanent')->last(); ?>

<br>@include('EmployeeProfile::pdf.modules.address')

@if($employee->marital_status != 'Unmarried')
<!-- Children Information  -->
<br>@include('EmployeeProfile::pdf.modules.children')
@endif

{{--<div style="page-break-before: always;"></div>--}}

<!-- Academic Carrier  -->
<br>@include('EmployeeProfile::pdf.modules.academic')

<!-- Quarter Information  -->
<br>@include('EmployeeProfile::pdf.modules.quarter')

<!-- Job Information   -->
<br>@include('EmployeeProfile::pdf.modules.job')

<!-- Past Public Sector Experience Outside Dhaka WASA   -->
<br>@include('EmployeeProfile::pdf.modules.experience')

{{--<div style="page-break-before: always;"></div>--}}

<!-- Membership -->
<br>@include('EmployeeProfile::pdf.modules.membership')

<!-- Training -->
<br>@include('EmployeeProfile::pdf.modules.training')

<!-- Transfer Records -->
<br>@include('EmployeeProfile::pdf.modules.transfer')

<!-- Transfer Records -->
<br>@include('EmployeeProfile::pdf.modules.leave')

<!-- Suspension Records -->
<br>@include('EmployeeProfile::pdf.modules.disciplinary_records')

<!-- Suspension Records -->
<br>@include('EmployeeProfile::pdf.modules.footer')
</body>
</html>