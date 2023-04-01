@extends('main_layouts.app')
<style>
    .portlet-body {
        overflow-x: auto !important;
    }

    .table > tbody > tr > td {
        vertical-align: top !important;
    }
    tr{
        border-bottom: 1px solid black !important;
    }

    tr:last-child {
        border-bottom: none !important;
    }

    .nopagination  > tbody > tr > td {
        border: 1px solid black !important;
    }

    td {
        white-space: nowrap;
        width: 100;
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
                    {!! Form::select('zone_id', $zoneArr, 1, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                    </div>
                    <div class="col-md-3" style="margin-bottom:5px;">
                    {!! Form::select('status', ['0' => 'খাজনা দেওয়া হয়নি','1' => 'খাজনা দেওয়া হয়েছে'],null, ['class' => 'form-control','placeholder' => 'খাজনা স্টেটাস', 'id' => 'khajna_status','style' => 'width:100%']) !!}
                    </div>

                <!-- </div>
                <div class="col-md-12 side-padding-none"> -->

                    <div class="col-md-6" style="margin-bottom:5px;">
                        <a href="{{url('land/zone/khajna-pay/report')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                        <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Generate Report</button>
                        <a target="_blank" href="{{route('zone-khajna.report.pdf', \Request::all())}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-file-pdf-o"></i> Download PDF
                        </a>
                        <a target="_blank" href="{{route('zone-khajna.report.export', \Request::all())}}" class=" btn btn-info btn-sm">
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
                        <span class="caption-subject bold uppercase">জোন হিসেবে খাজনার তথ্য</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover nopagination dt-responsive" >
                        <thead>
                        <tr>
                            <th style="padding: 4px !important;">ক্রমিক নং</th>
                            <th style="padding: 4px !important;">জোন</th>
                            <th style="padding: 4px !important;">স্থাপনার নাম</th>
                            <th style="padding: 4px !important;">মৌজা</th>
                            <th style="padding: 4px !important;">দাগ নং</th>
                            <th style="padding: 4px !important;">খতিয়ান নং</th>
                            <th style="padding: 4px !important;">জমির পরিমান (একর)</th>
                            <th style="padding: 4px !important;">খাজনাকৃত জমির পরিমান (একর)</th>
                            <th style="padding: 4px !important;">মোট খাজনার পরিমাণ</th>
                            <th style="padding: 4px !important;">মোট বকেয়া</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($zones) > 0)
                            <?php $i = 1; $grandTotalPaid = 0; $grandTotalBokeya = 0; $grandTotalQuantity = 0; $grandTotalLand = 0; ?>
                            @foreach($zones as $zone)
                                <?php
                                    $subTotalPaid= 0; $subTotalQuantity = 0;
                                    $subTotalBokeya= 0; $subTotalLand = 0;
                                    $lands = App\Modules\Land\Models\Land::where('zone_id', $zone->id)->get();
                                ?>
                                @if(count($lands) > 0)
                                    <tr style="border: 1px solid black;">
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $zone->title or ''}}</td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                    <tr>
                                                        <td>{{$land->title or '-'}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                    <tr>
                                                        @if (isset($land->area))
                                                            <td>
                                                                {{$land->area->title or '-'}}
                                                            </td>
                                                        @else
                                                        <td>-</td> 
                                                        @endif
                                                        
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                    <tr>
                                                        <td> {{$land->dag_no or '-'}} </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                    <tr>
                                                        @if (strlen($land->khotian) > 2)
                                                        <td>{{ en2bn($land->khotian) }}</td>
                                                        @else
                                                        <td style="font-size: 14px;">{{ en2bn($land->khotian) }}</td>
                                                        @endif
                                                        
                                                    </tr>
                                                @endforeach
                                                {{-- <tr>
                                                    <td colspan="4" style="text-align: right;"><b>উপ -মোট</b></td>
                                                </tr> --}}
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                    <tr>
                                                        <td>{{ en2bn($land->quantity) }}</td>
                                                        <?php $subTotalQuantity += bn2en($land->quantity); ?>
                                                    </tr>
                                                @endforeach
                                                <?php $grandTotalQuantity += $subTotalQuantity; ?>
                                                {{-- <tr>
                                                    <td><b>{{$subTotalQuantity}}</b></td>
                                                </tr> --}}
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                    <tr>
                                                        @if (strlen($land->khajna_land) > 2)
                                                            <td>{{ en2bn($land->khajna_land) }}</td>
                                                        @else
                                                            <td style="font-size: 14px;">{{ en2bn($land->khajna_land) }}</td>
                                                        @endif
                                                        
                                                        <?php $subTotalLand += bn2en($land->khajna_land); ?>
                                                    </tr>
                                                @endforeach
                                                <?php $grandTotalLand += $subTotalLand; ?>
                                                {{-- <tr>
                                                    <td><b>{{$subTotalLand}}</b></td>
                                                </tr> --}}
                                            </table>
                                        </td>
                                        
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                    <?php
                                                        // $totalKhajnaPaid = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->sum('bokeya');
                                                        $paidArray = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->get();
                                                        $totalKhajnaPaid =0;
                                                        foreach ($paidArray as $key => $paid) {
                                                            $totalKhajnaPaid += bn2en($paid->bokeya);
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td style="width: 100;">{{ en2bn($totalKhajnaPaid) }}</td>
                                                        <?php $subTotalPaid += $totalKhajnaPaid; ?>
                                                    </tr>
                                                @endforeach
                                                <?php $grandTotalPaid += $subTotalPaid; ?>
                                                {{-- <tr>
                                                    <td><b>{{$subTotalPaid}}</b></td>
                                                </tr> --}}
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($lands as $land)
                                                    <?php
                                                        // //Bokeya calculation.........
                                                        // $totalBokeya = App\Modules\Land\Models\KhajnaOfficeInfo::where('land_id', $land->id)->sum('total_bokeya');
                                                        // $totalPaid = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->sum('bokeya');
                                                        // $bokeya = ($totalBokeya - $totalPaid);

                                                        //Bokeya calculation.........
                                                        $bokeyaArray = App\Modules\Land\Models\KhajnaOfficeInfo::where('land_id', $land->id)->get();
                                                        $paidArray = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->get();
                                                        $totalBokeya =0;
                                                        $totalPaid =0;
                                                        foreach ($bokeyaArray as $key => $bokeya) {
                                                            $totalBokeya += bn2en($bokeya->total_bokeya);
                                                        }
                                                        foreach ($paidArray as $key => $paid) {
                                                            $totalPaid += bn2en($paid->bokeya);
                                                        }
                                                        $bokeya = ($totalBokeya - $totalPaid);
                                                    ?>

                                                    <tr>
                                                        <td style="width: 100;">{{ en2bn($bokeya) }}</td>
                                                        <?php $subTotalBokeya += $bokeya; ?>
                                                    </tr>
                                                @endforeach
                                                <?php $grandTotalBokeya += $subTotalBokeya; ?>
                                                {{-- <tr>
                                                    <td><b>{{$subTotalBokeya}}</b></td>
                                                </tr> --}}
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
                                <td colspan="2" class="text-right"> <b>মোট : </b></td>
                                <td><b>{{ en2bn($grandTotalQuantity) }}</b></td>
                                <td><b>{{ en2bn($grandTotalLand) }}</b></td>
                                <td><b>{{ en2bn($grandTotalPaid) }}</b></td>
                                <td><b>{{ en2bn($grandTotalBokeya) }}</b></td>
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
