<div style="width:10%;text-align: center; padding-bottom: 10px;float: left;">
    <img style="height: 55px" src="{{public_path()}}/logo.png" alt="Wasa Logo" />
</div>
<div style="width:90%;text-align: center; padding-bottom: 10px;float: left">
   <p class="title">DHAKA WATER SUPPLY AND SEWERAGE AUTHORITY</p>
    <p class="title">FESTIVAL BONUS REPORT</p>

    <p class="title" style=" text-transform: uppercase"><strong><u>BONUS FOR {{str_replace('-',' ',$bonusData->title)}}</u></strong></p>

</div>
<div style="width: 50%;text-align: right;float: right;font-size:10px">
    {PAGENO}{nbpg}
</div>
<div style="width: 50%;text-align: left;float: left; font-size:10px">
    @if(isset($department)) <strong> Department : {{$department->department_name}}  </strong>  | @endif   Printing Date: {{date('d-m-Y h:i:s A')}}
</div>