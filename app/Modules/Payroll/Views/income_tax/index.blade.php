@extends('main_layouts.app')

@section('content')

    <div class="row animated flipInX">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Income Tax Report</span>
                    </div>
                </div>
                <div class="portlet-body background-gray">
                    @include('errorOrSuccess')



                    <div class="col-md-12 side-padding-none">
                        {!! Form::open(array('route'=>'income-tax-report.download','method' => 'post', 'id' => 'filter-form')) !!}
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
    <div class="row animated zoomIn">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                {{--                <div class="portlet-title">--}}
                {{--                    <div class="caption font-green">--}}
                {{--                        <!-- <i class="icon-settings font-green"></i> -->--}}
                {{--                        <span class="caption-subject bold uppercase">Income Tax Report</span>--}}
                {{--                        --}}
                {{--                    </div>--}}
                {{--                    --}}

                {{--                </div>--}}
                <div class="portlet-body">


                    <table class="table table-striped table-bordered table-hover" id="nopagination">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Month</th>
                            <th>Cheque No</th>
                            <th>Cheque Date</th>
                            <th>Bank</th>
                            <th>Bank Branch</th>
                            <th>Bank Account No</th>
                            <th>Total</th>
                            {{--                            <th>IT Deduction Information</th>--}}
                            <th>Action</th>
                        </tr>

                        </thead>
                        <tbody>
                        @php $i = $incomeTaxReports->toArray()['from'] @endphp
                        @foreach($incomeTaxReports as $indexKey => $row)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$row->title}}</td>
                                <td>{{$row->cheque_no}}</td>
                                <td>{{$row->cheque_date}}</td>
                                <td>{{$row->relBank->bank_name}}</td>
                                <td>{{$row->relBranch->branch_name}}</td>
                                <td>{{$row->bank_account_no}}</td>
                                <td>{{$row->total_amount}}</td>
                                <td>
                                    @if( Auth::user()->can('download_income_tax_summery_monthly'))
                                        <a class="btn btn-success btn-sm mt-ladda-btn ladda-button" href="{{route('income-tax-info.download',$row->payroll_month_id)}}" target="_blank">
                                            <i class="fa falist fa-file-pdf-o"></i>  Download
                                        </a>
                                    @endif
                                    @if( Auth::user()->can('income_tax_report_info_update'))
                                        <button  data-toggle="modal" data-target="#edit-income-tax-modal-{{$row->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                        @include('Payroll::income_tax.edit')
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    @if(count($incomeTaxReports)>0)
                        {{$incomeTaxReports->appends($_REQUEST)->render()}}
                    @endif
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            // $('#nopagination').DataTable({
            //     "paging": false,
            //     "iDisplayLength": 25
            // });

            highlight_nav('income-tax-report');
        });
    </script>

@endsection