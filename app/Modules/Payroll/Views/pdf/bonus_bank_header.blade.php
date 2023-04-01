<div style="width:10%;text-align: center; padding-bottom: 4px;float: left;">
    <img style="height: 55px" src="{{public_path()}}/logo.png" alt="Wasa Logo" />
</div>
<div style="width:90%;text-align: center; padding-bottom: 4px;float: left">
   <p class="title">DHAKA WATER SUPPLY AND SEWERAGE AUTHORITY</p>
    <p class="title">MONTHLY DETAIL SALARY REPORT
        <br>
        @if(isset($departmentGroup))
            Bank Name :{{ $departmentGroup->bank }}. Branch Name :{{ $departmentGroup->branch }}
        @else
             Bank Name :Janata Bank Limited. Branch Name :Kawran Bazar Corporate Branch
        @endif
    </p>

    <p class="title" style=" text-transform: uppercase"><strong><u>Bonus {{str_replace('-',' ',$monthData->title).' '}} @if(isset($departmentGroup)) {{trim($departmentGroup->group_name)}} @else WASA & Drainage @endif</u></strong></p>

</div>
<div style="width: 50%;text-align: right;float: right;font-size:10px">
    {PAGENO}{nbpg}
</div>
<div style="width: 50%;text-align: left;float: left; font-size:10px">
  Printing Date: {{date('d-m-Y h:i:s A')}}
</div>