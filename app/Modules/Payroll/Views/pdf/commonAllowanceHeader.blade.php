<div style="width:10%;text-align: center; padding-bottom: 10px;float: left;">
    <img style="height: 80px" src="{{public_path()}}/logo.png" alt="Wasa Logo" />
</div>
<div style="width:90%;text-align: center; padding-bottom: 10px;float: left">
{{--   <p class="title">Dhaka WASA Employee's Details</p>--}}
   <p class="title">DHAKA WATER SUPPLY AND SEWERAGE AUTHORITY</p>
    @if($department_id)
    <p class="title">WASA Bhaban, 98 Kazi Nazrul Islam Avenue, Karwan Bazar,Dhaka-1215</p>
    <p class="title"> Website: www.dwasa.org.bd WASA Link- 16162</p>
    @else
    @if($sheetTitle) <p class="title">{{$sheetTitle}}</p> @endif
    @if($title)<p class="title">{{$title}} </p>@endif
    @endif
</div>
@if($department_id)
    <div style="width: 50%;text-align: left;float: left">
        {{date('F d,Y')}}
    </div>
    @else
<div style="width: 50%;text-align: right;float: right">
    {PAGENO}{nbpg}
</div>
<div style="width: 50%;text-align: left;float: left">
    Printing Date: {{date('d-m-Y')}}
</div>
@endif