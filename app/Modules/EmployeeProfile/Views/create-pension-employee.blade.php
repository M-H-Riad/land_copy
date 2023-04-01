@extends('main_layouts.app')

@section('content')

<div class="row animated flipInX">


    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> Search First</span>
                </div>

            </div>

            <div class="portlet-body" style="padding: 10px">
                {{Form::open(['url'=>'employee-profile/create-pension-employee','method'=>'get','form-horizontal','role'=>'form'])}}
                <div class="form-group">
                    <label for="national_id_s" class="col-md-1 control-label">National ID</label>
                    <div class="col-md-2">
                        {{ Form::number('national_id_s',null, ['class' => 'form-control' , 'id' => 'national_id_s']) }}
                    </div>
                    <label for="pfno" class="col-md-1 control-label">PF NO.</label>
                    <div class="col-md-2">
                        {{ Form::text('pfno_s',null, ['class' => 'form-control', 'id' => 'pfno']) }}
                    </div>
                    <label for="pfno" class="col-md-1 control-label">PPO NO.</label>
                    <div class="col-md-2">
                        {{ Form::text('ppo_no_s',null, ['class' => 'form-control', 'id' => 'ppo_no']) }}
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-success btn-sm" type="submit">Search</button>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="col-md-12 " id="create_form" style="display: {{($serach)?'block':'none'}}">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> {{$title}}</span>
                </div>

            </div>

            <div class="portlet-body" >
                @include('errorOrSuccess')
                {{Form::open(['route'=> 'emp.pension-employee-store','method'=>'post','class'=>"form-horizontal",'role'=>'form'])}}

                <div class="form-group">
                    <label for="national_id" class="col-md-2 control-label">National ID <span style="color:red">*</span></label>
                    <div class="col-md-3">
                        {{ Form::number('national_id',request('national_id_s'), ['class' => 'form-control' , 'id' => 'national_id','required'=>'required']) }}
                    </div>
                    <label for="employee_id" class="col-md-2 control-label">Employee ID</label>
                    <div class="col-md-3">
                        {{ Form::text('employee_id',null, ['class' => 'form-control', 'id' => 'employee_id','disabled']) }}
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
                    <label for="religion" class="col-md-2 control-label">Religion</label>
                    <div class="col-md-3">
                        {{ Form::select('religion',$religion,null, ['class' => 'form-control ', 'id' => 'religion']) }}
                    </div>
                </div>



                <hr style="margin: 5px">
                <p style="color: red;padding: 0px !important;margin: 0px !important;">Pension Order Information</p>
                <div class="form-group">
                    <label for="office_order_no" class="col-md-2 control-label">Office Order No</label>
                    <div class="col-md-3">
                        {{ Form::text("office_order_no",null,["class" => "form-control"]) }}
                    </div>
                    <label for="office_order_date" class="col-md-2 control-label">Office Order Date</label>

                    <div class="col-md-3">

                        {{ Form::text('office_order_date',null, ['class' => 'form-control mask_date' , 'id' => 'office_order_date']) }}

                    </div>
                </div>
                <div class="form-group">
                    <label for="designation" class="col-md-2 control-label">Designation</label>
                    <div class="col-md-3">
                        {{ Form::select("designation",$designation,null,["class" => "form-control ",'style'=>'width:100%']) }}
                    </div>

                    <label for="joining_date" class="col-md-2 control-label">Retirement Date</label>
                    <div class="col-md-3">

                        {{ Form::text('retirement_date',null, ['class' => 'form-control mask_date' , 'id' => 'retirement_date']) }}

                    </div>

                </div>
                <div class="form-group">


                    <label for="office_zone" class="col-md-2 control-label">Designation Status</label>
                    <div class="col-md-3">
                        {{ Form::select("designation_status",$designationStatus,null,["class" => "form-control ",'style'=>'width:100%']) }}
                    </div>
                    <label for="office_zone" class="col-md-2 control-label">Office/Zone</label>
                    <div class="col-md-3">
                        {{ Form::select("office_zone",$office_zone,null,["class" => "form-control ",'style'=>'width:100%']) }}
                    </div>

                </div>
                <div class="form-group">
                    <label for="scale" class="col-md-2 control-label">Pay Scale</label>
                    <div class="col-md-3">
                        {{ Form::select("scale",$scale,null,["class" => "form-control ",'style'=>'width:100%']) }}
                    </div>
                    <label for="basic_pay" class="col-md-2 control-label">Basic Pay (Taka)</label>
                    <div class="col-md-3">
                        {{ Form::text("basic_pay",null,["class" => "form-control mask_currency"]) }}
                    </div>
                </div>

                <hr style="margin: 5px">
                <p style="color: red;padding: 0px !important;margin: 0px !important;">Relatives Information</p>
                <div class="form-group">
                    <label for="office_order_no" class="col-md-2 control-label">Relatives Name</label>
                    <div class="col-md-2">
                        {{ Form::text("name",null,["class" => "form-control focus_it",'required']) }}
                    </div>

                    <label for="office_order_date" class="col-md-1 control-label">Relation</label>
                    <div class="col-md-2">
                        {{ Form::select('relation',relations() ,null, ['class' => 'form-control' , 'id' => '','style' => 'width:100%']) }}
                    </div>

                    <label for="phone_no" class="col-md-1 control-label">Phone No</label>
                    <div class="col-md-2">
                        {{ Form::text("phone_no",null,["class" => "form-control focus_it"]) }}
                    </div>
                </div>
                <hr style="margin: 5px">
                <p style="color: red;padding: 0px !important;margin: 0px !important;">Relatives Information 2</p>
                <div class="form-group">
                    <label for="office_order_no" class="col-md-2 control-label">Relatives Name</label>
                    <div class="col-md-2">
                        {{ Form::text("name2",null,["class" => "form-control focus_it",'required']) }}
                    </div>

                    <label for="office_order_date" class="col-md-1 control-label">Relation</label>
                    <div class="col-md-2">
                        {{ Form::select('relation2',relations() ,null, ['class' => 'form-control' , 'id' => '','style' => 'width:100%']) }}
                    </div>

                    <label for="phone_no" class="col-md-1 control-label">Phone No</label>
                    <div class="col-md-2">
                        {{ Form::text("phone_no2",null,["class" => "form-control focus_it"]) }}
                    </div>
                </div>

                <hr style="margin: 5px">
                <p style="color: red;padding: 0px !important;margin: 0px !important;">Bank Information</p>

                <div class="form-group">
                    <label for="bank_name" class="col-md-2 control-label">Bank Name</label>
                    <div class="col-md-3">
                        {{ Form::select('bank_id',$bank,null, ['class' => 'form-control ', 'id' => 'bank_name']) }}
                    </div>

                    <label for="branch_name" class="col-md-2 control-label">Branch Name</label>
                    <div class="col-md-3" id="branch_list">
                        {{ Form::select('branch_id',[''=>'Select Branch'],null, ['class' => 'form-control select2', 'id' => 'branch_name', 'style'=>'width:100%']) }}

                    </div>

                </div>

                <div class="form-group">
                    <label for="bank_account_no" class="col-md-2 control-label">Bank Account No (T24)</label>
                    <div class="col-md-3">
                        {{ Form::text('account_no',null, ['class' => 'form-control', 'id' => 'bank_account_no']) }}
                    </div>

                    <label for="provident_fund_no" class="col-md-2 control-label">Account No Old</label>
                    <div class="col-md-3">
                        {{ Form::text("account_no_old",null,["class" => "form-control focus_it"]) }}
                    </div>
                </div>


                <div class="form-group">
                    <label for="provident_fund_no" class="col-md-2 control-label">Account Holder Name</label>
                    <div class="col-md-3">
                        {{ Form::text("account_holder_name",null,["class" => "form-control focus_it"]) }}
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

        highlight_nav('employee', 'create-pension-employee');

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
</script>
@endsection