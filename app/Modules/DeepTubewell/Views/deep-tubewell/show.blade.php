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
                            <span class="caption-subject bold uppercase">গভীর নলকূপের তথ্য</span>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('deep-tubewell/deep-tubewell/'.$deep_tubewell->id.'/edit') }}" class="btn btn-success bnt-lg"><i
                                        class="fa fa-edit"></i> Edit</a>
                            <!-- <a target="_blank" href=""
                               class="btn btn-warning bnt-lg"><i class="fa fa-file-pdf-o"></i> PDF</a> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>

                            <dl class="dl-horizontal">
                                <dt>জোন</dt>
                                <dd>মডস {{$deep_tubewell->zone->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>মৌজা</dt>
                                <dd>{{$deep_tubewell->area->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>উৎসের ধরণ</dt>
                                <dd>{{$deep_tubewell->sourceType->title}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>উৎস</dt>
                                <dd>{{$deep_tubewell->sources->title}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>অনুমতি/চুক্তি/বরাদ্দ</dt>
                                <dd>
                                        @if($deep_tubewell->onumoti_chukti_boraddo==1)
                                            {{ অনুমতি }}
                                        @elseif($deep_tubewell->onumoti_chukti_boraddo==2)
                                            {{ চুক্তি }}
                                        @elseif($deep_tubewell->onumoti_chukti_boraddo==3)
                                            {{ বরাদ্দ }}
                                        @endif
                                </dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>অনুমতি/চুক্তি/বরাদ্দ তারিখ</dt>
                                <dd>{{ $deep_tubewell->onumoti_chukti_boraddo_date }}</dd>
                            </dl>

                            <dl class="dl-horizontal">
                                <dt>দখলপত্র তারিখ</dt>
                                <dd>{{ $deep_tubewell->dokholpotro_date }}</dd>
                            </dl>

                            <dl class="dl-horizontal">
                                <dt>স্থাপনা/গভীর নলকূপের জায়গার নাম</dt>
                                <dd>{{ $deep_tubewell->deep_tubewell_place_name }}</dd>
                            </dl>
                            
                            <dl class="dl-horizontal">
                                <dt>দাগ নং</dt>
                                <dd>{{$deep_tubewell->dag_no}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>খতিয়ান নং</dt>
                                <dd>{{$deep_tubewell->khotiyan_no}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>জমির পরিমান (একর)</dt>
                                <dd>{{$deep_tubewell->jomir_poriman}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>মন্তব্য</dt>
                                <dd>{{$deep_tubewell->destination}}</dd>
                            </dl>

                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
            <div class="col-md-5">
         
                <!-- BEGIN UNSTYLED LISTS PORTLET-->
                <div class="portlet box red" id="document">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Documents
                        </div>
                    </div>
                    <div class="portlet-body">
                      
                            
                            <div class="col-md-6">
                            <h5>অনুমতি/চুক্তি/বরাদ্দ সংযুক্তি</h5>
                                <span class="pull-left">Document Name : {{ $deep_tubewell->onumoti_chukti_boraddo_attach_name}}</span> <br>
                                <div>
                                    <a href="{{ asset($deep_tubewell->onumoti_chukti_boraddo_attach) }}" download>
                                        <img src="{{ asset($deep_tubewell->onumoti_chukti_boraddo_attach) }}" alt="{{$deep_tubewell->onumoti_chukti_boraddo_attach_name}}" height="100px" width="80px">
                                    </a>
                                </div>
                            </div>


                            
                            <div class="col-md-6">
                                <h5>দখলপত্র সংযুক্তি</h5>
                                <span class="pull-left">Document Name : {{ $deep_tubewell->dokholpotro_attach_name}}</span> <br>
                                <div>
                                    <a href="{{ asset($deep_tubewell->dokholpotro_attach) }}" download>
                                        <img src="{{ asset($deep_tubewell->dokholpotro_attach) }}" alt="{{$deep_tubewell->dokholpotro_attach_name}}" height="100px" width="80px">
                                    </a>
                                </div>
                            </div>

                            <h5 style="text-align:center;">অন্যান্য</h5>
                            <?php 
                                $other_attaches = json_decode($deep_tubewell->other_attach);
                                foreach($other_attaches as $other_attach){
                            ?>
                                <div class="col-md-6">
                                    <span class="pull-left">Document Name :{{ $other_attach->document_name}}</span> <br>
                                    <div>
                                        <a href="{{ asset($other_attach->file_name) }}" download>
                                            <img src="{{ asset($other_attach->file_name) }}" alt="{{ $other_attach->document_name}}" height="100px" width="80px">
                                        </a>
                                    </div>
                                </div>
                            <?php }?>
                            
                            
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#nopagination').DataTable({
                "paging": true,
                "bFilter": true,
                "info": true
            });

            highlight_nav('deep_tubewell');
        });
    </script>

@endsection


@section('scripts')
    <script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE"></script>

    <script>
        
    </script>
@endsection
