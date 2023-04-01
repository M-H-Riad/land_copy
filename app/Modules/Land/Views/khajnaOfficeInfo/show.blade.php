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
                            <span class="caption-subject bold uppercase">স্থাপনা অনুযায়ী ভূমি অফিস</span>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('land/khajna-office/'.$khajnaOffice->id.'/edit') }}" class="btn btn-success bnt-lg"><i
                                        class="fa fa-edit"></i> Edit</a>
                            <a target="_blank" href="{{ url('land/khajna-office/'.$khajnaOffice->id.'/single-pdf') }}"
                               class="btn btn-warning bnt-lg"><i class="fa fa-file-pdf-o"></i> PDF</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                            <dl class="dl-horizontal">
                                <dt>স্থাপনার নাম</dt>
                                <dd>{{$khajnaOffice->land->title or ''}}</dd>
                            </dl>
                            <!-- <dl class="dl-horizontal">
                                <dt>উপজেলার নাম</dt>
                                <dd>{{$khajnaOffice->upazila->upazila_name or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>মৌজার নাম</dt>
                                <dd>{{$khajnaOffice->mowza->mowja_name or ''}}</dd>
                            </dl> -->
                            <dl class="dl-horizontal">
                                <dt>ভূমি অফিসের নাম</dt>
                                <dd>{{$khajnaOffice->mokhajna_office->office_name or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>ওপেনিং কর দাবির সন</dt>
                                <dd>{{$khajnaOffice->open_year or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>বকেয়ার পরিমাণ</dt>
                                <dd>{{$khajnaOffice->total_bokeya or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>ভূমি অফিসের নাম</dt>
                                <dd>{{$khajnaOffice->from_year or '-'}} <?php echo " -- "; ?> {{ $khajnaOffice->to_year or '-' }}</dd>
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
