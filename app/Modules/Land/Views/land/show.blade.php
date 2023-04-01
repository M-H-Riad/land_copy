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
                            <span class="caption-subject bold uppercase">ভূমির তথ্যাদি</span>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('land/land/'.$land->id.'/edit') }}" class="btn btn-success bnt-lg"><i
                                        class="fa fa-edit"></i> Edit</a>
                            <a target="_blank" href="{{ url('land/land/'.$land->id.'/single-pdf') }}"
                               class="btn btn-warning bnt-lg"><i class="fa fa-file-pdf-o"></i> PDF</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                            <dl class="dl-horizontal">
                                <dt>স্থাপনার নাম</dt>
                                <dd>{{$land->title or ''}}</dd>
                            </dl>

                            <dl class="dl-horizontal">
                                <dt>জেলা</dt>
                                <dd>{{$land->zila->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>থানা</dt>
                                <dd>{{$land->thana->title or ''}}</dd>
                            </dl>

                            <dl class="dl-horizontal">
                                <dt>জোন</dt>
                                <dd>মডস {{$land->zone->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>মৌজা</dt>
                                <dd>{{$land->area->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>প্রাপ্তি উৎস</dt>
                                <dd>{{$land->source->title or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>ঠিকানা</dt>
                                <dd>{{$land->address or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>দাগ নং</dt>
                                <dd>{{$land->dag_no or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>খতিয়ান নং</dt>
                                <dd>{{$land->khotian or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>জমির পরিমান</dt>
                                <dd>{{$land->quantity or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>খাজনা প্রদানকৃত জমির পরিমান</dt>
                                <dd>{{$land->khajna_land or ''}}</dd>
                            </dl>
                            <!-- <dl class="dl-horizontal">
                                <dt>প্রাপ্তি উৎস</dt>
                                <dd>{{$land->ownership_details or ''}}</dd>
                            </dl> -->
                            <dl class="dl-horizontal">
                                <dt>বর্তমান অবস্থা</dt>
                                <dd>{{$land->current_status or ''}}</dd>
                            </dl>
                            {{-- <dl class="dl-horizontal">
                                <dt>ভূমি উন্নয়ন করের বিবরণ</dt>
                                <dd>{{$land->khajna or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>নামজারীর বিবরণ</dt>
                                <dd>{{$land->namjari or ''}}</dd>
                            </dl> --}}
                            <dl class="dl-horizontal">
                                <dt>মন্তব্য</dt>
                                <dd>{{$land->comment or ''}}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>Status</dt>
                                <dd>
                                    @if($land->status == 0)
                                        Inactive
                                    @elseif($land->status == 1)
                                        Active
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </dl>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
            <div class="col-md-5">
                {{-- @include("Land::land.document")
                @include("Land::land.property") --}}
                <!-- BEGIN UNSTYLED LISTS PORTLET-->
                <div class="portlet box red" id="document">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Documents
                        </div>
                    </div>
                    <div class="portlet-body">
                        {{-- <table> --}}
                            <?php $land; ?>
                            <div class="col-md-6">
                                <span class="pull-left">{{ $land->doc_name_1 or '' }}</span> <br>
                                <div>
                                    <a href="{{ asset($land->doc_1) }}" download>
                                        <img src="{{ asset($land->doc_1) }}" alt="{{$land->doc_name_1}}" height="200px" width="180px">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="pull-left">{{ $land->doc_name_2 or '' }}</span> <br>
                                <div>
                                    <a href="{{ asset($land->doc_2) }}" download>
                                        <img src="{{ asset($land->doc_2) }}" alt="{{$land->doc_name_2}}" height="200px" width="180px">
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <span class="pull-left">{{ $land->doc_name_1 or '' }}</span> <br>
                                <div>
                                    <a href="{{ asset($land->doc_3) }}" download>
                                        <img src="{{ asset($land->doc_3) }}" alt="{{$land->doc_name_3}}" height="200px" width="180px">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="pull-left">{{ $land->doc_name_4 or '' }}</span> <br>
                                <div>
                                    <a href="{{ asset($land->doc_4) }}" download>
                                        <img src="{{ asset($land->doc_4) }}" alt="{{$land->doc_name_4}}" height="200px" width="180px">
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <span class="pull-left">{{ $land->doc_name_5 or '' }}</span> <br>
                                <div>
                                    <a href="{{ asset($land->doc_5) }}" download>
                                        <img src="{{ asset($land->doc_5) }}" alt="{{$land->doc_name_5}}" height="200px" width="180px">
                                    </a>
                                </div>
                            </div>
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

            highlight_nav('land_land');
        });
    </script>

@endsection


@section('scripts')
    <script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE"></script>
    <script>
        $(function () {
            var coords = "{{ $land->coordinates }}";
            var points = coords.split(',');
            var paths = [];
            for (var i in points) {
                if (i % 2 == 1)
                    continue;
                paths.push({lat: parseFloat(points[i++]), lng: parseFloat(points[i])});
            }

            var map;
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    panControl: true,
                    panControlOptions: {
                        position: google.maps.ControlPosition.TOP_RIGHT
                    },
                    zoomControl: true,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.LARGE,
                        position: google.maps.ControlPosition.TOP_left
                    }
                },
                image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png',
                map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

            var position = new google.maps.LatLng(paths[0]["lat"], paths[0]["lng"]);
            bounds.extend(position);

            var polygon = new google.maps.Polygon({
                paths: paths,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });
            polygon.setMap(map);
            map.fitBounds(bounds);

            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
                this.setZoom(14);
                google.maps.event.removeListener(boundsListener);
            });

            var markers = [];
                    @foreach($properties as $property)
            var pos = new Array();
            pos[0] = {{ $property->latitude }};
            pos[1] = {{ $property->longitude }};
            pos[2] = "{{ $property->title }}";
            markers.push(pos);
                    @endforeach
            for (i = 0; i < markers.length; i++) {
                var position = new google.maps.LatLng(markers[i][0], markers[i][1]);
                bounds.extend(position);
                var marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    icon: image,
                    title: markers[i][2]
                });
                map.fitBounds(bounds);
            }
        });
    </script>
@endsection
