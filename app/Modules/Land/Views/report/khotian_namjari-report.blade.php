@extends('main_layouts.app')
<style type="text/css">
    @font-face {
        font-family: bf;
        src: url("sol.ttf");format("truetype");
    }

    body {
        font-family: bf;
        font-size: 18px;
    }

    p {
        margin-bottom: 0;
        margin-top: 0;
        font-size: 18px;
    }

    table {
        width: 100%;
        margin: 0 auto;
    }

    table tr {
        margin-top: 5px;
    }

    th {
        padding: 18px !important;
        border: 2px solid #0a0a0a;
    }

    td {
        padding: 18px;
        border: 1px solid #0a0a0a;
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
                        <label for="">খতিয়ান নং</label>
                        {!! Form::select('namjari_khotian_no', $khotians, null, ['class' => 'form-control select2']) !!}
                    </div>
                    <div class="col-md-3" style="margin-bottom:5px;">
                        <label for="">মৌজার নাম</label>
                        {!! Form::select('area', $areas, null, ['class' => 'form-control select2']) !!}
                    </div>

                <!-- </div>
                <div class="col-md-12 side-padding-none"> -->

                    <div class="col-md-6" style="margin-bottom:5px;">
                        <a href="{{url('land/khotian/namjari-report')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                        <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Generate Report</button>
                        <a target="_blank" href="{{route('khotian-namjari.report.export', \Request::all())}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-file-pdf-o"></i> Download PDF
                        </a>
                        {{-- <a target="_blank" href="{{route('khajna-pay.vumiOffice.report.export', \Request::all())}}" class=" btn btn-info btn-sm">
                            <i class="fa fa-file-excel-o"></i> Download Excel
                        </a> --}}
                    </div>
                </div>
                {{Form::close()}}
                </div>
            </div>
        </div>

@if($searchedData > 0)
@if($namjari)
<div>
    <h4 style="text-align: center;"><b>খতিয়ান নং- {{$namjari->namjari_khotian_no or ''}}</b></h4>
</div>
<div class="col-md-12" style="margin-bottom: 20px; margin-top: 10px;">
    <table>
        <tr>
            <td class="col-md-2" style="border: none;">বিভাগ : ঢাকা</td>
            <td class="col-md-2" style="border: none;">জেলা : {{$namjari->land->zila->title or ''}}</td>
            <td class="col-md-3" style="border: none;">মৌজা : {{ $namjari->land->area->title or ''}}</td>
            <td class="col-md-2" style="border: none;">জে এল নং : {{ $namjari->namjari_jl_no or ''}}</td>
            <td class="col-md-2" style="border: none;">রে: সা: নং: </td>
        </tr>
    </table>

    </div>
</div>

<table>
    <thead>
        <tr>
            <td>মালিক, অকৃষি প্রজা বা ইজারাদারের নাম ও ঠিকানা</td>
            <td>অংশ</td>
            <td>রাজস্ব</td>
            <td>দাগ নং</td>
            <td>জমি ও শ্রেণী</td>
            <td>দাগের মোট পরিমান</td>
            <td>দাগের মধ্যে অত্র খতিয়ানের অংশ</td>
            <td>অংশ অনুযায়ীই জমির পরিমান</td>
            <td>দখল বিষয়ক বা অন্যান্য বিশেষ মন্তব্য</td>
        </tr>
    </thead>
    <tbody>
        <?php $motJomi = 0; ?>
        @foreach ($namjaries as $namjari)
        <tr>
            <td>{{$namjari->title or ''}}</td>
            <td></td>
            <td></td>
            <td>{{$namjari->namjarir_dag_no or ''}}</td>
            <td>
                @if($namjari->jomir_sreny == 0)
                    কৃষি
                @elseif($namjari->jomir_sreny == 1)
                    অকৃষি ( {{$namjari->jomir_sreny_details or 'Null'}} )
                @else
                    N/A
                @endif
            </td>
            <td>{{$namjari->oi_dage_mot_jomi or ''}}
                @if($namjari->jomir_unit == 1)
                    শতাংশ
                @elseif($namjari->jomir_unit == 2)
                    অযুতাংশ
                @elseif($namjari->jomir_unit == 3)
                    একর 
                @elseif($namjari->jomir_unit == 4)
                    কাঠা
                @elseif($namjari->jomir_unit == 5)
                    বিঘা
                @endif
            </td>
            <td>{{$namjari->dager_moddhe_khotianer_ongsho or ''}}</td>
            <td>{{$namjari->ongsho_onujaie__jomir_poriman or ''}}
                <?php $motJomi += bn2en($namjari->ongsho_onujaie__jomir_poriman); ?>
                @if($namjari->ongsho_onujaie_jomir_akok == 1)
                    শতাংশ
                @elseif($namjari->ongsho_onujaie_jomir_akok == 2)
                    অযুতাংশ
                @elseif($namjari->ongsho_onujaie_jomir_akok == 3)
                    একর 
                @elseif($namjari->ongsho_onujaie_jomir_akok == 4)
                    কাঠা
                @elseif($namjari->ongsho_onujaie_jomir_akok == 5)
                    বিঘা
                @endif
            </td>
            <td>{{$namjari->note or ''}}</td>
        </tr>
        @endforeach
        <tr>
            <td>ধারামতে নোট বা পরিবর্তন,  মোকদ্দমা নং এবং সন</td>
            <td></td>
            <td colspan="5" style="text-align: right;">মোট জমি:</td>
            <td><b>{{en2bn($motJomi)}}
                @if($namjari->ongsho_onujaie_jomir_akok == 1)
                    শতাংশ
                @elseif($namjari->ongsho_onujaie_jomir_akok == 2)
                    অযুতাংশ
                @elseif($namjari->ongsho_onujaie_jomir_akok == 3)
                    একর 
                @elseif($namjari->ongsho_onujaie_jomir_akok == 4)
                    কাঠা
                @elseif($namjari->ongsho_onujaie_jomir_akok == 5)
                    বিঘা
                @endif
            </b>
            </td>
            <td></td>
        </tr>
    </tbody>        
</table>

@endif

    </div>
@endif
@endsection

@section('scripts')

@endsection
