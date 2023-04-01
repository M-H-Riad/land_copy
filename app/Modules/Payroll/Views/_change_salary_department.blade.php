@extends('main_layouts.app')

@section('content')


    @include('errorOrSuccess')
    <div class="row animated zoomIn">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green col-md-12">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Change Salary Department for a Employee in Special Case</span>
                    </div>
                </div>
                @if(!isset($payrollemployee))
                    <div class="portlet-body background-gray">
                        <div class="col-md-12 side-padding-none">
                            {!! Form::open(['method' => 'get'] ) !!}
                            <div class="col-md-2" style="margin-bottom:5px;">
                                {!! Form::select('month_id',$months,request('class_to'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select Salary Month','style' => 'width:100%','required']) !!}
                            </div>

                            <div class="col-md-2" style="margin-bottom:5px;">
                                {!! Form::text('pfno',request('department_id'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'PFNO','style' => 'width:100%','required']) !!}
                            </div>

                            <div class="col-md-1" style="margin-bottom:5px;">
                                <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endif
                @if(Auth::user()->can('change_salary_department') && isset($payrollemployee) && !empty($payrollemployee))
                    <div class="portlet-body">
                        <div class="col-md-12 side-padding-none">

                            <br>
                            {!! Form::model($payrollemployee,['route' => ['change_salary_department.post',$payrollemployee->id], 'method'=>'put']) !!}
                            <div class="col-md-offset-4 col-md-4" style="  padding-top: 20px;  padding-bottom: 20px;">
                                <label for="office_id">Change Office/Zone</label>
                                {{ Form::select("office_id",$departments,null,['class' => 'form-control select2','id'=>'office_id','required','placeholder'=>'Select Office/Zone']) }}

                            </div>
                            <div class="col-md-offset-4 col-md-4" style="  padding-top: 20px;  padding-bottom: 20px;">
                                <a href="{{ route('change_salary_department.get') }}" class="btn red">Close Without Update</a>
                                <button type="submit" class="btn blue" onclick="return confirm('Are you sure to do this?')">Update</button>

                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                @endif
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            highlight_nav('change_salary_department');
        });
    </script>

@endsection