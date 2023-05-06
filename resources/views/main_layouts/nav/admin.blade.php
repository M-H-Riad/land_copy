<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            {{--<li class="nav-item dashboard">
                <a href="{{ URL::to('/home') }}">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->can(['manage_audit_trail']))
            <li class="nav-item audit-trail">
                <a href="{{route('audit-trail.index') }}">
                    <i class="icon-list"></i>
                    <span class="title">Audit Trail</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->can(['lab_test_result','chlorine_demand_test','water_sample_test','central_quality_control','saidabad_water_treatment_plant','bottle_plant_water_quality_analysis','morning_water_analysis','daily_water_quality_analysis','water_quality_analysis_report']))
                <li class="heading">
                    <h3 class="uppercase">Lab Test</h3>
                </li>
                @if(Auth::user()->can(['lab_test_result']))
                <li class="nav-item ">
                    <a href="{{ route('lab-test-result.index') }}">
                        <i class="fa fa-table"></i>
                        <span class="title">Lab Test Result</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->can(['chlorine_demand_test']))
                <li class="nav-item ">
                    <a href="{{ route('chlorine-demand-test.index') }}">
                        <i class="fa fa-table"></i>
                        <span class="title">Chlorine Demand Test</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->can(['water_sample_test']))

                <li class="nav-item ">
                    <a href="{{ route('water-sample-test.index') }}">
                        <i class="fa fa-table"></i>
                        <span class="title">Water Sample Test</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->can(['central_quality_control','saidabad_water_treatment_plant','bottle_plant_water_quality_analysis']))

                <li class="nav-item" id="water_quality_analysis">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-dashboard"></i>
                        <span class="title">Water Quality Analysis</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @if(Auth::user()->can(['central_quality_control']))
                        <li class="nav-item ">
                            <a href="{{ route('central-water-quality-analysis.index') }}">
--}}{{--                                <i class="fa fa-table"></i>--}}{{--
                                <span class="title">Central Quality Control</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->can(['saidabad_water_treatment_plant']))
                        <li class="nav-item ">
                            <a href="{{ route('saidabad-water-quality-analysis.index') }}">
                                --}}{{--                                <i class="fa fa-table"></i>--}}{{--
                                <span class="title">Saidabad Water Treatment Plant</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->can(['bottle_plant_water_quality_analysis']))
                        <li class="nav-item ">
                            <a href="{{ route('bottle-water-quality-analysis.index') }}">
                                --}}{{--                                <i class="fa fa-table"></i>--}}{{--
                                <span class="title">Bottle Plant</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
            @endif

            @if(Auth::user()->can(['morning_water_analysis']))
                <li class="nav-item ">
                    <a href="{{ route('morning-water-quality-analysis.index') }}">
                        <i class="fa fa-table"></i>
                        <span class="title">Morning Water Analysis</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->can(['daily_water_quality_analysis']))
                <li class="nav-item ">
                    <a href="{{ route('water-quality-analysis.index') }}">
                        <i class="fa fa-table"></i>
                        <span class="title">Daily Water Quality Analysis</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->can(['water_quality_analysis_report']))
                <li class="nav-item ">
                    <a href="{{ route('water-quality-report.index') }}">
                        <i class="fa fa-table"></i>
                        <span class="title">Water Quality Analysis Report</span>
                    </a>
                </li>
            @endif

                @if(Auth::user()->can(['manage_lab_test']))
                <li class="heading">
                    <h3 class="uppercase">Lab Test Configuration</h3>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('labs.index') }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">Laboratory</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('lab-report-head.index') }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">Laboratory Report Heads</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('lab-test-author.index') }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">Laboratory Authors</span>
                    </a>
                </li>
                
                <li class="nav-item ">
                    <a href="{{ route('standard-parameter-value.index') }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">Parameter Standard Value</span>
                    </a>
                </li>

                @set($url, "lab-water-type")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('water-type')}}</span>
                    </a>
                </li>

                @set($url, "lab-water-sample-source")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('water-sample-source')}}</span>
                    </a>
                </li>

                @set($url, "lab-zone")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('zone')}}</span>
                    </a>
                </li>

                @set($url, "lab-pump")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('Pump')}}</span>
                    </a>
                </li>

                @set($url, "lab-treatment-plant")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('treatment-plant')}}</span>
                    </a>
                </li>

                @set($url, "lab-unit")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('unit')}}</span>
                    </a>
                </li>

                @set($url, "lab-testing-parameter")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('testing-parameter')}}</span>
                    </a>
                </li>
                @set($url, "lab-dma")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('DMA')}}</span>
                    </a>
                </li>

                @set($url, "lab-institute")
                <li class="nav-item {{$url}}">
                    <a href="{{ route("{$url}.index") }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">{{fieldLabel('Institute')}}</span>
                    </a>
                </li>

            @endif

            @if(Auth::user()->can(['create_employee','manage_employee','prl_retirement','manage_pension']))
                <li class="heading">
                    <h3 class="uppercase">Employee Management</h3>
                </li>

                <li class="nav-item employee">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-users"></i>
                        <span class="title">Employee</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @if(Auth::user()->can('create_employee') and Auth::user()->can('manage_employee'))
                            <li class="nav-item create-employee">
                                <a href="{{ URL::to('/employee-profile/create') }}" class="nav-link ">
                                    <span class="title">Create Employee</span>
                                </a>
                            </li>
                        @endif


                        @if(Auth::user()->can('manage_employee'))
                            <li class="nav-item manage-employee">
                                <a href="{{ URL::to('/employee-profile') }}" class="nav-link ">
                                        <span class="title">Manage Employee</span>
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->can('prl_retirement'))
                                <li class="nav-item pre-prl">
                                    <a href="{{route('pre-prl')}}" class="nav-link ">
                                        <span class="title">PRE PRL List</span>
                                    </a>
                                </li>
                            <li class="nav-item prl-retirement">
                                <a href="{{route('prl-retirement')}}" class="nav-link ">
                                    <span class="title">PRL & Retirement List</span>
                                </a>
                            </li>
                        @endif
                            @if(Auth::user()->can('manage_pension') and Auth::user()->can('create_employee'))
                                <li class="nav-item create-pension-employee">
                                    <a href="{{route('emp.pension-employee')}}" class="nav-link ">
                                        <span class="title">Create Pension Employee</span>
                                    </a>
                                </li>
                            @endif

                            @if(Auth::user()->can('manage_pension'))
                                <li class="nav-item pension-holder">
                                    <a href="{{ URL::to('/pension-holder') }}" class="nav-link ">

                                            <span class="title">Pension Holder List</span>
                                    </a>
                                </li>
                            @endif

                    </ul>
                </li>
            @endif

            @if(count(auth()->user()->pensionAuthor) or pensionAdminApprove())
                <li class="heading">
                    <h3 class="uppercase">Approve Pension</h3>
                </li>
                <li class="nav-item approve_pension_application">
                    <a href="{{ url('pensionApplication/approve-application') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Approve Pension Application</span>
                    </a>
                </li>
            @endif


            <li class="heading">
                <h3 class="uppercase">Loan</h3>
            </li>
            @if(Auth::user()->can('loan_application'))
            <li class="nav-item new_loan_application new_loan_application">
                <a href="{{ route("loan.application.index") }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">Loan Applications</span>
                </a>
            </li>
            @endif
            @if(count(Auth::user()->hods) || Auth::user()->waitingLoanApplications || Auth::user()->loanApprover)
            <li class="nav-item new_loan_application new_loan_application">
                <a href="{{ route("loan.application.waiting") }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">Waiting Loan Applications</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->can('loan_application_history'))
            <li class="nav-item loan_approval_history">
                <a href="{{ route("loan.application.approval_history") }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">Approval History</span>
                </a>
            </li>
            @endif
            
<!--            @if(Auth::user()->can(['loan_application','loan_application_approve',
            'loan_application_history','manage_all_loan_applications',
            'committee_manage_all_loan_applications','as_user_manage_all_loan_applications',
            'ds_user_manage_all_loan_applications','secretary_manage_all_loan_applications',
            'md_manage_all_loan_applications','dmd_manage_all_loan_applications']))
                <li class="heading">
                    <h3 class="uppercase">Loan</h3>
                </li>
                @if(Auth::user()->can('loan_application'))
                    <li class="nav-item new_loan_application new_loan_application">
                        <a href="{{ route("loan.application.index") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Loan Applications</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('loan_application_approve'))
                    <li class="nav-item waiting_loans_for_approval">
                        <a href="{{ route("loan.application.witness_guarantor.waiting_loan") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Waiting Loans for Approval </span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('loan_application_history'))
                    <li class="nav-item loan_approval_history">
                        <a href="{{ route("loan.application.approval_history") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Approval History</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_all_loan_applications'))
                    <li class="nav-item all_loan_applications">
                        <a href="{{ route("loan.application.admin.waiting_loan") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">All Loan Applications</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('committee_manage_all_loan_applications'))
                    <li class="nav-item all_loan_applications">
                        <a href="{{ route("loan.application.committee.waiting_loan") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">All Loan Applications</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('as_user_manage_all_loan_applications'))
                    <li class="nav-item all_loan_applications">
                        <a href="{{ route("loan.application.as_user.waiting_loan") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">All Loan Applications</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('ds_user_manage_all_loan_applications'))
                    <li class="nav-item all_loan_applications">
                        <a href="{{ route("loan.application.ds_user.waiting_loan") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">All Loan Applications</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('secretary_manage_all_loan_applications'))
                    <li class="nav-item all_loan_applications">
                        <a href="{{ route("loan.application.secretary.waiting_loan") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">All Loan Applications</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('md_manage_all_loan_applications'))
                    <li class="nav-item all_loan_applications">
                        <a href="{{ route("loan.application.md.waiting_loan") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">All Loan Applications</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('dmd_manage_all_loan_applications'))
                    <li class="nav-item all_loan_applications">
                        <a href="{{ route("loan.application.dmd.waiting_loan") }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">All Loan Applications</span>
                        </a>
                    </li>
                @endif
            @endif-->
            @if(Auth::user()->can(['manage_pension_application','manage_pension_deduction','manage_pension_application','manage_pension_fund_report','manage_pension_monthly_report','manage_pension_general_setting']))
                <li class="heading">
                    <h3 class="uppercase">Pension</h3>
                </li>
                @if(Auth::user()->can('manage_pension_application'))
                    <li class="nav-item manage_pension_application">
                        <a href="{{ url('pensionApplication/all-application') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Pension Applications</span>
                        </a>
                    </li>
                @endif

                <li class="heading">
                    <h3 class="uppercase">Personal Pension</h3>
                </li>

                <li class="nav-item pension-application">
                    <a href="{{ route('pension-application.index') }}">
                        <i class="icon-home"></i>
                        <span class="title">Pension Application</span>
                    </a>
                </li>


                @if(Auth::user()->can('manage_pension_deduction'))
                    <li class="nav-item pension_deduction">
                        <a href="{{ route('pension-deduction.index') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Pension Deduction</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_pension_general_setting'))
                    <li class="nav-item pension_general_setting">
                        <a href="{{ URL::to('/pension-general-setting') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">General Setting</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_pension_application'))
                    <li class="nav-item ppension-application">
                        <a href="{{ URL::to('/ppension-application') }}">
                            <i class="fa fa-list-ol"></i>
                            <span class="title">Application List</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_pension_fund_report'))
                    <li class="nav-item pension-fund-report">
                        <a href="{{ URL::to('/pension-fund-report') }}">
                            <i class="fa fa-file-text-o"></i>
                            <span class="title">Retired Employee Report</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_pension_monthly_report'))
                    <li class="nav-item generate-monthly-pension-report">
                        <a href="{{ URL::to('generate-monthly-pension-report') }}">
                            <i class="fa fa-file-text-o"></i>
                            <span class="title">Monthly Pension Report</span>
                        </a>
                    </li>
                <!--            <li class="nav-item generate-monthly-pension-report-by-emp">
                <a href="{{ URL::to('generate-pension-report-by-emp') }}">
                    <i class="fa fa-file-text-o"></i>
                    <span class="title">Pension Report By Employee</span>
                </a>
            </li>-->
                @endif
            @endif


            @if(Auth::user()->can(['manage_scholarship','manage_treatment','application_settings']))
                <li class="heading">
                    <h3 class="uppercase">WASA Application</h3>
                </li>
                @if(Auth::user()->can('application_settings'))
                    <li class="nav-item application_settings">
                        <a href="{{ route('application-setting.index') }}">
                            <i class="fa fa-file-archive-o"></i>
                            <span class="title">Application Settings</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_scholarship'))
                    <li class="nav-item manage-scholarship">
                        <a href="{{ route('scholarship.index') }}">
                            <i class="fa fa-file-archive-o"></i>
                            <span class="title">Scholarship Applications</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_treatment'))
                    <li class="nav-item manage-treatment">
                        <a href="{{ route('treatment.index') }}">
                            <i class="fa fa-file-archive-o"></i>
                            <span class="title">Treatment Application</span>
                        </a>
                    </li>
                @endif
            @endif
            @if(Auth::user()->can(['manage_leverage']))
                <li class="heading">
                    <h3 class="uppercase">Leverage</h3>
                </li>
                --}}{{--@if(Auth::user()->can('leverage-product'))--}}{{--
                <li class="nav-item leverage-product">
                    <a href="{{ url('leverage/product') }}">
                        <i class="fa fa-file-archive-o"></i>
                        <span class="title">Products</span>
                    </a>
                </li>
                <li class="nav-item leverage-distribution">
                    <a href="{{ url('leverage/distribution') }}">
                        <i class="fa fa-file-archive-o"></i>
                        <span class="title">Distribution</span>
                    </a>
                </li>
                --}}{{--@endif--}}{{--
            @endif


            @if(Auth::user()->can(['manage_file_type','manage_pay_scale','manage_department','manage_designation','manage_membership_organaization','manage_university','manage_role','manage_bank_account','manage_qualication']))

                <li class="heading">
                    <h3 class="uppercase">General Configuration</h3>
                </li>
                @if(Auth::user()->can('manage_prl_settings'))
                    <li class="nav-item prl-settings">
                        <a href="{{ url('prl-settings') }}">
                            <i class="fa fa-file-archive-o"></i>
                            <span class="title">Manage PRL Settings</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_file_type'))
                    <li class="nav-item file-type">
                        <a href="{{ URL::to('/file-type') }}">
                            <i class="fa fa-file-archive-o"></i>
                            <span class="title">Manage File Type</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_pay_scale'))
                    <li class="nav-item pay_scale">
                        <a href="{{ URL::to('/pay-scale') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">Pay Scale</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->can('manage_department'))
                    <li class="nav-item department">
                        <a href="{{ URL::to('/department') }}">
                            <i class="fa fa-caret-right"></i>
                            <span class="title">Manage Department</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_designation'))
                    <li class="nav-item designation">
                        <a href="{{ URL::to('/designation') }}">
                            <i class="fa fa-caret-right"></i>
                            <span class="title">Manage Designation</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_membership_organaization'))
                    <li class="nav-item membership-org">
                        <a href="{{ URL::to('/membership-org') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">Membership Organization</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_university'))
                    <li class="nav-item university">
                        <a href="{{ URL::to('/university') }}">
                            <i class="fa fa-university"></i>
                            <span class="title">Manage University</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_quota'))
                    <li class="nav-item university">
                        <a href="{{ URL::to('/quota') }}">
                            <i class="fa fa-secret"></i>
                            <span class="title">Manage Quota</span>
                        </a>
                    </li>
                @endif


                @if(Auth::user()->can('manage_role'))
                    <li class="nav-item role">

                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-user-secret"></i>
                            <span class="title">Permission</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">


                            <li class="nav-item role-add">
                                <a href="{!! url('/role/create') !!}" class="nav-link ">
                                    <span class="title">Add</span>
                                </a>
                            </li>
                            <li class="nav-item role-manage">
                                <a href="{!! url('role') !!}" class="nav-link ">
                                    <span class="title">Manage</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
                @if(Auth::user()->can('manage_bank_account'))
                    <li class="nav-item bank-account">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-balance-scale"></i>
                            <span class="title">Bank Account</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="nav-item bank">
                                <a href="{!! url('/bank') !!}" class="nav-link ">
                                    <span class="title">Bank</span>
                                </a>
                            </li>
                            <li class="nav-item branch">
                                <a href="{!! url('/branch') !!}" class="nav-link ">
                                    <span class="title">Branch</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
                @if(Auth::user()->can('manage_qualication'))
                    <li class="nav-item manage_qualification">
                        <a href="{{ URL::to('/qualification') }}">
                            <i class="fa fa-graduation-cap"></i>
                            <span class="title">Manage Qualification</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_leave_type'))
                    <li class="nav-item manage_leave_type">
                        <a href="{{ URL::to('/leave-type') }}">
                            <i class="fa fa-calendar-plus-o"></i>
                            <span class="title">Manage Leave Type</span>
                        </a>
                    </li>
                @endif
            @endif
            @if(Auth::user()->can(['manage_division','manage_district','manage_thana_upazila']))
                <li class="heading">
                    <h3 class="uppercase">Location Setting</h3>
                </li>
                @if(Auth::user()->can('manage_division'))
                    <li class="nav-item division">
                        <a href="{{ URL::to('/division') }}">
                            <i class="fa fa-map-marker"></i>
                            <span class="title">Divisions</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_district'))
                    <li class="nav-item district">
                        <a href="{{ URL::to('/district') }}">
                            <i class="fa fa-map-marker"></i>
                            <span class="title">Districts</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_thana_upazila'))
                    <li class="nav-item thana">
                        <a href="{{ URL::to('/thana') }}">
                            <i class="fa fa-map-marker"></i>
                            <span class="title">Thana/Upazila</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_post_office'))
                    <li class="nav-item post_office">
                        <a href="{{ URL::to('/post-office') }}">
                            <i class="fa fa-map-marker"></i>
                            <span class="title">Post Office</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_quarter_location'))
                    <li class="nav-item quarter_location">
                        <a href="{{ URL::to('/quarter-location') }}">
                            <i class="fa fa-map-marker"></i>
                            <span class="title">Quarter Location</span>
                        </a>
                    </li>
                @endif
            @endif
            @if(Auth::user()->can('manage_pensionable_setting'))
                <li class="heading">
                    <h3 class="uppercase">Pensionable Setting</h3>
                </li>

                <li class="nav-item pensionable_time_period_year">
                    <a href="{{ URL::to('/pensionable-time-period-year') }}">
                        <i class="fa fa-calendar-check-o"></i>
                        <span class="title">Year</span>
                    </a>
                </li>
                <li class="nav-item pensionable_time_period_percent">
                    <a href="{{ URL::to('/pensionable-percent') }}">
                        <i class="fa fa-minus"></i>
                        <span class="title">Percentage</span>
                    </a>
                </li>
                <li class="nav-item gratuity_year">
                    <a href="{{ URL::to('/gratuity-year') }}">
                        <i class="fa fa-calendar-check-o"></i>
                        <span class="title">Gratuity Year</span>
                    </a>
                </li>
                <li class="nav-item gratuity_value">
                    <a href="{{ URL::to('/gratuity-value') }}">
                        <i class="fa fa-minus"></i>
                        <span class="title">Gratuity Value</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->can('manage_payroll'))
                <li class="heading">
                    <h3 class="uppercase">Payroll Management</h3>
                </li>
                --}}{{--@if(Auth::user()->can('manage_payroll_head_setting'))--}}{{--
                --}}{{--<li class="nav-item payroll_head_setting">--}}{{--
                --}}{{--<a href="{{ URL::to('/payroll-head-setting') }}">--}}{{--
                --}}{{--<i class="fa fa-wrench"></i>--}}{{--
                --}}{{--<span class="title">Payroll Head Setting</span>--}}{{--
                --}}{{--</a>--}}{{--
                --}}{{--</li>--}}{{--
                --}}{{--@endif--}}{{--

                @if(Auth::user()->can('manage_payroll_monthly_salary'))
                    <li class="nav-item payroll">
                        <a href="{{ URL::to('/payroll') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">Monthly Salary</span>
                        </a>
                    </li>
                    <li class="nav-item bonus">
                        <a href="{{ URL::to('/bonus') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">Festival Bonus</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->can('manage_overtime'))
                    <li class="nav-item overtime">
                        <a href="{{ URL::to('/overtime') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">Overtime</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_night_allowance'))
                    <li class="nav-item night-allowance">
                        <a href="{{ URL::to('/night-allowance') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">Night Allowance</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_ifter_bill'))
                    <li class="nav-item ifter-bill">
                        <a href="{{ URL::to('/ifter-bill') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">Ifter Bill</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->can('manage_payroll_setting'))
                    <li class="nav-item payroll_setting">
                        <a href="{{ URL::to('/payroll-setting') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Payroll Setting</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_payroll_details'))
                    <li class="nav-item payroll-details">
                        <a href="{{ URL::to('/payroll-details') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Payroll Details</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_bonus_setting'))
                    <li class="nav-item bonus_setting">
                        <a href="{{ URL::to('/bonus-setting') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Bonus Setting</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('manage_salary_increment'))
                    <li class="nav-item salary_increments">
                        <a href="{{ URL::to('/salary-increment') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Salary Increments</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('change_salary_department'))
                    <li class="nav-item change_salary_department">
                        <a href="{{ URL::to('/payroll/change_salary_department') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Change Salary Department</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('salary_report'))
                    <li class="nav-item salary-report">
                        <a href="{{ URL::to('/salary-report') }}">
                            <i class="fa fa-bar-chart"></i>
                            <span class="title">Salary Report</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('income_tax_report'))
                    <li class="nav-item income-tax-report">
                        <a href="{{ URL::to('/income-tax-report') }}">
                            <i class="fa fa-bar-chart"></i>
                            <span class="title">Income Tax Report</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('deduction_info'))
                    <li class="nav-item deduction-info">
                        <a href="{{ URL::to('/deduction-info') }}">
                            <i class="fa fa-minus-square"></i>
                            <span class="title">Deduction Information</span>
                        </a>
                    </li>
                @endif

            @endif

            @if(Auth::user()->can(['manage_loan_management']))
                <li class="heading">
                    <h3 class="uppercase">Loan Management</h3>
                </li>

                @if(Auth::user()->can('manage_loan_application'))
                    <li class="nav-item loan_application">
                        <a href="{{route('loan-application.index') }}" class="nav-link  ">
                            <i class="fa fa-paper-plane-o"></i>
                            <span class="title">Loan Application </span>
                        </a>
                    </li>

                @endif
                <li class="nav-item loan_setting">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-gear"></i>
                        <span class="title">Loan Settings </span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">

                        @if(Auth::user()->can('manage_loan_category'))
                            <li class="nav-item loan_category">
                                <a href="{{ URL::to('/loan-category') }}">
                                    <i class="fa fa-bars"></i>
                                    <span class="title">Categories</span>
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->can('manage_loan_interest'))
                            <li class="nav-item loan_interest">
                                <a href="{{ URL::to('/loan-interest') }}">
                                    <i class="fa fa-plus"></i>
                                    <span class="title">Interest</span>
                                </a>
                            </li>
                        @endif
                            @if(Auth::user()->can('manage_loan_committee_setup'))
                                <li class="nav-item loan_committee_setup">
                                    <a href="{{ URL::to('/loan/committee-setup') }}">
                                        <i class="fa fa-plus"></i>
                                        <span class="title">Committee Setup</span>
                                    </a>
                                </li>
                            @endif
                    </ul>
                </li>
            @endif--}}



            @if(Auth::user()->can(['manage_land']))
                <li class="heading">
                    <h3 class="uppercase">Land Management</h3>
                </li>
                <li class="nav-item land_zone">
                    <a href="{{ URL::to('/land/zone') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">জোন</span>
                    </a>
                </li>
                <li class="{{ request()->is('land/zila') ? 'active' : '' }}">
                    <a href="{{ URL::to('/land/zila') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">জেলা </span>
                    </a>
                </li>
                <li class="{{ request()->is('land/thana') ? 'active' : '' }}">
                    <a href="{{ URL::to('/land/thana') }}">
                        <i class="fa fa-map-pin"></i>
                        <span class="title">থানা </span>
                    </a>
                </li>
                <li class="{{ request()->is('land/area') ? 'active' : '' }}">
                    <a href="{{ URL::to('/land/area') }}">
                        <i class="fa fa-map-signs"></i>
                        <span class="title">মৌজা </span>
                    </a>
                </li>
                <li class="nav-item land_source">
                    <a href="{{ URL::to('/land/source') }}">
                        <i class="fa fa-location-arrow"></i>
                        <span class="title">উৎস</span>
                    </a>
                </li>
                <li class="nav-item land_land">
                    <a href="{{ URL::to('/land/land') }}"> 
                        <i class="fa fa-map"></i>
                        <span class="title">ল্যান্ড</span>
                    </a>
                </li>
                <li class="nav-item land_vumi_office">
                    <a href="{{ URL::to('/land/vumi_office') }}">
                        <i class="fa fa-map-signs"></i>
                        <span class="title">ভূমি অফিসের তথ্য </span>
                    </a>
                </li>
                <li class="nav-item land_namjari">
                    <a href="{{ URL::to('/land/namjari') }}">
                        <i class="fa fa-map"></i>
                        <span class="title">নামজারি</span>
                    </a>
                </li>
                <li class="nav-item land_khajnaOffice">
                    <a href="{{ URL::to('/land/khajna-office') }}">
                        <i class="fa fa-map"></i>
                        <span class="title">স্থাপনা অনুযায়ী ভূমি অফিস</span>
                    </a>
                </li>
                <li class="nav-item land_khajnaInfo">
                    <a href="{{ URL::to('/land/khajna-info') }}">
                        <i class="fa fa-map"></i>
                        <span class="title">খাজনা বিবরণী</span>
                    </a>
                </li>
                <li class="nav-item land_propertyType">
                    <a href="{{ URL::to('/land/propertytype') }}">
                        <i class="fa fa-map"></i>
                        <span class="title">প্রপার্টির ধরন</span>
                    </a>
                </li>
                <li class="nav-item land_property">
                    <a href="{{ URL::to('/land/property') }}">
                        <i class="fa fa-map"></i>
                        <span class="title">প্রপার্টির তথ্য</span>
                    </a>
                </li>

                <li class="heading">
                    <h3 class="uppercase">Land Reports</h3>
                </li>
                <li class="nav-item land_khajna_pay_report">
                    <a href="{{ URL::to('/land/khajna/payment/report') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">স্থাপনা হিসেবে খাজনা পরিশোধ</span>
                    </a>
                </li>
                <li class="nav-item land_khajna_pay_vumioffice_report">
                    <a href="{{ URL::to('/land/yearly/khajna-pay/report') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">বাৎসরিক খাজনা পরিশোধের তথ্য</span>
                    </a>
                </li>
                <li class="nav-item land_khajna_bokeya_report">
                    <a href="{{ URL::to('/land/khajna-bokeya/report') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">স্থাপনা হিসেবে খাজনা বকেয়ার তথ্য</span>
                    </a>
                </li>
                <li class="nav-item land_khajna_pay_vumioffice_report">
                    <a href="{{ URL::to('/land/khajna-pay/vumioffice/report') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">ভূমি অফিস হিসেবে খাজনা তথ্য</span>
                    </a>
                </li>
                <li class="nav-item land_khajna_pay_zone_report">
                    <a href="{{ URL::to('/land/zone/khajna-pay/report') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">জোন হিসেবে খাজনা তথ্য</span>
                    </a>
                </li>
                <li class="nav-item land_khotian_namjari_report">
                    <a href="{{ URL::to('/land/khotian/namjari-report') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">খতিয়ান নং অনুযায়ী নামজারি তথ্য</span>
                    </a>
                </li>

                <!-- Start DeepTubewell -->
            @endif
            @if(Auth::user()->can(['manage_deeptubewell']))
                <li class="heading">
                    <h3 class="uppercase">Deep Tubewell</h3>
                </li>
                <li class="nav-item deep_tubewell_source">
                    <a href="{{ URL::to('/deep-tubewell/source-type') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">উৎসের ধরণ</span>
                    </a>
                </li>
                <li class="nav-item deep_tubewell">
                    <a href="{{ URL::to('/deep-tubewell/deep-tubewell') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">ডিপ টিউবওয়েল</span>
                    </a>
                </li>
                <li class="nav-item log_report">
                    <a href="{{ URL::to('/deep-tubewell/log-report') }}">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">লগ রিপোর্ট</span>
                    </a>
                </li>
                <!-- End DeepTubewell -->
            @endif

            @if(Auth::user()->hasRole('superadmin') and Auth::user()->user_name == 'sslrnd')
                <li class="nav-item audit-trail">
                    <a href="{{ URL::to('/audit-trail') }}">
                        <i class="fa fa-bug"></i>
                        <span class="title">Audit Trail</span>
                    </a>
                </li>
                <li class="nav-item audit-trail">
                    <a href="{{ URL::to('/logs') }}">
                        <i class="fa fa-list-alt"></i>
                        <span class="title">Logs</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->can(['manage_role']))

                <li class="heading">
                    <h3 class="uppercase">User Management</h3>
                </li>

                <li class="nav-item users">
                    <!-- <a href="{{ URL::to('/user/designation') }}" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">Designation</span>
                        <span class="arrow"></span>
                    </a>
                    <a href="{{ URL::to('/user/department') }}" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">Department</span>
                        <span class="arrow"></span>
                    </a> -->

                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">Users</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item register">
                            <a href="{{route('register') }}" class="nav-link">
                                <i class="fa fa-paper-plane-o"></i>
                                <span class="title">User Entry</span>
                            </a>
                        </li>
                        <li class="nav-item user_list">
                            <a href="{{URL::to('user-list')}}" class="nav-link">
                                <i class="fa fa-paper-plane-o"></i>
                                <span class="title">Manage User</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item role_user">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">Role User</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item role_user_create">
                            <a href="{{ URL::to('/role-user/create') }}" class="nav-link ">
                                <i class="fa fa-paper-plane-o"></i>
                                <span class="title">Add Role User</span>
                            </a>
                        </li>
                        <li class="nav-item role_user_manage">
                            <a href="{!! url('role-user') !!}" class="nav-link ">
                                <i class="fa fa-paper-plane-o"></i>
                                <span class="title">Manage Role User</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item permission">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">Permission</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item role_create">
                            <a href="{!! url('/role/create') !!}" class="nav-link ">
                                <i class="fa fa-paper-plane-o"></i>
                                <span class="title">Add New Role</span>
                            </a>
                        </li>
                        <li class="nav-item role_manage">
                            <a href="{!! url('role') !!}" class="nav-link ">
                                <i class="fa fa-paper-plane-o"></i>
                                <span class="title">Manage Role Permission</span>
                            </a>
                        </li>

                    </ul>
                </li>

            @endif

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>