@extends('main_layouts.app')

@section('content')

    <div class="row animated flipInX">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Deduction Information</span>
                    </div>
                </div>
                <div class="portlet-body background-gray">
                    @include('errorOrSuccess')



                    <div class="col-md-12 side-padding-none">
                        {!! Form::open(array('route'=>'deduction-info.download','method' => 'post', 'id' => 'filter-form')) !!}

                        <div class="col-md-2" style="margin-bottom:5px;">
{{--                            {{ Form::select('month_id',$payroll_month,null, ['class' => 'form-control ', 'id' => 'month_id','required','placeholder' => 'Select Payroll Month']) }}--}}
                            {{ Form::selectMonth('month',null, ['class' => 'form-control','placeholder'=>'Select Month','style'=>'width:100%' ]) }}
                        </div>
                        <div class="col-md-2" style="margin-bottom:5px;">
                            {{ Form::selectYear('year',date('Y'),2019,null, ['class' => 'form-control','placeholder'=>'Select Year','style'=>'width:100%']) }}
                        </div>
                        <div class="col-md-2" style="margin-bottom:5px;">
                            {{ Form::select('deduction_type',get_deduction_info_array(),null, ['class' => 'form-control ', 'id' => 'gpf','required']) }}
                        </div>

                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-download"></i> Download</button>
                        </div>

                        {!! Form::close() !!}


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

            highlight_nav('deduction-info');
        });
    </script>

@endsection