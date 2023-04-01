<div id="personal-info-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => url('employee-profile',$employee->id), 'method' => 'put']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Children Information</h4>
            </div>
            <div class="modal-body">
                <h1 style="color: silver">Arnob bhai I need your help</h1>
                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                {{--<table class="table table-striped table-bordered table-hover dt-responsive" class="nopagination" width="100%">--}}

                    <div class="form-group">
                        <label for="inputName" class="col-md-2 control-label">Employee First Name <span style="color:red">*</span></label>
                        <div class="col-md-3">
                            {{Form::text('name_first_part',null,['class'=>'form-control','placeholder'=>'First Part','required'=>'required'])}}
                        </div>
                        <label for="inputName" class="col-md-2 control-label">Employee Middle Name</label>
                        <div class="col-md-3">
                            {{Form::text('name_middle_part',null,['class'=>'form-control','placeholder'=>'Middle'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class="col-md-2 control-label">Employee Last Name</label>
                        <div class="col-md-3">
                            {{Form::text('name_last_part',null,['class'=>'form-control','placeholder'=>'Last'])}}
                        </div>
                        <label for="national_id" class="col-md-2 control-label">National Id <span style="color:red">*</span></label>
                        <div class="col-md-3">
                            {{ Form::text('national_id',null, ['class' => 'form-control' , 'id' => 'national_id']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth" class="col-md-2 control-label">Date Of Birth <span style="color:red">*</span></label>
                        <div class="col-md-3">
                                {{ Form::text('date_of_birth',dateFormat($employee->date_of_birth), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' , 'id' => 'date_of_birth']) }}
                           
                        </div>

                        <label for="place_of_birth" class="col-md-2 control-label">Place Of Birth</label>
                        <div class="col-md-3">
                            {{ Form::text('place_of_birth',null, ['class' => 'form-control' , 'id' => 'place_of_birth']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="father_name" class="col-md-2 control-label">Father's Name</label>
                        <div class="col-md-3">
                            {{ Form::text('father_name',null, ['class' => 'form-control', 'id' => 'father_name']) }}
                        </div>

                        <label for="mother_name" class="col-md-2 control-label">Mother's Name</label>
                        <div class="col-md-3">
                            {{ Form::text('mother_name',null, ['class' => 'form-control' , 'id' => 'mother_name']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="religion" class="col-md-2 control-label">Religion</label>
                        <div class="col-md-3">
                            {{ Form::select('religion',$religion,null, ['class' => 'form-control', 'id' => 'religion']) }}
                        </div>

                        <label for="blood_group" class="col-md-2 control-label">Blood Group</label>
                        <div class="col-md-3">
                            {{ Form::select('blood_group',$bloodGroup,null, ['class' => 'form-control' , 'id' => 'blood_group']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="marital_status" class="col-md-2 control-label">Marital Status</label>
                        <div class="col-md-3">
                            {{ Form::select('marital_status',$maritalStatus,null, ['class' => 'form-control', 'id' => 'marital_status']) }}
                        </div>

                        <label for="sex" class="col-md-2 control-label">Sex</label>
                        <div class="col-md-3">
                            {{ Form::select('sex',$sex,null, ['class' => 'form-control' , 'id' => 'sex']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="spouse_name" class="col-md-2 control-label">Spouse Name</label>
                        <div class="col-md-3">
                            {{ Form::text('spouse_name',null, ['class' => 'form-control','placeholder'=>'Spouse Name','id' => 'spouse_name']) }}
                        </div>
                        <label for="spouse_qualification" class="col-md-2 control-label">Spouse Qualification</label>
                        <div class="col-md-3">
                            {{ Form::text('spouse_qualification',null, ['class' => 'form-control' ,'placeholder'=>'Spouse Qualification', 'id' => 'spouse_qualification']) }}
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="spouse_qualification" class="col-md-2 control-label">Spouse Profession </label>
                        <div class="col-md-3">
                            {{ Form::text('spouse_profession',null, ['class' => 'form-control' ,'placeholder'=>'Spouse Profession', 'id' => 'spouse_profession']) }}
                        </div>

                        <label for="passport_no" class="col-md-2 control-label">Passport No</label>
                        <div class="col-md-3">
                            {{ Form::text('passport_no',null, ['class' => 'form-control', 'id' => 'passport_no']) }}
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="bank_name" class="col-md-2 control-label">Bank Name</label>
                        <div class="col-md-3">
                            {{ Form::text('bank_name',null, ['class' => 'form-control', 'id' => 'bank_name']) }}
                        </div>

                        <label for="branch_name" class="col-md-2 control-label">Branch Name</label>
                        <div class="col-md-3">
                            {{ Form::text('branch_name',null, ['class' => 'form-control' , 'id' => 'branch_name']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_account_no" class="col-md-2 control-label">Bank Account No</label>
                        <div class="col-md-3">
                            {{ Form::text('bank_account_no',null, ['class' => 'form-control', 'id' => 'bank_account_no']) }}
                        </div>

                        <label for="provident_fund_no" class="col-md-2 control-label">Provident Fund No</label>
                        <div class="col-md-3">
                            {{ Form::text('provident_fund_no',null, ['class' => 'form-control' , 'id' => 'provident_fund_no']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tax_identification_no" class="col-md-2 control-label">Tax Identification No</label>
                        <div class="col-md-3">
                            {{ Form::text('tax_identification_no',null, ['class' => 'form-control', 'id' => 'tax_identification_no']) }}
                        </div>

                        <label for="mobile_no" class="col-md-2 control-label">Mobile No</label>
                        <div class="col-md-3">
                            {{ Form::text('mobile_no',null, ['class' => 'form-control' , 'id' => 'mobile_no']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-2 control-label">Email</label>
                        <div class="col-md-3">
                            {{ Form::email('email',null, ['class' => 'form-control' , 'id' => 'email']) }}
                        </div>
                        <label for="personnel_file_no" class="col-md-2 control-label">Personnel File No</label>
                        <div class="col-md-3">
                            {{ Form::text('personnel_file_no',null, ['class' => 'form-control' , 'id' => 'personnel_file_no']) }}
                        </div>
                    </div>

                {{--</table>--}}

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary">Up & Close</button>
            </div>
            {!! Form::close()  !!}
        </div>
    </div>
</div>