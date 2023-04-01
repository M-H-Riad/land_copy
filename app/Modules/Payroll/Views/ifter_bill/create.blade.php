@extends('main_layouts.app')

@section('content')


    @include('errorOrSuccess')
    <div class="row animated zoomIn">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green col-md-3">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Ifter Bill Create</span>
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="col-md-12">
                        {!! Form::open(['method' => 'get'] ) !!}
                        <table class="table  dt-responsive" class="nopagination" width="100%">
                            <thead>
                            <tr>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Class From</th>
                                <th>Class To</th>
                                <th>Department</th>
                                <th></th>

                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    {{ Form::selectMonth('month',null, ['class' => 'form-control','placeholder'=>'Select Month','style'=>'width:100%','required' ]) }}
                                </td>
                                <td>
                                    {{ Form::selectYear('year',date('Y'),2019,null, ['class' => 'form-control','placeholder'=>'Select Year','style'=>'width:100%','required']) }}
                                </td>
                                <td>
                                    {!! Form::select('class_from',$class,request('class_from'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select Class From','style' => 'width:100%','required']) !!}
                                </td>
                                <td>
                                    {!! Form::select('class_to',$class,request('class_to'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select Class To','style' => 'width:100%','required']) !!}
                                </td>
                                <td>
                                    {!! Form::select('department_id',$departments,request('department_id'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select Department','style' => 'width:100%','required']) !!}
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-search"></i> Search</button>
                                </td>

                            </tr>
                            </tbody>

                        </table>
                        {!! Form::close() !!}


                        @if(Auth::user()->can('create_ifter_bill') && isset($employees) && !empty($employees))

                            <br>
                            {!! Form::open(array('route' =>'ifter_bill.store','method' => 'post', 'class' => 'from-control')) !!}
                            <table class="table  dt-responsive" class="nopagination" width="100%">
                                <thead>
                                <tr>
                                    <th width="50%">Bank Account Number</th>
                                    <th width="50%">Memo No</th>

                                </tr>

                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        {{ Form::text('bank_account_number','CD-200040491', ['class' => 'form-control', 'id' => 'bank_account_number','placeholder'=>'Bank Account Number','required']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('memo_no','46.113.317.00.00.'.date('Y').'/', ['class' => 'form-control', 'id' => 'memo_no','placeholder'=>'Memo No','required']) }}</td>
                                    <td>
                                        <input type="hidden" name="department_id" class="form-control" value="{{$department_id}}"  >
                                        <input type="hidden" name="hour_type" class="form-control" value="{{$hour_type}}"  >
                                        <input type="hidden" name="month" class="form-control" value="{{$month}}"  >
                                        <input type="hidden" name="year" class="form-control" value="{{$year}}"  >
                                    </td>

                                </tr>
                                </tbody>

                            </table>


                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                <tr>
                                    <th width="5%">SL</th>
                                    <th width="11%">Account</th>
                                    <th width="11%">T24Account</th>
                                    <th width="5%">PFNO</th>
                                    <th width="20%">Name</th>
                                    <th width="20%">Designation</th>
                                    <th width="8%">Basic Pay</th>
                                    <th width="10%">Days</th>
                                    <th width="10%">Per Day</th>
                                </tr>

                                </thead>
                                <tbody>
                                @php   $i = 1 ; $totalDays = 0 @endphp
                                @foreach($employees as  $row)
                                    @php
                                        if(isset($ifterBillEmployee) &&  !empty($ifterBillEmployee)) {
                                            $emp = $ifterBillEmployee->where('pfno',$row->pfno)->first();
                                             if($emp){
                                                    $totalDays  +=   $emp->nights;
                                                }
                                        }else {
                                            $emp = null;
                                        }

                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $row->bank_account_no}}</td>
                                        <td>{{ $row->bank_account_no_t24}}</td>
                                        <td>{{ $row->pfno}}</td>
                                        <td>{{ $row->name}}</td>
                                        <td>{{ $row->designation}}</td>
                                        <td>
                                            @if(array_key_exists($row->employee_id,$payrollEmployee))
                                                {{ $payrollEmployee[$row->employee_id] }}
                                            @else
                                                {{ $row->current_basic_pay}}
                                            @endif
                                        </td>
                                        <td><input  class="days" type="number" name="days[{{$row->pfno}}]" value="{{$emp !=null ? ($emp->days != null ? $emp->days : 0 ) : 0}}" max="30"  min="0" style="width: 100%" > </td>
                                        <td><input type="number" name="per_day[{{$row->pfno}}]" value="{{$emp !=null ? ($emp->per_day != null ? $emp->per_day : 0 ) : 0}}"  min="0" ></td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" class="text-right">Total Days &nbsp;&nbsp;&nbsp;</td>
                                    <td> <span id="totalDays">{{ $totalDays }}</span></td>
                                    <td></td>
                                </tr>
                                </tbody>

                            </table>
                            <div class="col-md-offset-4 col-md-4" style="  padding-top: 20px;  padding-bottom: 20px;">
                                <a href="javascript:history.back(-1)" class="btn red">Close Without Save</a>
                                <button type="submit" class="btn blue" onclick="return confirm('Ifter Bill will generate now, Are you sure to do this?')">Submit & Generate</button>

                            </div>

                            {!! Form::close() !!}
                        @endif
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

            highlight_nav('ifter-bill');
        });
        $(".days").change(function() {
            $( "#totalDays" ).text(0);
            var days = 0;
            $('.days').each(function (index) {
                days = parseInt(days) + parseInt($(this).val());
            });
            $( "#totalDays" ).text(days);
        });
    </script>

@endsection