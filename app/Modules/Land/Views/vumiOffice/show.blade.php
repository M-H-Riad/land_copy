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
                            <a href="{{ url('land/vumi_office/'.$vumiOffice->id.'/edit') }}" class="btn btn-success bnt-lg"><i
                                        class="fa fa-edit"></i> Edit</a>
                            <a target="_blank" href="{{ url('land/vumi_office/'.$vumiOffice->id.'/single-pdf') }}"
                               class="btn btn-warning bnt-lg"><i class="fa fa-file-pdf-o"></i> PDF</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                            <dl class="dl-horizontal">
                                <dt>ভূমি অফিসের নাম</dt>
                                <dd>{{$vumiOffice->office_name or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>ভূমি অফিসের ঠিকানা</dt>
                                <dd>{{$vumiOffice->address or ''}}</dd>
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
