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
            <div class="portlet-body background-gray">
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
                    <span class="caption-subject bold uppercase">Employee - Total - ({{$employeeList->total()}})</span>
                </div>
                <div class="actions font-white">
                    @if(!Auth::user()->hasRole('pensionadmin'))
                        <a href="{{route('download-excel')}}" class="btn btn-primary btn-sm vis_all">
                             Excel File List
                        </a>
                    <a href="{{route('export-excel', \Request::all())}}" class="btn btn-primary btn-sm vis_all">
                        <img src="{{url('images/Excel20101-20x20.png')}}" alt="Excel">
                        Excel Generate
                    </a>
                    <a href="{{route('export-basic-excel', \Request::all())}}" class="btn btn-primary btn-sm vis_basic hidden">
                        <img src="{{url('images/Excel20101-20x20.png')}}" alt="Excel">
                        Download in Excel
                    </a>
                    <a href="{{route('export-list-religion-pdf', \Request::all())}}" class="btn btn-primary btn-sm vis_all">
                        Download Employee Religion Wise PDF
                    </a>
                        <a href="{{route('export-list-pdf', \Request::all())}}" class="btn btn-primary btn-sm vis_all">
                            Download in PDF
                        </a>
                    <a href="{{route('export-basic-list-pdf', \Request::all())}}" class="btn btn-primary btn-sm vis_basic hidden">
                        Download in PDF
                    </a>
                    @endif
                </div>

            </div>
            <div class="portlet-body">
                <div style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="nopagination">
                    <thead>
                        <tr>
                            <th style="padding: 8px !important;">PF No.</th>
                            <th style="padding: 8px !important;">WASA Id.</th>

                            <th style="padding: 8px !important;">Full Name</th>
                            <th style="padding: 8px !important;">Designation</th>
                            <th style="padding: 8px !important;">Department/Office</th>
                            <th style="padding: 8px !important;">Date of Birth (Age)</th>
                            <th style="padding: 8px !important;">Status</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($employeeList as $employee)
                        <tr>
                            <td>{{$employee->pfno}}</td>
                            <td>{{$employee->wasa_id}}</td>
                            <td>{{$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</td>

                            <td>@if($employee->designation) {{ $employee->designation->title }} @endif </td>
                            <td>@if($employee->department) {{$employee->department->department_name}} @endif</td>
                            <td>{{dateFormat($employee->date_of_birth)}} ({{getAgeYearMonth($employee->date_of_birth)}})</td>
                            <td>{{$employee->status}}</td>
                            <td>
                                @if(Auth::user()->can('manage_employee'))
                                <a class="btn btn-success btn-sm mt-ladda-btn ladda-button" style=" padding: 5px;float: left" data-style="zoom-in" href="{{ route('employee-profile.show',$employee->id) }}">
                                    <span class="ladda-label">
                                        <i class="fa falist fa-magic"></i> Detail
                                    </span>
                                </a>
                                @endif
                                @if(Auth::user()->can('delete_employee'))
                                <form action="{{ route('employee-profile.destroy', $employee->id) }}" method="POST">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-xs" style="float: left"><i class="fa fa-trash-o"></i> Delete</button>
                                </form>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
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
            'sort': false
        });

        highlight_nav('employee', 'manage-employee');

        $("#excel-download-type").change(function () {
            var selector = $(this).val();
            $(this).attr("selected", "selected");

            if (selector === "all") {
                $(".vis_basic").toggleClass('hidden');
                $(".vis_all").toggleClass('hidden');
            } else {
                $(".vis_all").toggleClass('hidden');
                $(".vis_basic").toggleClass('hidden');
            }
        });
    });
</script>

@endsection