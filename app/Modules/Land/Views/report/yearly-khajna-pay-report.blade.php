@extends('main_layouts.app')
<style>
    .portlet-body {
        overflow-x: auto !important;
    }
    tr{
        border-bottom: 1px solid gray !important;
    }

    .table > tbody > tr > td {
        vertical-align: top !important;
    }

    td {
        white-space: nowrap;
        vertical-align: text-top !important;
        width: 100;
    }

    .nopagination  > tbody > tr > td{
        border-bottom: 1px solid gray !important;
        border-right: 1px solid gray !important;
        border-top: 1px solid gray !important;
        border-left: 1px solid gray !important;
    }

    tr:last-child {
        border-bottom: none !important;
    }
</style>
@section('content')
    <div class="row animated zoomIn">
        @include('errorOrSuccess')

        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <span class="caption-subject bold uppercase">Filter</span>
                    </div>
                </div>
            <div class="portlet-body" style="padding: 10px">
                {{Form::model($_REQUEST,['method'=>'get','form-horizontal','role'=>'form'])}}
                <div class="col-md-12 side-padding-none">
                    <div class="col-md-3" style="margin-bottom:5px;">
                        <select class="form-control col-md-2" name="year">
                            <option value="">সন নির্বাচন করুন</option>
                            @for($i=2030; $i >= 1950; $i--)
                            <option value="{{ $i }}"> {{ $i }} </option>
                            @endfor
                        </select>
                    </div>

                <!-- </div>
                <div class="col-md-12 side-padding-none"> -->

                    <div class="col-md-8" style="margin-bottom:5px;">
                        <a href="{{url('land/yearly/khajna-pay/report')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                        <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Generate Report</button>
                        <a target="_blank" href="{{route('yearly-khajna-pay.report.pdf', \Request::all())}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-file-pdf-o"></i> Download PDF
                        </a>
                        <a target="_blank" href="{{route('yearly-khajna-pay.report.export', \Request::all())}}" class=" btn btn-info btn-sm">
                            <i class="fa fa-file-excel-o"></i> Download Excel
                        </a>
                    </div>
                </div>
                {{Form::close()}}
                </div>
            </div>
        </div>

    @if($searchedData > 0)
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <span class="caption-subject bold uppercase">বাৎসরিক খাজনা পরিশোধের তথ্য </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover nopagination dt-responsive" >
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">খাজনা পরিশোধের সন</th>
                            <th style="padding: 8px !important;">স্থাপনার নাম</th>
                            <th style="padding: 8px !important;">জোন</th>
                            <th style="padding: 8px !important;">মৌজা</th>
                            <th style="padding: 8px !important;">দাগ নং</th>
                            <th style="padding: 8px !important;">খতিয়ান নং</th>
                            <th style="padding: 8px !important;">জমির পরিমান (একর)</th>
                            <th style="padding: 8px !important;">মোট খাজনার পরিমাণ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($khajnaPayYears) > 0)
                            <?php $i = 1; $grandTotal = 0; ?>
                            @foreach($khajnaPayYears as $year)
                                <?php
                                    $subTotal= 0;
                                    $khajnaInfoLandId = App\Modules\Land\Models\KhajnaInfo::where('khajna_date_year', $year->year)->pluck('land_id');

                                    $landQuery = App\Modules\Land\Models\Land::whereIn('id', $khajnaInfoLandId);
                                    $lands = $landQuery->get();
                                ?>
                                @if(count($lands) > 0)
                                    <tr style="border: 1px solid black;">
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $year->year or ''}}</td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                <tr>
                                                    <td>{{$land->title or ''}}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                <tr>
                                                    <td>{{$land->zone->title or ''}}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                <tr>
                                                    <td>{{$land->area->title or ''}}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                <tr>
                                                    <td>{{$land->dag_no or ''}}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                <tr>
                                                    <td>{{$land->khotian or ''}}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                <tr>
                                                    <td>{{$land->quantity or ''}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td class="text-right"><b>পরিশোধিত মোট খাজনার পরিমাণ:</b></td>
                                                </tr>
                                            </table>
                                        </td>
                                        
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                <?php
                                                    // $totalYearlyKhajna = App\Modules\Land\Models\KhajnaInfo::where('khajna_date_year', $year->year)
                                                    //         ->where('land_id', $land->id)->sum('bokeya');
                                                    $totalYearlyKhajnaArray = App\Modules\Land\Models\KhajnaInfo::where('khajna_date_year', $year->year)
                                                            ->where('land_id', $land->id)->get();
                                                    $totalYearlyKhajna =0;
                                                    foreach ($totalYearlyKhajnaArray as $key => $khajna) {
                                                        $totalYearlyKhajna += bn2en($khajna->bokeya);
                                                    }
                                                ?>
                                                <tr>
                                                    <td>{{ en2bn($totalYearlyKhajna) }}</td> {{-- Eng and Ban mixed value converted to ban. --}}
                                                    <?php $subTotal += bn2en($totalYearlyKhajna); ?>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td><b>{{ en2bn($subTotal) }}</b></td>
                                                    <?php $grandTotal += $subTotal; ?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endif 
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="3" class="text-right"> <b>মোট : </b></td>
                                <td><b>{{ en2bn($grandTotal) }}</b></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    @endif
    </div>

@endsection

@section('scripts')

@endsection
