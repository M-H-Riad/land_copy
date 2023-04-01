@include('errorOrSuccess')
{!! Form::open(array('method' => 'get', 'id' => 'filter-form')) !!}

<div class="col-md-12 side-padding-none">
    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::text('ppo_no',request('ppo_no'), ['class' => 'form-control', 'id' => 'ppo_no','placeholder'=>'PPO No.']) }}
    </div>

    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::text('pfno',request('pfno'), ['class' => 'form-control', 'id' => 'pfno','placeholder'=>'PF No.']) }}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::text('wasa_id',request('wasa_id'), ['class' => 'form-control', 'id' => 'wasa_id','placeholder'=>'WASA ID']) }}
    </div>

    <div class="col-md-1" style="margin-bottom:5px;">
        <input type="text" value="{{request('nid')}}" class="form-control focus_it" name="nid" id="nid" placeholder="National ID">
    </div>

    <div class="col-md-2" style="margin-bottom:5px;">
        <input type="text" value="{{request('name')}}" class="form-control focus_it" name="name" id="name" placeholder="Employee Name">
    </div>
    <div class="col-md-2" style="margin-bottom:5px;">
        <input type="text" value="{{request('mobile','')}}" class="form-control focus_it" name="mobile" id="mobile" placeholder="Mobile">
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        <input type="text" value="{{request('date_of_birth','')}}" class="form-control focus_it mask_date" name="date_of_birth" id="date_of_birth" placeholder="DOB">
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {!! Form::select('merital_status',get_marital_tatus_array(),request('merital_status'), ['class' => 'form-control', 'id' => 'merital_status']) !!}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {!! Form::select('quota',$quota,request('quota'), ['class' => 'form-control','placeholder'=>'Quota', 'id' => 'quota']) !!}
    </div>
     <div class="col-md-1" style="margin-bottom:5px;">
        {!! Form::select('religion',get_religion_array(),request('religion'), ['class' => 'form-control', 'id' => 'religion']) !!}
    </div>
</div>

<div class="col-md-12 side-padding-none">
   
    <div class="col-md-1" style="margin-bottom:5px;">

        {!! Form::select('sex',get_sex_array(),request('sex'), ['class' => 'form-control', 'id' => 'sex']) !!}
    </div>
    <div class="col-md-2" style="margin-bottom:5px;">
        {!! Form::select('designation[]',$designation,request('designation'), ['class' => 'form-control select2', 'id' => 'designation','multiple','data-live-search'=>true]) !!}
    </div>
    <div class="col-md-2" style="margin-bottom:5px;">
        {!! Form::select('department',$department,request('department'), ['class' => 'form-control', 'id' => 'department']) !!}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {!! Form::select('division',$division,request('division'), ['class' => 'form-control','id' => 'division_id_1','onchange' => 'get_district_edit(1,'. request('district') .')']) !!}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {!! Form::select('district',$district,request('district'), ['class' => 'form-control', 'id' => 'district_id_1','onchange' => 'get_thana_edit(1,'. request('thana') .')']) !!}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {!! Form::select('thana',$thana,request('thana'), ['class' => 'form-control', 'id' => 'thana_id_1','onchange' => 'get_post_office_edit(1,'. request('postOffice') .')']) !!}
    </div>
    <div class="col-md-2" style="margin-bottom:5px;">
        {!! Form::select('postOffice',$postOffice,request('postOffice'), ['class' => 'form-control', 'id' => 'post_office_id_1']) !!}
    </div>
     <div class="col-md-2" style="margin-bottom:5px;">
        {!! Form::select('location',$quarterLocation,request('location'), ['class' => 'form-control', 'id' => 'location']) !!}
    </div>

    <div class="clearfix"></div>

</div>
<div class="col-md-12 side-padding-none">
   
    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::select('age_type',['age'=>'Employee’s Age', 'service'=>'Service Length', 'joinday'=>'Date of Joining', 'birthday'=>'Date of Birth', 'leave'=>'Leave'], request('age_type'), ['class' => 'form-control', 'id' => 'age','placeholder'=>'Date Range Type']) }}
    </div>

    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::text('prlStart',request('prlStart'), ['class' => 'form-control mask_date', 'id' => 'prlStart','placeholder'=>'Date From']) }}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::text('prlEnd',request('prlEnd'), ['class' => 'form-control mask_date', 'id' => 'prlStart','placeholder'=>'Date To']) }}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::number('age',request('age'), ['class' => 'form-control', 'id' => 'age','placeholder'=>'Year']) }}
    </div>

    <div class="col-md-1" style="margin-bottom:5px;">
        <input type="text" value="{{request('employee_id')}}" class="form-control focus_it" name="employee_id" id="employee_id" placeholder="Emp ID">
    </div>

    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::select('leave_type', get_leave_type(), request('leave_type'), ['class' => 'form-control', 'id' => 'leave_type']) }}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::select('status[]', get_status(), request('status'), ['class' => 'form-control select2', 'id' => 'status','multiple']) }}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::select('grade[]', getGradeList(), request('grade'), ['class' => 'form-control select2', 'id' => 'grade','multiple']) }}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        {{ Form::select('role_id',$roles, request('role_id'), ['class' => 'form-control', 'id' => 'roleid','placeholder'=>'Select Role']) }}
    </div>
    <div class="col-md-1" style="margin-bottom:5px;">
        <select name="" class="form-control" id="excel-download-type">
            <option value="">Select Report Type</option>
            <option value="all">All</option>
            <option value="basic">Basic Profile</option>
        </select>
    </div>
    @if(Request::segment(1) == 'pension-holder')
    @permission('manage_pension')
    <div class="col-md-1" style="margin-bottom:5px;">
        {{Form::checkbox('no_pension_data',1)}} No pernsion fund
    </div>
    <div class="col-md-2" style="margin-bottom:5px;">
        {{ Form::select('pension_type_id',get_pension_type(),null,['class' => 'form-control', 'id' => 'pension_type_id']) }}
    </div>
    @endpermission
    @endif
    <div class="col-md-1">
        <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-search"></i> Filter</button>
    </div>
    <div class="col-md-1">
        <a href="{{url('employee-profile')}}" class="btn btn-danger filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-times"></i> Reset</a>
    </div>

</div>

{!! Form::close() !!}


@section('scripts')
<script src="{{URL::asset('custom/js/location-list.js')}}" type="text/javascript"></script>
<script>
$(function () {
@if (request('division'))
        $('#division_id_1').trigger('change');
@endif
});

$("#designation").select2({
    placeholder: "Select Designation",
    allowClear: true,
    searchfield :true
});
$("#status").select2({
    placeholder: "Select Status",
    allowClear: true
});
$("#grade").select2({
    placeholder: "Select Grade",
    allowClear: true
});
</script>
@endsection