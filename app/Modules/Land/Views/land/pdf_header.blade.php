<div style="width:10%;text-align: center; padding-bottom: 10px;float: left;">
    <img style="height: 80px" src="{{public_path()}}/logo.png" alt="Wasa Logo" />
</div>
<div style="width:90%;text-align: center; padding-bottom: 10px;float: left">
    <p class="title">ঢাকা পানি সরবরাহ ও পয়: নিষ্কাশন কর্তৃপক্ষ</p> 
    <p class="title">ভূমি তথ্যাবলী</p>
    @if(isset($zone))<p class="title">মডস {{ $zone->title }}</p>@endif
</div>
{{-- <div style="width: 50%;text-align: right;float: right">
    {PAGENO}{nbpg}
</div>
<div style="width: 50%;text-align: left;float: left">
    Printing Date: {{date('d-m-Y')}}
</div> --}}