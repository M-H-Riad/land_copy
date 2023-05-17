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
                        {!! Form::select('zone_id', $zones, null, ['class' => 'form-control select2', 'placeholder' => 'জোন', 'style' => 'width:100%']) !!}
                        </div>
                        
                        <div class="col-md-6" style="margin-bottom:5px;">
                            <a href="{{ URL::to('/deep-tubewell/deep-tubewell-report-zone') }}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Generate Report</button>
                            <a target="_blank" href="{{route('deep-tubewell-zone-report.pdf', \Request::all())}}" class="btn btn-warning btn-sm">
                                <i class="fa fa-file-pdf-o"></i> Download PDF
                            </a>
                            <a target="_blank" href="" class=" btn btn-info btn-sm">
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
                        <span class="caption-subject bold uppercase">তথ্য</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover nopagination dt-responsive" >
                        <thead>
                        <tr>
                            <th style="padding: 4px !important;">ক্রমিক নং</th>
                            <th style="padding: 4px !important;">স্থাপনা/গভীর নলকূপের জায়গার নাম</th>
                            <!-- <th style="padding: 4px !important;">জোন</th> -->
                            <th style="padding: 4px !important;">মৌজা</th>
                            <th style="padding: 4px !important;">উৎসের ধরণ</th>
                            <th style="padding: 4px !important;">উৎস</th>
                            <th style="padding: 4px !important;">অনুমতি/চুক্তি/বরাদ্দ</th>
                            <th style="padding: 4px !important;">অনুমতি/চুক্তি/বরাদ্দ তারিখ</th>
                            <th style="padding: 4px !important;">দখলপত্র তারিখ</th>
                            <th style="padding: 4px !important;">খতিয়ান নং</th>
                            <th style="padding: 4px !important;">দাগ নং</th>
                            <th style="padding: 4px !important;">জমির পরিমান (একর)</th>
                            <th style="padding: 4px !important;">মন্তব্য</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($deep_infos) > 0)
                            <?php $total_land = 0;$i=1;?>
                            @foreach($deep_infos as $deep_info)
                                
                                    <tr style="border: 1px solid black;">
                                        <td>{{ $i++ }}</td>
                                        <td>{{$deep_info->deep_tubewell_place_name}}</td>
                                        <!-- <td>{{$deep_info->zone->title}}</td> -->
                                        <td>{{$deep_info->area->title}}</td>
                                        <td>{{$deep_info->sourceType->title}}</td>
                                        <td>{{$deep_info->sources->title}}</td>
                                        <td>
                                            @if($deep_info->onumoti_chukti_boraddo==1)
                                                {{ অনুমতি }}
                                            @elseif($deep_info->onumoti_chukti_boraddo==2)
                                                {{ চুক্তি }}
                                            @elseif($deep_info->onumoti_chukti_boraddo==3)
                                                {{ বরাদ্দ }}
                                            @endif
                                        </td>
                                        <td>{{$deep_info->onumoti_chukti_boraddo_date}}</td>
                                        <td>{{$deep_info->dokholpotro_date}}</td>
                                        
                                        <td>{{$deep_info->khotiyan_no}}</td>
                                        <td>{{$deep_info->dag_no}}</td>
                                        <td>{{$deep_info->jomir_poriman}}</td>
                                        <td>{{$deep_info->destination}}</td>
                                    </tr>
                                <?php 
                                   $get_land = $deep_info->jomir_poriman;
                                   $total_land = $total_land+$get_land;
                                ?>
                            @endforeach
                            <tr>
                                
                                <td colspan="11" class="text-right"> <b>মোট : </b></td>
                                <td colspan="2" class="text-left"> <b>{{$total_land}} একর</b></td>
                                
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
