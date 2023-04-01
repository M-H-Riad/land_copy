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
                            <span class="caption-subject bold uppercase">ভূমি উন্নয়ন কর (খাজনা বিবরণী)</span>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('land/khajna-info/'.$khajnaInfo->id.'/edit') }}" class="btn btn-success bnt-lg"><i
                                        class="fa fa-edit"></i> Edit</a>
                            <a target="_blank" href="{{ url('land/khajna-info/'.$khajnaInfo->id.'/single-pdf') }}"
                               class="btn btn-warning bnt-lg"><i class="fa fa-file-pdf-o"></i> PDF</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                            <dl class="dl-horizontal">
                                <dt>স্থাপনার নাম</dt>
                                <dd>{{$khajnaInfo->land->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>খাজনার তারিখ</dt>
                                <dd>{{$khajnaInfo->khajna_date or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>দাবির সন (বাংলা)</dt>
                                <dd>{{$khajnaInfo->from_year or ''}} <?php if($khajnaInfo->to_year != 'null'){ echo "to ".$khajnaInfo->to_year; } ?></dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>মৌজার নাম</dt>
                                <dd>{{$khajnaInfo->land->area->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>ভূমি অফিসের নাম</dt>
                                <dd>{{$khajnaInfo->khajna_office->office_name or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>খাজনার পরিমাণ</dt>
                                <dd>{{$khajnaInfo->bokeya or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>মন্তব্য</dt>
                                <dd>{{$khajnaInfo->note or ''}}</dd>
                            </dl>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
            <div class="col-md-5">
                <div class="portlet box red" id="document">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>চেক </div>
                    </div>
                    <div class="portlet-body" style="height: 300px;">
                        <img class="card-img-top" src="{{ asset($khajnaInfo->document) }}" alt="Image" />
                    </div>
                </div>
                <div class="portlet box red" id="dakhila">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>দাখিল </div>
                    </div>
                    <div class="portlet-body" style="height: 300px;">
                        <img class="card-img-top" src="{{ asset($khajnaInfo->dakhila) }}" alt="Image" />
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    
@endsection
