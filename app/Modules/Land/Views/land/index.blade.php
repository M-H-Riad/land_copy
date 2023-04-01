@extends('main_layouts.app')

@section('content')
    <div class="row animated zoomIn">
        @include('errorOrSuccess')

        <div class="col-md-12">
            @include('Land::land.filter')
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">ভূমির তথ্যাদি</span>

                    </div>

                    <div class="actions font-white">
                        <a class="btn btn-success bnt-lg pull-right" href="{{ url('land/land/create')}}">
                            <i class="fa fa-plus"></i> Add
                        </a>
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
                            <th style="padding: 8px !important;">প্রাপ্তি উৎস</th>
                            <th style="padding: 8px !important;">ঠিকানা</th>
                            <th style="padding: 8px !important;">দাগ নং</th>
                            <th style="padding: 8px !important;">খতিয়ান নং</th>
                            <th style="padding: 8px !important;">জমির পরিমান</th>
                            <th style="padding: 8px !important;">খাজনা প্রদানকৃত জমির পরিমান</th>
                            <!-- <th style="padding: 8px !important;">প্রাপ্তি উৎস</th> -->
                            <th style="padding: 8px !important;">বর্তমান অবস্থা</th>
                            {{-- <th style="padding: 8px !important;">ভূমি উন্নয়ন করের বিবরণ</th>
                            <th style="padding: 8px !important;">নামজারীর বিবরণ</th> --}}
                            {{-- <th style="padding: 8px !important;">Coordinates</th> --}}
                            <th style="padding: 8px !important;">Status</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($lands) > 0)
                            <?php $i = $lands->toArray()['from'];  ?>
                            @foreach($lands as $land)
                                <tr>
                                    <td>{{ en2bn($i++) }}</td>
                                    <td>{{$land->title or ''}}</td>
                                    <td>মডস {{$land->zone->title or ''}}</td>
                                    <td>{{$land->area->title or ''}}</td>
                                    <td>{{$land->source->title or ''}}</td>
                                    <td>{{$land->address or ''}}</td>
                                    <td>{{$land->dag_no or ''}}</td>
                                    <td>{{$land->khotian or ''}}</td>
                                    <td>{{$land->quantity or ''}}</td>
                                    <td>{{$land->khajna_land or ''}}</td>
                                    <!-- <td>{{$land->ownership_details or ''}}</td> -->
                                    <td>{{$land->current_status or ''}}</td>
                                    {{-- <td>{{$land->khajna or ''}}</td>
                                    <td>{{$land->namjari or ''}}</td> --}}
                                    {{-- <td>{{$land->coordinates or ''}}</td> --}}
                                    <td>
                                        @if($land->status == 0)
                                            Inactive
                                        @elseif($land->status == 1)
                                            Active
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ url('land/land/'.$land->id.'/edit') }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ url('land/land/'.$land->id) }}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a target="_blank" class="btn btn-warning btn-sm" href="{{ url('land/land/'.$land->id.'/single-pdf') }}">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </a>
                                            <form action="{{ route('land.destroy', $land->id) }}" method="POST">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure to delete?')">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    @if(count($lands)>0)
                        {{$lands->appends($_REQUEST)->render()}}
                    @endif

                    <div id="map_canvas" class="col-md-12" style="height: 450px; margin: 0.6em;"></div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

    <script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE"></script>
    <script type="text/javascript">
        $(document).ready(function () {


            // $('#nopagination').DataTable({
            //     "paging": true,
            //     "bFilter": false,
            //     "info": false,
            //     "bLengthChange" : false,
            //     "iDisplayLength":-1
            // });

            highlight_nav('land_land');
        });
    </script>

@endsection

@section('scripts')
    <script>
        $(function () {
            var markers = [];
                    @foreach($lands as $land)
            var coords = "{{ $land->coordinates }}";
            var points = coords.split(',');
            var paths = [];
            for (var i in points) {
                if (i % 2 == 1)
                    continue;
                paths.push({lat: parseFloat(points[i++]), lng: parseFloat(points[i])});
            }
            markers.push(paths);
                    @endforeach

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

            for (i = 0; i < markers.length; i++) {
                var position = new google.maps.LatLng(markers[i][0]["lat"], markers[i][0]["lng"]);
                bounds.extend(position);

                var polygon = new google.maps.Polygon({
                    paths: markers[i],
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35
                });
                polygon.setMap(map);
                map.fitBounds(bounds);
            }
            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
                this.setZoom(10);
                google.maps.event.removeListener(boundsListener);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('select[name="zone_id"]').on('change', function () {
                var zoneID = $(this).val();
                var url = '{{ url("land/getareas/")}}/' + zoneID;
                if (zoneID) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="area_id"]').empty();
                            $('select[name="area_id"]').append('<option value="">Select Area</option>');
                            $.each(data, function (key, value) {
                                $('select[name="area_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="city"]').empty();
                }
            });
        });
    </script>
@endsection
