@extends('main_layouts.app')

@section('content')

    <div class="row animated flipInX">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Filter</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('EmployeeProfile::search-form')
                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>

    <div class="row animated zoomIn">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Pension Holder - Total - ({{$employeeList->total()}})</span>
                    </div>
                    <div class="actions font-white">
                        @if (!Auth::user()->can('manage_pension'))
                            <a href="{{route('export-excel', \Request::all())}}" class="btn btn-primary btn-sm">
                                <img src="{{url('images/Excel20101-20x20.png')}}" alt="Excel">
                                Download in Excel
                            </a>
                        @endif
                    </div>

                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="nopagination">
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">Full Name</th>
                            <th style="padding: 8px !important;">PPO No.</th>
                            <th style="padding: 8px !important;">Designation</th>
                            <th style="padding: 8px !important;">Department/Office</th>
                            <th style="padding: 8px !important;">Date of Birth (Age)</th>
                            <th style="padding: 8px !important;">Status</th>
                            <th style="padding: 8px !important;">Detail</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($employeeList as $employee)
                            <tr style="{{ (isFresherPensionar($employee->id))?'background-color:#c5eac4':''}}">
                                <td>{{$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</td>
                                <td>{{$employee->ppo_no}}</td>
                                <?php
                                $designation = '';

                                $job = $employee->pensionJob->last();

                                if($job && $job->designation) {
                                    $designation = $job->designation->title;
                                    if($job->designation_status and $job->designation_status !=='Normal')
                                        $designation .= ' - ' . $job->designation_status;
                                }

                                ?>
                                <td>{{$designation}} </td>

                                <?php
                                $department = '';

                                if($job && $job->department){
                                    $department = $job->department->department_name;
                                }
                                ?>
                                <td>{{$department}}</td>
                                <td>{{dateFormat($employee->date_of_birth,'d/m/Y')}} ({{$employee->age}} years)</td><td>{{$employee->status}}</td>
                                <td>
                                    @if(Auth::user()->can('manage_pension'))
                                        <a class="btn btn-success btn-sm mt-ladda-btn ladda-button" style=" padding: 5px;" data-style="zoom-in" href="{{ route('employee-profile.show',$employee->id) }}?type=pension">
                                    <span class="ladda-label">
                                        <i class="fa falist fa-magic"></i> Detail
                                    </span>
                                        </a>
                                    @endif

                                   {{--  @if(Auth::user()->can('manage_pension_monthly_report'))
                                        <a class="btn btn-info btn-sm mt-ladda-btn ladda-button" style=" padding: 5px;" data-style="zoom-in" href="{{url('generate-monthly-pension-report/create?employee_id='.$employee->id) }}">
                                    <span class="ladda-label">
                                        <i class="fa falist fa-list-alt"></i> Generate Monthly <br> Pension Report
                                    </span>
                                        </a>
                                    @endif --}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if(count($employeeList)>0)
                        {{$employeeList->appends($_REQUEST)->render()}}
                    @endif
                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>



    <script type="text/javascript">
        $(document).ready(function () {

            $('#nopagination').DataTable({
                "paging": false,
                "bFilter": false,
                "info": false,
                'sort':false
            });

            highlight_nav('employee', 'pension-holder');
        });
    </script>

@endsection