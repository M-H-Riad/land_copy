<div>
    <!-- BEGIN GENERAL PORTLET-->
    <div class="portlet box blue-hoki">
        <div class="portlet-title">
            <div class="caption">

                <span class="caption-subject bold uppercase">
                    Profile of:
                    {!! $employee->first_name or '' !!}
                    {!! $employee->middle_name or '' !!}
                    {!! $employee->last_name or '' !!}
                </span>
                <!--                <small class="text-muted">
                                    - Programmer
                                </small>-->
            </div>
            <div class="actions">
                @if(Auth::user()->can('manage_profile'))
                <a class="btn btn-circle btn-default btn-sm modal-btn" data-toggle="modal" href="{{route('employee-profile.edit',$employee->id)}}">
                    <i class="fa fa-edit"></i> Edit
                </a>
                @endif
                @if(Auth::user()->can('export_cv'))
                <a class="btn btn-circle btn-default btn-sm" target="_blank" href="{{route('export-pdf',$employee->id)}}">
                    <i class="fa fa-file-pdf-o"></i> PDF
                </a>
                @endif
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-6">

                    <dl class="dl-horizontal">
                        <dt>Employee ID:</dt>
                        <dd>{!! $employee->employee_id or '' !!}</dd>
                        <dt>PF NO:</dt>
                        <dd>{!! $employee->pfno or '' !!}</dd>

                        <dt>Full Name:</dt>
                        <dd>
                            {!! $employee->first_name or '' !!}
                            {!! $employee->middle_name or '' !!}
                            {!! $employee->last_name or '' !!}
                        </dd>

                        <dt>Designation:</dt>
                        <dd>{!! $employee->designation->title or '' !!}</dd>

                        <dt>Department:</dt>
                        <dd>
                            {!! $employee->department->department_name or '' !!}
                        </dd>
                        <dt>Joining Date:</dt>
                        <dd>
                            {!! dateFormat($employee->first_joining_date)!!}
                        </dd>

                        <dt>Current Basic Pay:</dt>
                        <dd>
                            {!! taka_format($employee->current_basic_pay) !!}
                        </dd>

                        <dt>Place of Birth:</dt>
                        <dd>{!! $employee->place_of_birth or '' !!}</dd>

                        <dt>Religion:</dt>
                        <dd>{!! $employee->religion or '' !!}</dd>

                        <dt>Marital Status:</dt>
                        <dd>{!! $employee->marital_status or '' !!}</dd>

                        <dt>Spouse Qualification:</dt>
                        <dd>{!! $employee->spouse_qualification or '' !!}</dd>

                        <dt>Bank & Branch Name:</dt>
                        <dd>{!! $employee->bankName->bank_name or '' !!},{!! $employee->bankbranch->branch_name or '' !!}</dd>

                        <dt>Is Freedom Fighter:</dt>
                        <dd>{!! ($employee->freedom_fighter)?'Yes':'No' !!}</dd>

                        <dt>PRL Start Date:</dt>
                        <dd>{!! dateFormat($employee->expected_prl_date) !!}</dd>

                        <dt>Status:</dt>
                        <dd>{!! $employee->status or '' !!}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt>WASA ID:</dt>
                        <dd>{!! $employee->wasa_id or '' !!}</dd>
                        <dt>National ID:</dt>
                        <dd>{!! $employee->nid or '' !!}</dd>

                        <dt>Date of Birth:</dt>
                        <dd>{!! dateFormat($employee->date_of_birth) !!}</dd>

                        <dt>Mother's Name:</dt>
                        <dd>{!! $employee->mother_name or '' !!}</dd>

                        <dt>Blood Group:</dt>
                        <dd>{!! $employee->blood_group or '' !!}</dd>

                        <dt>Sex:</dt>
                        <dd>{!! $employee->gender or '' !!}</dd>

                        <dt>Spouse Name:</dt>
                        <dd>{!! $employee->spouse_name or '' !!}</dd>

                        <dt>Spouse Profession:</dt>
                        <dd>{!! $employee->spouse_profession or '' !!}</dd>

                        <dt>Personnel File No:</dt>
                        <dd>{!! $employee->personnel_file_no or '' !!}</dd>

                        <dt>Bank Account No.:</dt>
                        <dd>{!! $employee->bank_account_no or '' !!}</dd>

                        <dt>Tax Identification No.:</dt>
                        <dd>{!! $employee->tin or '' !!}</dd>

                        <dt>Passport No:</dt>
                        <dd>{!! $employee->passport_no or '' !!}</dd>

                        <dt>Quota:</dt>
                        <dd>{!! $employee->quota->name or '' !!}</dd>
                        <dt>Pension Start Date:</dt>
                        <dd>{!! dateFormat($employee->expected_pension_date) !!}</dd>
                        <dt>Class:</dt>
                        <dd>{!! $employee->class or '' !!}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>