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
                        <span class="caption-subject bold uppercase">Night Allowance Create</span>
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


                        @if(Auth::user()->can('create_night_allowance') && isset($employees) && !empty($employees))

                            <br>
                            {!! Form::open(array('route' =>'night_allowance.store','method' => 'post', 'class' => 'from-control')) !!}
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
                                    <th width="10%">Account</th>
                                    <th width="10%">T24Account</th>
                                    <th width="5%">PFNO</th>
                                    <th width="19%">Name</th>
                                    <th width="19%">Designation</th>
                                    <th width="8%">Basic Pay</th>
                                    <th width="8%">Nights</th>
                                    <th width="8%">Arrears</th>
                                    <th width="8%"> Arrear Selection </th>
                                </tr>

                                </thead>
                                <tbody>
                                @php   $i = 1 ; $totalNights = 0 @endphp
                                @foreach($employees as  $row)
                                    @php
                                        if(isset($nightAllowanceEmployee) &&  !empty($nightAllowanceEmployee)) {
                                            $emp = $nightAllowanceEmployee->where('pfno',$row->pfno)->first();
                                            if($emp){
                                                    $totalNights  +=   $emp->nights;
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
                                        <td><input class="nights" type="number" name="nights[{{$row->pfno}}]" value="{{$emp !=null ? ($emp->nights != null ? $emp->nights : 0 ) : 0}}" max="{{$max > 0 ? $max : 30}}"  min="0" style="width: 100%" > </td>
                                        <td><input type="number" name="arrears[{{$row->pfno}}]" value="{{$emp !=null ? ($emp->allowance != null ? $emp->allowance : 0 ) : 0}}"  min="0" ></td>
                                        <td style="text-align: center"><input type="checkbox" name="checked_arrears[{{$row->pfno}}]" value="1" {{$emp !=null ? ($emp->allowance != null ? 'checked' : null ) : null}}></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" class="text-right">Total Nights &nbsp;&nbsp;&nbsp;</td>
                                    <td> <span id="totalNights">{{ $totalNights }}</span></td>
                                    <td colspan="2"></td>
                                </tr>
                                </tbody>

                            </table>
                            <div class="col-md-offset-4 col-md-4" style="  padding-top: 20px;  padding-bottom: 20px;">
                                <a href="javascript:history.back(-1)" class="btn red">Close Without Save</a>
                                <button type="submit" class="btn blue" onclick="return confirm('Night Allowance will generate now, Are you sure to do this?')">Submit & Generate</button>

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

            highlight_nav('night-allowance');
        });
        $(".nights").change(function() {
            $( "#totalNights" ).text(0);
            var nights = 0;
            $('.nights').each(function (index) {
                nights = parseInt(nights) + parseInt($(this).val());
            });
            $( "#totalNights" ).text(nights);
        });
    </script>

@endsection