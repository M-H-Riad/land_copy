@extends('main_layouts.app')
<style>

    /* .portlet-body {
        overflow-x: auto !important;
    } */
    .nopagination  > tbody > tr > td{
        border-bottom: 1px solid rgb(194, 194, 194) !important;
        border-right: 1px solid rgb(194, 194, 194) !important;
        border-top: 1px solid rgb(194, 194, 194) !important;
        border-left: 1px solid rgb(194, 194, 194) !important;
    }
    /* .sub-table > tr{
        border-bottom: 1px solid black !important;
        border-right: 1px solid black !important;
        border-top: 1px solid black !important;
        border-left: 1px solid black !important;
    } */

    tr:last-child {
        border-bottom: none !important;
    }
    td {
        white-space: nowrap;
        width: 100 !important;
    }
    .table > tbody > tr > td {
        vertical-align: top !important;
    }

    /* tr:nth-child(even) {
        background-color: rgb(199, 199, 199)
    } */


    .portlet-body {
        overflow-x: auto !important;
    }
    tr{
        border-bottom: 1px solid black !important;
        /* border-left: 1px solid black !important; */
    }

    .table > tbody > tr > td {
        vertical-align: top !important;
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
                        {!! Form::select('vumi_office_id', $vumiOfficeArr, null, ['class' => 'form-control select2', 'placeholder' => 'ভূমি অফিসের নাম']) !!}
                    </div>

                <!-- </div>
                <div class="col-md-12 side-padding-none"> -->

                    <div class="col-md-8" style="margin-bottom:5px;">
                        <a href="{{url('land/khajna-pay/vumioffice/report')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                        <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Generate Report</button>
                        <a target="_blank" href="{{route('khajna-pay.vumiOffice.report.pdf', \Request::all())}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-file-pdf-o"></i> Download PDF
                        </a>
                        <a target="_blank" href="{{route('khajna-pay.vumiOffice.report.export', \Request::all())}}" class=" btn btn-info btn-sm">
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
                        <span class="caption-subject bold uppercase">ভূমি অফিস হিসেবে খাজনা পরিশোধের তথ্য</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover nopagination dt-responsive" >
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">ভূমি অফিসের নাম</th>
                            <th style="padding: 8px !important;">স্থাপনার নাম</th>
                            <th style="padding: 8px !important;">জোন</th>
                            <th style="padding: 8px !important;">মৌজা</th>
                            <th style="padding: 8px !important;">দাগ নং</th>
                            <th style="padding: 8px !important;">খতিয়ান নং</th>
                            <th style="padding: 8px !important;">জমির পরিমান (একর)</th>
                            <th style="padding: 8px !important;">খাজনা পরিশোধের তারিখ</th>
                            <th style="padding: 8px !important;">দাবির সন</th>
                            <th style="padding: 8px !important;">মোট খাজনার পরিমাণ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($vumiOffices) > 0)
                            <?php $i = 1; $grandTotal = 0; ?>
                            @foreach($vumiOffices as $vumiOffice)
                                 <?php
                                    $vumiOfficeLandIds = App\Modules\Land\Models\KhajnaOfficeInfo::where('khajna_office_id', $vumiOffice->id)->pluck('land_id');
                                    $landQuery = App\Modules\Land\Models\Land::whereIn('id', $vumiOfficeLandIds);                                    
                                    $lands = $landQuery->get();
                                    $landIds = $landQuery->pluck('id');
                                ?>
                                
                                @if(count($lands) > 0)
                                        <?php
                                            $khajnaQuery = App\Modules\Land\Models\KhajnaInfo::whereIn('land_id', $landIds);
                                            
                                            $khajnaInfos = $khajnaQuery->get();
                                        ?>
                                        
                                        @if(count($khajnaInfos) > 0)
                                            <tr style="border: 1px solid black;">
                                                <td>{{ $i++ }}</td>
                                                <td>{{$vumiOffice->office_name or ''}}</td>
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                        <table class="sub-table">
                                                            @foreach($khajnaInfos as $khajna)
                                                                @foreach($lands as $land)
                                                                    @if ($khajna->land_id == $land->id)
                                                                        <tr style="border-bottom: 1px solid black;">
                                                                            <td><span>{{$land->title or ''}}</span></td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </table>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                        <table class="sub-table">
                                                            @foreach($khajnaInfos as $khajna)
                                                                @foreach($lands as $land)
                                                                    @if ($khajna->land_id == $land->id)
                                                                        <tr>
                                                                            <td>
                                                                                @if ($land->zone)
                                                                                    {{$land->zone->title or ''}}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </table>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                        <table class="sub-table">
                                                            @foreach($khajnaInfos as $khajna)
                                                                @foreach($lands as $land)
                                                                    @if ($khajna->land_id == $land->id)
                                                                        <tr>
                                                                            <td>
                                                                                @if (isset($land->area))
                                                                                    {{$land->area->title or ''}}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </table>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                        <table class="sub-table">
                                                            @foreach($khajnaInfos as $khajna)
                                                                @foreach($lands as $land)
                                                                    @if ($khajna->land_id == $land->id)
                                                                        <tr>
                                                                            <td>{{$land->dag_no or ''}}</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </table>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                        <table class="sub-table">
                                                            @foreach($khajnaInfos as $khajna)
                                                                @foreach($lands as $land)
                                                                    @if ($khajna->land_id == $land->id)
                                                                        <tr>
                                                                            <td>{{$land->khotian or ''}}</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </table>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                        <table class="sub-table">
                                                            @foreach($khajnaInfos as $khajna)
                                                                @foreach($lands as $land)
                                                                    @if ($khajna->land_id == $land->id)
                                                                        <tr>
                                                                            <td>{{$land->quantity or ''}}</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </table>
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                    <table class="sub-table">
                                                        @foreach($khajnaInfos as $khajna)
                                                            @foreach($lands as $land)
                                                                @if ($khajna->land_id == $land->id)
                                                                    <tr>
                                                                        <td>{{ en2bn($khajna->khajna_date) }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </table>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                    <table class="sub-table">
                                                        @foreach($khajnaInfos as $khajna)
                                                            @foreach($lands as $land)
                                                                @if ($khajna->land_id == $land->id)
                                                                    <tr>
                                                                        <td>{{ en2bn($khajna->from_year) }} <?php if($khajna->to_year != 'null'){ echo "to ".en2bn($khajna->to_year); } ?></td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="8"><b>পরিশোধিত মোট খাজনা</b></td>
                                                        </tr>
                                                    </table>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($khajnaInfos) > 0)
                                                    <?php $subTotal = 0; ?>
                                                    <table class="sub-table">
                                                        @foreach($khajnaInfos as $khajna)
                                                            @foreach($lands as $land)
                                                                @if ($khajna->land_id == $land->id)
                                                                    <tr>
                                                                        <td>{{ en2bn($khajna->bokeya) }}</td>
                                                                        <?php $subTotal += bn2en($khajna->bokeya); ?>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        <tr>
                                                            <td><b>{{en2bn($subTotal)}}</b></td>
                                                            <?php $grandTotal += bn2en($subTotal); ?>
                                                        </tr>
                                                    </table>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                @endif
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="4" class="text-center"> <b>মোট খাজনার পরিমাণ: </b></td>
                                <td><b>{{ en2bn($grandTotal) }}</b></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>
@endif
@endsection

@section('scripts')

@endsection
