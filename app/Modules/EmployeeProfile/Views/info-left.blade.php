@if(Auth::user()->can('profile_view_only'))

    @if($employee->status == "New")
        @include('EmployeeProfile::show.personal-info-pension')
    @else
        @include('EmployeeProfile::show.personal-info')
    @endif
@elseif (Auth::user()->can('manage_pension_employee'))
<!-- BEGIN Personal Info -->
@include('EmployeeProfile::show.personal-info-pension')
<!-- END Personal Info -->
@elseif(Auth::user()->can('profile_view_only'))
@include('EmployeeProfile::show.personal-info')
@endif

@if(Auth::user()->can('job_view_only') && request('type')!='pension')
<!-- BEGIN job -->
@include('EmployeeProfile::show.job')
<!-- END job -->
@endif

@if(Auth::user()->can('children_view_only') && request('type')!='pension')
@if($employee->marital_status != 'Unmarried')
<!-- BEGIN Children -->
@include('EmployeeProfile::show.children')
<!-- END Children -->
@endif
@endif

@if(Auth::user()->can('academic_view_only') && request('type')!='pension')
<!-- BEGIN academic -->
@include('EmployeeProfile::show.academic')
<!-- END academic -->
@endif
@if(Auth::user()->can('quarter_view_only') && request('type')!='pension')
<!-- BEGIN quarter -->
@include('EmployeeProfile::show.quarter')
<!-- END quarter -->
@endif
@if(Auth::user()->can('experience_view_only') && request('type')!='pension')
<!-- BEGIN experience -->
@include('EmployeeProfile::show.experience')
<!-- END experience -->
@endif
@if(Auth::user()->can('pension_job_view_only') && request('type')=='pension')
<!-- BEGIN experience -->
@include('EmployeeProfile::show.pension_job')
<!-- END experience -->
@endif
@if(Auth::user()->can('training_view_only') && request('type')!='pension')
<!-- BEGIN training -->
@include('EmployeeProfile::show.training')
<!-- END training -->
@endif
@if(Auth::user()->can('transfer_view_only') && request('type')!='pension')
<!-- BEGIN transfer -->
@include('EmployeeProfile::show.transfer')
<!-- END transfer -->
@endif

@if(Auth::user()->can('leave_view_only') && request('type')!='pension')
    <!-- BEGIN transfer -->
    @include('EmployeeProfile::show.leave')
    <!-- END transfer -->
@endif

@if(Auth::user()->can('disciplinary_records_view_only') && request('type')!='pension')
<!-- BEGIN suspension -->
@include('EmployeeProfile::show.disciplinary_records')
<!-- END suspension -->
@endif

@if(Auth::user()->can('pension_bank_account_view_only') && request('type')=='pension')
<!-- BEGIN suspension -->
@include('EmployeeProfile::show.pension_bank_account')
<!-- END suspension -->
@endif

@if(Auth::user()->can('view_pension_relatives') && request('type')=='pension')
@include('EmployeeProfile::show.pension-relative')
@endif

