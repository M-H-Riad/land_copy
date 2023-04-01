@extends('main_layouts.app')

@section('content')

    <div class="row animated zoomIn">
        @include('errorOrSuccess')
        <div class="row">
            <div class="col-md-7">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-green">
                            <!-- <i class="icon-settings font-green"></i> -->
                            <span class="caption-subject bold uppercase">নামজারির তথ্যাদি</span>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('land/namjari/'.$namjari->id.'/edit') }}" class="btn btn-success bnt-lg"><i
                                        class="fa fa-edit"></i> Edit</a>
                            <a target="_blank" href="{{ url('land/namjari/'.$namjari->id.'/single-pdf') }}"
                               class="btn btn-warning bnt-lg"><i class="fa fa-file-pdf-o"></i> PDF</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                            <dl class="dl-horizontal">
                                <dt>স্থাপনার নাম</dt>
                                <dd>{{$namjari->land->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>নামজারি স্টেটাস</dt>
                                <dd>
                                    @if($namjari->status == 0)
                                       না
                                    @elseif($namjari->status == 1)
                                      হ্যা
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>জমির শ্রেণী</dt>
                                <dd>
                                    @if($namjari->jomir_sreny == 0)
                                        কৃষি
                                    @elseif($namjari->jomir_sreny == 1)
                                        অকৃষি ( {{$namjari->jomir_sreny_details or 'Null'}} )
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>নামজারি তারিখ</dt>
                                <dd>{{ en2bn($namjari->namjari_date) }}</dd>
                            </dl>
                            {{-- <dl class="dl-horizontal">
                                <dt>প্রাপ্তির তারিখ</dt>
                                <dd>{{ en2bn($namjari->purchase_date) }}</dd>
                            </dl> --}}
                            <dl class="dl-horizontal">
                                <dt>খতিয়ান নং</dt>
                                <dd>{{$namjari->namjari_khotian_no or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>দাগ নং</dt>
                                <dd>{{$namjari->namjarir_dag_no or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>ওই দাগে মোট জমির পরিমান</dt>
                                <dd>{{$namjari->oi_dage_mot_jomi or ''}}
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
                                </dd>
                            </dl>
                            {{-- <dl class="dl-horizontal">
                                <dt>দাগের মধ্যে অত্র খতিয়ানের অংশ</dt>
                                <dd>{{$namjari->dager_moddhe_khotianer_ongsho or ''}}</dd>
                            </dl> --}}
                            {{-- <dl class="dl-horizontal">
                                <dt>অংশ অনুযায়ীই জমির পরিমান</dt>
                                <dd>{{$namjari->ongsho_onujaie__jomir_poriman or ''}}
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
                                </dd>
                            </dl> --}}
                            <dl class="dl-horizontal">
                                <dt>জোত নং</dt>
                                <dd>{{$namjari->namjari_jot_no or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>জে এল নং</dt>
                                <dd>{{$namjari->namjari_jl_no or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>মন্তব্য</dt>
                                <dd>{{$namjari->note or ''}}</dd>
                            </dl>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    
@endsection
