@extends('main_layouts.app')

@section('content')

    @include('errorOrSuccess')
    <div class="row animated zoomIn">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title row">
                    <div class="caption font-green col-md-10">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Ifter Bill</span>
                    </div>

                    <div class=" actions col-md-2 side-padding-none">

{{--                        {!! Form::open(['route'=>'ifter_bill.demo','method' => 'post'] ) !!}--}}
{{--                        <div class="col-md-1" style="margin-bottom:5px;">--}}
{{--                            {!! Form::select('class_from',$class,request('class_from'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select Class From','style' => 'width:100%','required']) !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-1" style="margin-bottom:5px;">--}}
{{--                            {!! Form::select('class_to',$class,request('class_to'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select Class To','style' => 'width:100%','required']) !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-2" style="margin-bottom:5px;">--}}
{{--                            {!! Form::select('department_id',$departments,request('department_id'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select Department','style' => 'width:100%','required']) !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-1" style="margin-bottom:5px;">--}}
{{--                            {!! Form::number('days',request('days'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Total Days','style' => 'width:100%','required' ,'max' => 30 ]) !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-1" style="margin-bottom:5px;">--}}
{{--                            {!! Form::number('per_day',request('per_day'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Per Day','style' => 'width:100%','required']) !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-2">--}}
{{--                            <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-file-excel-o"></i> Download</button>--}}
{{--                        </div>--}}
{{--                        {!! Form::close() !!}--}}
                        @if(Auth::user()->can('create_ifter_bill'))
{{--                            <div class="col-md-2">--}}
{{--                                <button class="btn btn-square red todo-bold" id="add-night-allowance" data-toggle="modal" data-target="#add-night-allowance-month" style="padding: 5px;width: 100%;">--}}
{{--                                    <i class="fa fa-plus"></i>--}}
{{--                                    Add Ifter Bill--}}
{{--                                </button>--}}
{{--                            </div>--}}
                            <div class="col-md-12">
                                <a href="{{ route('ifter_bill.create') }}" class="btn red"  style="padding: 5px;width: 100%;">
                                    <i class="fa fa-plus"></i>
                                    Create Ifter Bill
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="portlet-body">


                <table class="table table-striped table-bordered table-hover" id="nopagination">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Ifter Bill Month</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    @php $i = $ifterBills->toArray()['from'] @endphp
                    @foreach($ifterBills as $row)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $row->title}}</td>
                            <td>
                                <a class="btn btn-primary btn-sm " data-style="zoom-in" href="{{ route('ifter_bill.show',$row->id) }}">

                                    <i class="fa fa-folder-open"></i> Details

                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                @if(count($ifterBills)>0)
                    {{$ifterBills->appends($_REQUEST)->render()}}
                @endif
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

    </div>

    <div id="add-night-allowance-month" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'ifter_bill.store', 'method' => 'post','files'=>True]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Ifter Bill</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                        <tbody>
                        <tr>
                            <th style="width: 50%;">Month <span style="color:red">*</span></th>
                            <td>

                                {{ Form::selectMonth('month',null, ['class' => 'form-control','placeholder'=>'Select Month','style'=>'width:100%','required' ]) }}

                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Year <span style="color:red">*</span></th>
                            <td>

                                {{ Form::selectYear('year',date('Y'),2019,null, ['class' => 'form-control','placeholder'=>'Select Year','style'=>'width:100%','required']) }}

                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Department <span style="color:red">*</span></th>
                            <td>

                                {{ Form::select('department_id', $departments ,null, ['class' => 'form-control','placeholder'=>'Select Department','style'=>'width:100%','required']) }}

                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">File (csv,xls,xlsx) <span style="color:red">*</span></th>
                            <td>
                                <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv" required>

                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Bank Account Number <span style="color:red">*</span></th>
                            <td>
                                {{ Form::text('bank_account_number','CD-200040491', ['class' => 'form-control', 'id' => 'bank_account_number','placeholder'=>'Bank Account Number','required']) }}

                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Memo No <span style="color:red">*</span></th>
                            <td>
                                {{ Form::text('memo_no','46.113.317.00.00.'.date('Y').'/', ['class' => 'form-control', 'id' => 'memo_no','placeholder'=>'Memo No','required']) }}

                            </td>
                        </tr>
                        </tbody>

                    </table>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                {!! Form::close()  !!}
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

//             $('#nopagination').DataTable({
//                 "paging": false,
// //			"bFilter": false,
// // 			"info": false,
// // 			'sort' : false,
//                 "iDisplayLength": 25
//             });

            highlight_nav('ifter-bill');
        });
    </script>

@endsection