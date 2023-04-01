@extends('main_layouts.app')
<style>
    th {
        border: 1px solid black !important;
    }
    td {
        border: 1px solid black !important;
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
                        {!! Form::select('land_id', $landArr, null, ['class' => 'form-control select2', 'placeholder' => 'স্থাপনার নাম']) !!}
                    </div>

                <!-- </div>
                <div class="col-md-12 side-padding-none"> -->

                    <div class="col-md-8" style="margin-bottom:5px;">
                        <a href="{{url('land/khajna-bokeya/report')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                        <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Generate Report</button>
                        <a target="_blank" href="{{route('khajna-bokeya.report.pdf', \Request::all())}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-file-pdf-o"></i> Download PDF
                        </a>
                        <a target="_blank" href="{{route('khajna-bokeya.report.export', \Request::all())}}" class=" btn btn-info btn-sm">
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
                        <span class="caption-subject bold uppercase">স্থাপনা হিসেবে খাজনা বকেয়ার তথ্য</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover nopagination dt-responsive" >
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">স্থাপনার নাম</th>
                            <th style="padding: 8px !important;">জোন</th>
                            <th style="padding: 8px !important;">মৌজা</th>
                            <th style="padding: 8px !important;">দাগ নং</th>
                            <th style="padding: 8px !important;">খতিয়ান নং</th>
                            <th style="padding: 8px !important;">জমির পরিমান (একর)</th>
                            <th style="padding: 8px !important;">খাজনাকৃত জমির পরিমান (একর)</th>
                            <th style="padding: 8px !important;">পরিশোধিত খাজনার পরিমাণ</th>
                            <th style="padding: 8px !important;">মোট বকেয়া</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($lands) > 0)
                            <?php $i = 1; $totalLand = 0; $totalKhajnaLand = 0; $totalKhajnaPaid = 0; $grandTotalBokeya = 0; ?>
                            @foreach($lands as $land)
                                <?php
                                    // $khajnaPaid = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->sum('bokeya');
                                    
                                    // //Bokeya calculation.........
                                    // $totalBokeya = App\Modules\Land\Models\KhajnaOfficeInfo::where('land_id', $land->id)->sum('total_bokeya');
                                    // $bokeya = ($totalBokeya - $khajnaPaid);

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
                                @if(count($totalPaid) > 0)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$land->title or ''}}</td>
                                        <td>
                                            @if (isset($land->zone))
                                                {{$land->zone->title or ''}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($land->area))
                                                {{$land->area->title or ''}}
                                            @endif
                                        </td>
                                        <td>{{$land->dag_no or ''}}</td>
                                        <td>{{$land->khotian or ''}}</td>
                                        <td>
                                            {{$land->quantity or ''}}
                                            <?php $totalLand += bn2en($land->quantity); ?>
                                        </td>
                                        <td>
                                            {{$land->khajna_land or ''}}
                                            <?php $totalKhajnaLand += bn2en($land->khajna_land); ?>
                                        </td>
                                        
                                        
                                        <td>
                                            {{ en2bn($totalPaid) }}
                                            <?php $totalKhajnaPaid += $totalPaid; ?>
                                        </td>
                                        <td>                                      
                                            {{ en2bn($bokeya) }}
                                            <?php $grandTotalBokeya += $bokeya; ?>
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
                                <td><b>{{ en2bn($totalLand) }}</b></td>
                                <td><b>{{ en2bn($totalKhajnaLand) }}</b></td>
                                <td><b>{{ en2bn($totalKhajnaPaid) }}</b></td>
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
