@extends('main_layouts.app')
<style>
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
                        {!! Form::select('land_id', $landArr, null, ['class' => 'form-control select2']) !!}
                    </div>

                <!-- </div>
                <div class="col-md-12 side-padding-none"> -->

                    <div class="col-md-8" style="margin-bottom:5px;">
                        <a href="{{url('land/khajna/payment/report')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                        <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Generate Report</button>
                        <a target="_blank" href="{{route('khajna-payment.report.pdf', \Request::all())}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-file-pdf-o"></i> Download PDF
                        </a>
                        <a target="_blank" href="{{route('khajna-pay.report.export', \Request::all())}}" class=" btn btn-info btn-sm">
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
                        <span class="caption-subject bold uppercase">স্থাপনা হিসেবে খাজনা পরিশোধের তথ্য</span>
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
                            <th style="padding: 8px !important;">খাজনা পরিশোধের তারিখ</th>
                            <th style="padding: 8px !important;">দাবির সন</th>
                            <th style="padding: 8px !important;">খাজনার পরিমাণ</th>
                            <th style="padding: 8px !important;">বকেয়া</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($lands) > 0)
                            <?php $i = 1; $grandTotal = 0; $BokeyaGrandTotal = 0; ?>
                            @foreach($lands as $land)
                                <?php
                                    $khajnaQuery = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id);
                                    $khajnaInfos = $khajnaQuery->get();

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
                                @if(count($khajnaInfos) > 0)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$land->title or ''}}</td>
                                        <td>{{$land->zone->title or ''}}</td>
                                        <td>{{$land->area->title or ''}}</td>
                                        <td>{{$land->dag_no or ''}}</td>
                                        <td>{{$land->khotian or ''}}</td>
                                        <td>{{$land->quantity or ''}}</td>
                                        
                                        <td>
                                            @if(count($khajnaInfos) > 0)
                                                @foreach($khajnaInfos as $khajna)                                        
                                                {{ $khajna->khajna_date or ''}}
                                                <hr>                                    
                                                @endforeach
                                                <b>-</b>
                                            @endif
                                        </td>
                                        <td style="width: 200px;">
                                            @if(count($khajnaInfos) > 0)
                                                @foreach($khajnaInfos as $khajna)
                                                {{$khajna->from_year or ''}} <?php if($khajna->to_year != 'null'){ echo "to ".$khajna->to_year; } ?>
                                                <hr>                                    
                                                @endforeach
                                                <span><b>পরিশোধিত খাজনার পরিমাণ</b></span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(count($khajnaInfos) > 0)
                                            <?php $subTotal= 0; ?>
                                                @foreach($khajnaInfos as $khajna)                                        
                                                {{ $khajna->bokeya or ''}}
                                                <?php $subTotal += bn2en($khajna->bokeya); ?>
                                                <hr>                                    
                                                @endforeach
                                                <b>{{en2bn($subTotal)}}</b>
                                                <?php $grandTotal += $subTotal; ?>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($khajnaInfos as $khajna)
                                              - <hr>                                    
                                            @endforeach
                                            @if ($bokeya > 0)
                                                <b>{{ en2bn($bokeya) }}</b>
                                                <?php $BokeyaGrandTotal += bn2en($bokeya); ?>
                                            @else
                                                <b>০</b>
                                            @endif
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
                                <td colspan="4" class="text-right"> <b>মোট : </b></td>
                                <td><b>{{ en2bn($grandTotal) }}</b></td>
                                <td><b>{{ en2bn($BokeyaGrandTotal) }}</b></td>
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
