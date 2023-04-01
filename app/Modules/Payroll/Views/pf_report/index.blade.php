@extends('main_layouts.app')

@section('content')

    <div class="row animated flipInX">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">GPF Report</span>
                    </div>
                </div>
                <div class="portlet-body background-gray">
                    @include('errorOrSuccess')



                    <div class="col-md-12 side-padding-none">
                        {!! Form::open(array('route'=>'gpf-report.download','method' => 'post', 'id' => 'filter-form')) !!}
                            <div class="col-md-2" style="margin-bottom:5px;">
                                {{ Form::select('gpf',get_gpf_report_array(),null, ['class' => 'form-control ', 'id' => 'gpf','required']) }}
                            </div>
                        <div class="col-md-1" style="margin-bottom:5px;">
                                {{ Form::text('pfno',request('pfno'), ['class' => 'form-control', 'id' => 'pfno','placeholder'=>'PF No.']) }}
                            </div>
                            <div class="col-md-1" style="margin-bottom:5px;">
                                {{ Form::text('from',request('from'), ['class' => 'form-control mask_date', 'id' => 'prlStart','placeholder'=>'Date From']) }}
                            </div>
                            <div class="col-md-1" style="margin-bottom:5px;">
                                {{ Form::text('to',request('to'), ['class' => 'form-control mask_date', 'id' => 'prlStart','placeholder'=>'Date To']) }}
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-download"></i> Download</button>
                            </div>

                        {!! Form::close() !!}

{{--                        <div class="col-md-1">--}}
{{--                            <a href="{{url('income-tax-report')}}" class="btn btn-danger filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-times"></i> Reset</a>--}}
{{--                        </div>--}}

                    </div>

                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#nopagination').DataTable({
                "paging": false,
                "iDisplayLength": 25
            });

            highlight_nav('salary-report');
        });
    </script>

@endsection