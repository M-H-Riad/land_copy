<div>
    <!-- BEGIN GENERAL PORTLET-->
    <div class="portlet box blue-hoki">
        <div class="portlet-title">
            <div class="caption">

                <span class="caption-subject bold uppercase">
                    Pension Profile of:
                    {!! $employee->first_name or '' !!}
                    {!! $employee->middle_name or '' !!}
                    {!! $employee->last_name or '' !!}
                </span>
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

                        <dt>Full Name:</dt>
                        <dd>
                            {!! $employee->first_name or '' !!}
                            {!! $employee->middle_name or '' !!}
                            {!! $employee->last_name or '' !!}
                        </dd>

                        <dt>Father's Name:</dt>
                        <dd>{!! $employee->father_name or '' !!}</dd>

                        <dt>Religion:</dt>
                        <dd>{!! $employee->religion or '' !!}</dd>

                        <dt>Marital Status:</dt>
                        <dd>{!! $employee->marital_status or '' !!}</dd>

                        @if($employee->bankName)
                            <dt>Bank & Branch Name:</dt>
                            <dd>{!! $employee->bankName->bank_name or '' !!},{!! $employee->bankbranch->branch_name or '' !!}</dd>

                            <dt>Bank Account No.:</dt>
                            <dd>{!! $employee->bank_account_no or '' !!}</dd>
                        @endif

                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt>National ID:</dt>
                        <dd>{!! $employee->nid or '' !!}</dd>

                        <dt>Date of Birth:</dt>
                        <dd>{!! dateFormat($employee->date_of_birth) !!}</dd>

                        <dt>Mother's Name:</dt>
                        <dd>{!! $employee->mother_name or '' !!}</dd>

                        <dt>Spouse Name:</dt>
                        <dd>{!! $employee->spouse_name or '' !!}</dd>

                        <dt>Personnel File No:</dt>
                        <dd>{!! $employee->personnel_file_no or '' !!}</dd>

                        <dt>Tax Identification No.:</dt>
                        <dd>{!! $employee->tin or '' !!}</dd>

                        <dt>Provident Fund No:</dt>
                        <dd>{!! $employee->provident_fund_no or '' !!}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>