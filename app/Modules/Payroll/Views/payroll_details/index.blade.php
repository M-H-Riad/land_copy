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

                <div class="col-md-12 side-padding-none">
                    {!! Form::open(array('method' => 'get', 'id' => 'filter-form')) !!}
                    <div class="col-md-1" style="margin-bottom:5px;">
                        {{ Form::text('pfno',request('pfno'), ['class' => 'form-control', 'id' => 'pfno','placeholder'=>'PF No.']) }}
                    </div>

                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-search"></i> Filter</button>
                    </div>
                    {!! Form::close() !!}

                     <div class="col-md-1">
                         <a href="{{url('payroll-details')}}" class="btn btn-danger filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-times"></i> Reset</a>
                     </div>

                </div>
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
                    <span class="caption-subject bold uppercase">Payroll Employee - Total - ({{$payrolls->total()}})</span>
                </div>


            </div>
            <div class="portlet-body">
                <div style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="nopagination">
                    <thead>
                        <tr>
                            <th style="padding: 8px !important;">PF No.</th>
                            <th style="padding: 8px !important;">Full Name</th>
                            <th style="padding: 8px !important;">Designation</th>
                            <th style="padding: 8px !important;">Department/Office</th>
                            <th style="padding: 8px !important;">Status</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($payrolls as $payroll)
{{--                            {{dd($payroll->employee->first_name)}}--}}
                        <tr>
                            <td>{{$payroll->pfno}}</td>
                            <td>{{$payroll->employee->first_name.' '.$payroll->employee->middle_name.' '.$payroll->employee->last_name}}</td>
                            <td>@if($payroll->employee->designation) {{ $payroll->employee->designation->title }} @endif </td>
                            <td>@if($payroll->employee->department) {{$payroll->employee->department->department_name}} @endif</td>
                            <td>{{$payroll->employee->status}}</td>
                            <td>
                                @if(Auth::user()->can('manage_payroll_setting'))
                                <a class="btn btn-success btn-sm mt-ladda-btn ladda-button" style=" padding: 5px;float: left" data-style="zoom-in" href="{{ route('payroll-details.edit',$payroll->id) }}">
                                    <span class="ladda-label">
                                        <i class="fa falist fa-magic"></i> Edit
                                    </span>
                                </a>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                @if(count($payrolls)>0)
                    {{$payrolls->appends($_REQUEST)->render()}}
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

        highlight_nav('payroll-details');

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