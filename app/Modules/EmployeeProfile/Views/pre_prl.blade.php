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
                @include('errorOrSuccess')
                {!! Form::open(array('method' => 'get', 'id' => 'filter-form')) !!}

                <div class="col-md-12 side-padding-none">
                    <div class="col-md-1" style="margin-bottom:5px;">
                        {{ Form::text('ppo_no',request('ppo_no'), ['class' => 'form-control', 'id' => 'ppo_no','placeholder'=>'PPO No.']) }}
                    </div>

                    <div class="col-md-1" style="margin-bottom:5px;">
                        {{ Form::text('pfno',request('pfno'), ['class' => 'form-control', 'id' => 'pfno','placeholder'=>'PF No.']) }}
                    </div>
                    <div class="col-md-1" style="margin-bottom:5px;">
                        {{ Form::text('wasa_id',request('wasa_id'), ['class' => 'form-control', 'id' => 'wasa_id','placeholder'=>'WASA ID']) }}
                    </div>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        <input type="text" value="{{request('name')}}" class="form-control focus_it" name="name" id="name" placeholder="Employee Name">
                    </div>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        <input type="text" value="{{request('mobile','')}}" class="form-control focus_it" name="mobile" id="mobile" placeholder="Mobile">
                    </div>

                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-search"></i> Filter</button>
                    </div>
                    <div class="col-md-1">
                        <a href="{{url('pre-prl')}}" class="btn btn-danger filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-times"></i> Reset</a>
                    </div>

                </div>

                {!! Form::close() !!}

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
                    <span class="caption-subject bold uppercase">PRE PRL - ({{$employeeList->total()}})</span>
                </div>
                <div class="actions font-white">

                </div>

            </div>
            <div class="portlet-body">
                <div style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="nopagination">
                    <thead>
                        <tr>
                            <th style="padding: 8px !important;">PF No.</th>
{{--                            <th style="padding: 8px !important;">WASA Id.</th>--}}

                            <th style="padding: 8px !important;">Full Name</th>
                            <th style="padding: 8px !important;">Designation</th>
                            <th style="padding: 8px !important;">Department/Office</th>
                            <th style="padding: 8px !important;">Date of Birth (Age)</th>
                            <th style="padding: 8px !important;">PRL Date</th>
                            <th style="padding: 8px !important;">Notify</th>
                            <th style="padding: 8px !important;">Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($employeeList as $employee)

                        <tr>
                            <td>{{$employee->pfno}}</td>
{{--                            <td>{{$employee->wasa_id}}</td>--}}
                            <td>{{$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</td>

                            <td>@if($employee->designation) {{ $employee->designation->title }} @endif </td>
                            <td>@if($employee->department) {{$employee->department->department_name}} @endif</td>
                            <td>{{dateFormat($employee->date_of_birth)}} ({{getAgeYearMonth($employee->date_of_birth)}})</td>
                            <td>{{  date('d M,Y', strtotime($employee->expected_prl_date) )   }}</td>
                            <td>{{$employee->prl_notification_date ? 'Yes' : 'No'}}</td>
                            <td>{{$employee->status}}</td>

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

        highlight_nav('employee', 'pre-prl');

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