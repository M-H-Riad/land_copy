@extends('main_layouts.app')

@section('content')

<div class="row animated flipInX">

    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> {{$title}}</span>
                </div>

            </div>


            <div class="portlet-body">
                @include('errorOrSuccess')
                {{Form::open(['route'=>'employee-profile.store','method'=>'post','class'=>"form-horizontal",'role'=>'form'])}}

                <div class="form-group">
                    <label for="national_id" class="col-md-2 control-label">National ID <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::number('national_id',null, ['class' => 'form-control' , 'id' => 'national_id','required'=>'required']) }}
                    </div>

                    <label for="pfno" class="col-md-2 control-label">PF NO <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::number('pfno',null, ['class' => 'form-control', 'id' => 'pfno','required']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="wasa_id" class="col-md-2 control-label">Wasa ID </label>
                    <div class="col-md-3">
                        {{ Form::text('wasa_id',null, ['class' => 'form-control', 'id' => 'wasa_id']) }}
                    </div>
                    <label for="mobile_no" class="col-md-2 control-label">Mobile No</label>
                    <div class="col-md-3">
                        {{ Form::text('mobile_no',null, ['class' => 'form-control' , 'id' => 'mobile_no']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="col-md-2 control-label">Employee First Name <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{Form::text('employee_first_name',null,['class'=>'form-control','placeholder'=>'Employee First Name','required'=>'required'])}}
                    </div>
                    <label for="inputName" class="col-md-2 control-label">Employee Middle Name</label>
                    <div class="col-md-3">
                        {{Form::text('employee_middle_name',null,['class'=>'form-control','placeholder'=>'Employee Middle Name'])}}
                    </div>

                </div>
                <div class="form-group">
                    <label for="inputName" class="col-md-2 control-label">Employee Last Name</label>
                    <div class="col-md-3">
                        {{Form::text('employee_last_name',null,['class'=>'form-control','placeholder'=>'Employee Last Name'])}}
                    </div>
                    <label for="date_of_birth" class="col-md-2 control-label">Date Of Birth <span style="color:red">*</span></label>
                    <div class="col-md-3">

                        {{ Form::text('date_of_birth',null, ['class' => 'form-control mask_date', 'id' => 'date_of_birth','required'=>'required']) }}

                    </div>
                </div>

                <div class="form-group">
                    <label for="place_of_birth" class="col-md-2 control-label">Place Of Birth</label>
                    <div class="col-md-3">
                        {{ Form::select('place_of_birth',$placeOfBirth,null, ['class' => 'form-control' , 'id' => 'place_of_birth']) }}
                    </div>
                    <label for="father_name" class="col-md-2 control-label">Father's Name</label>
                    <div class="col-md-3">
                        {{ Form::text('father_name',null, ['class' => 'form-control', 'id' => 'father_name']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="mother_name" class="col-md-2 control-label">Mother's Name</label>
                    <div class="col-md-3">
                        {{ Form::text('mother_name',null, ['class' => 'form-control' , 'id' => 'mother_name']) }}
                    </div>
                    <label for="religion" class="col-md-2 control-label">Religion <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select('religion',$religion,null, ['class' => 'form-control ', 'id' => 'religion','required'=>'required']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="blood_group" class="col-md-2 control-label">Blood Group</label>
                    <div class="col-md-3">
                        {{ Form::select('blood_group',$bloodGroup,null, ['class' => 'form-control ' , 'id' => 'blood_group']) }}
                    </div>
                    <label for="marital_status" class="col-md-2 control-label">Marital Status</label>
                    <div class="col-md-3">
                        {{ Form::select('marital_status',$maritalStatus,null, ['class' => 'form-control ', 'id' => 'marital_status']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="sex" class="col-md-2 control-label">Sex</label>
                    <div class="col-md-3">
                        {{ Form::select('sex',$sex,null, ['class' => 'form-control '  , 'id' => 'sex']) }}
                    </div>
                    <label for="spouse_name" class="col-md-2 control-label">Spouse Name</label>
                    <div class="col-md-3">
                        {{ Form::text('spouse_name',null, ['class' => 'form-control','placeholder'=>'Spouse Name','id' => 'spouse_name']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="spouse_qualification" class="col-md-2 control-label">Spouse Qualification</label>
                    <div class="col-md-3">
                        {{ Form::text('spouse_qualification',null, ['class' => 'form-control' ,'placeholder'=>'Spouse Qualification', 'id' => 'spouse_qualification']) }}
                    </div>
                    <label for="spouse_profession" class="col-md-2 control-label">Spouse Profession</label>
                    <div class="col-md-3">
                        {{ Form::text('spouse_profession',null, ['class' => 'form-control' ,'placeholder'=>'Spouse Profession', 'id' => 'spouse_profession']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="personnel_file_no" class="col-md-2 control-label">Personnel File No</label>
                    <div class="col-md-3">
                        {{ Form::text('personnel_file_no',null, ['class' => 'form-control' , 'id' => 'personnel_file_no']) }}
                    </div>
                    <label for="passport_no" class="col-md-2 control-label">Passport No</label>
                    <div class="col-md-3">
                        {{ Form::text('passport_no',null, ['class' => 'form-control', 'id' => 'passport_no']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="bank_name" class="col-md-2 control-label">Bank Name <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select('bank_name',$bank,null, ['class' => 'form-control ', 'id' => 'bank_name','required'=>'required']) }}
                    </div>

                    <label for="branch_name" class="col-md-2 control-label">Branch Name <span style="color:red">*</span></label>
                    <div class="col-md-3" id="branch_list">
                        {{ Form::select('branch_name',[''=>'Select Branch'],null, ['class' => 'form-control ', 'id' => 'branch_name','required'=>'required']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="bank_account_no" class="col-md-2 control-label">Bank Account No <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::text('bank_account_no',null, ['class' => 'form-control', 'id' => 'bank_account_no','required'=>'required']) }}
                    </div>
                    <label for="bank_account_no_t24" class="col-md-2 control-label">Bank Account No 24 <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::text('bank_account_no_t24',null, ['class' => 'form-control', 'id' => 'bank_account_no_t24','required'=>'required']) }}
                    </div>

                   
                </div>
                <div class="form-group">

                    <label for="tax_identification_no" class="col-md-2 control-label">Tax Identification No</label>
                    <div class="col-md-3">
                        {{ Form::text('tax_identification_no',null, ['class' => 'form-control', 'id' => 'tax_identification_no']) }}
                    </div>
                    <label for="email" class="col-md-2 control-label">Email</label>
                    <div class="col-md-3">
                        {{ Form::email('email',null, ['class' => 'form-control' , 'id' => 'email']) }}
                    </div>
                </div>


                <div class="form-group">


                    <label for="quota" class="col-md-2 control-label">Quota</label>
                    <div class="col-md-3">
                        {{ Form::select('quota',$quota,null, ['class' => 'form-control' , 'id' => 'quota']) }}
                    </div>
                    
                    <label for="freedom_fighter" class="col-md-2 control-label">Is Freedom Fighter</label>
                    <div class="col-md-3" style="padding-top: 7px;">
                        {{ Form::checkbox('freedom_fighter',1, false) }}
                    </div>


                </div>


                <hr style="margin: 5px">
                <p style="color: red;padding: 0px !important;margin: 0px !important;">Latest Job Information</p>
                <div class="form-group">
                    <label for="office_order_no" class="col-md-2 control-label">Office Order No  <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::text("office_order_no",null,["class" => "form-control",'id' => 'office_order_no','required']) }}
                    </div>
                    <label for="office_order_date" class="col-md-2 control-label">Office Order Date</label>

                    <div class="col-md-3">

                        {{ Form::text('office_order_date',null, ['class' => 'form-control mask_date' , 'id' => 'office_order_date']) }}

                    </div>
                </div>
                <div class="form-group">
                    <label for="designation" class="col-md-2 control-label">Designation  <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select("designation",$designation,null,["class" => "form-control ",'id' => 'designation','style'=>'width:100%','required']) }}
                    </div>

                    <label for="joining_date" class="col-md-2 control-label">Joining Date  <span style="color:red">*</span></label>
                    <div class="col-md-3">

                        {{ Form::text('joining_date',null, ['class' => 'form-control mask_date' , 'id' => 'joining_date','required']) }}

                    </div>

                </div>
                <div class="form-group">


                    <label for="designation_status" class="col-md-2 control-label">Designation Status  <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select("designation_status",$designationStatus,null,["class" => "form-control ",'id' => 'designation_status','style'=>'width:100%','required']) }}
                    </div>
                    <label for="office_zone" class="col-md-2 control-label">Office/Zone  <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select("office_zone",$office_zone,null,["class" => "form-control ",'id' => 'office_zone','style'=>'width:100%','required']) }}
                    </div>

                </div>
                <div class="form-group">
                    <label for="scale" class="col-md-2 control-label">Pay Scale Year  <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select("scale_year",$scale_year,null,["class" => "form-control scale-year js-example-basic-single",'id'=>'scale_year','style'=>'width:100%','required']) }}
                    </div>

                    <label for="scale" class="col-md-2 control-label">Pay Scale  <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select("scale",[],null,["class" => "form-control ",'style'=>'width:100%','id'=>'scale','required']) }}
                    </div>

                </div>


                <div class="form-group">
                    <label for="basic_pay" class="col-md-2 control-label">Basic Pay (Taka) <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select("basic_pay",['Basic Pay'],null,["class" => "form-control",'id'=>"basic_pay",'required']) }}
                    </div>
                    <label for="status" class="col-md-2 control-label">Status <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select('status', $status, null, ['class' => 'form-control', 'id' => 'status','required']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="class" class="col-md-2 control-label">Class <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::select('class', $class, null, ['class' => 'form-control', 'id' => 'class','required']) }}
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="col-md-offset-5 col-md-12" style="    padding-bottom: 20px;">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </div>
            </div>



            {{Form::close()}}

        </div>

    </div>
    <!-- END SAMPLE FORM PORTLET-->
</div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        $('#nopagination').DataTable({
            "paging": false,
            "bFilter": false,
            "info": false
        });

        highlight_nav('employee', 'create-employee');



        $("#scale_year").change(function () {
            var year = $("#scale_year").val();
//       alert("Year = "+year);
            var url = "{{url('get-scale-list-by-year')}}";
            $.ajax({
                url: url,
                method: 'POST',
                data: {year: year}
            }).done(function (data) {
                var option = "<option value=''>Pay Scale</option>";


                $.each(data, function (index, value) {

                    option += "<option value='" + index + "'>" + value + "</option>";
                });
//            console.log(data);
                $("#scale").html(option);
                $(".pay-scale").trigger('change');
            });

            var option = "<option value=''>Select Basic Pay</option>";
            $("#basic_pay").html(option);
        });



    });
</script>

@endsection

@section('scripts')

<script>
    $("#bank_name").change(function (e) {
        var bankId = $("#bank_name").val();
        $("#branch_name").html('<option value="">Loading...</option>');
        var url = "{{url('employee-profile/create/get-bank-branch')}}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {bank_id: bankId}
        })
                .done(function (data) {
                    var option = '<option value="">Select Branch</option>';
                    if (data.branchList == null)
                    {
                        console.log("Branch not found");
                    } else
                    {
                        $.each(data.branchList, function (index, value) {
                            option += "<option value='" + value.id + "'>" + value.branch_name + "</option>";
                        });
                    }
                    $("#branch_name").html(option);
                });
    });

    $("#scale").change(function () {
        var id = $("#scale").val();

        var url = "{{url('get-basic-pay-by-grade')}}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {id: id}
        }).done(function (data) {
            var option = "<option value=''>Select Basic Pay</option>";
            $.each(data, function (index, value) {
                option += "<option value='" + value + "'>" + value + "</option>";
            });
            console.log(data);
            $("#basic_pay").html(option);
        });
    });

</script>
@endsection