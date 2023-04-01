
@if(Auth::user()->can('search_with_employee_id'))
    @include('EmployeeProfile::show.quick-search')
@endif

@if(Auth::user()->can('photo_section_view_only'))
    @include('EmployeeProfile::show.photo')
@endif

@if(Auth::user()->can('login_user_view_only')  && request('type')!='pension')
    @include('EmployeeProfile::show.login-info')
@endif

@if(Auth::user()->can('assign_hod')  && request('type')!='pension')
    @include('EmployeeProfile::show.department-head')
@endif

@if(Auth::user()->can('present-address_view_only')  && request('type')!='pension')
    @include('EmployeeProfile::show.present-address')
@endif

@if(Auth::user()->can('permanent-address_view_only')  && request('type')!='pension')
    @include('EmployeeProfile::show.permanent-address')
@endif

@if(Auth::user()->can('document_view_only'))
    @include('EmployeeProfile::show.document')
@endif

<!-- BEGIN membership -->
@if(Auth::user()->can('membership_view_only')  && request('type')!='pension')
    @include('EmployeeProfile::show.membership')
@endif
<!-- END membership -->


<!-- BEGIN Payroll -->
@if(Auth::user()->can('employee_payroll_view_only')  && request('type')!='pension')
    @include('EmployeeProfile::show.payroll.employee-payroll')
@endif
<!-- END membership -->