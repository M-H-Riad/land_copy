@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">
  @include('errorOrSuccess')
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-red-sunglo">
              <i class="icon-settings font-red-sunglo"></i>
              <span class="caption-subject bold uppercase">ভূমির তথ্যাদি</span>
          </div>
      </div>

      <div class="portlet-body">
        {{Form::open(['url'=>'land/land/'.$land->id,'method'=>'put','class'=>"form-horizontal",'role'=>'form', 'enctype' => 'multipart/form-data'])}}
          <div class="form-group col-md-12">
              <label for="title" class="col-md-3 control-label">স্থাপনার নাম <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('title', $land->title, ['class' => 'form-control' , 'id' => 'title','required'=>'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
            <label for="zila_id" class="col-md-3 control-label">জেলা<span style="color:red">*</span></label>
            <div class="col-md-5">
              {!! Form::select('zila_id', $zilas, $land->zila_id, ['class' => 'form-control select2','placeholder' => 'Select Zila', 'style' => 'width:100%']) !!}
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="thana_id" class="col-md-3 control-label">থানা<span style="color:red">*</span></label>
            <div class="col-md-5" id="thana_id">
                {!! Form::select('thana_id', $thanas, $land->thana_id, ['class' => 'form-control select2','placeholder' => 'Select Thana', 'style' => 'width:100%']) !!}
            </div>
        </div>
          <div class="form-group col-md-12">
              <label for="zone_id" class="col-md-3 control-label">জোন<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('zone_id', $zones, $land->zone_id, ['class' => 'form-control select2','placeholder' => 'Select Land Zone', 'style' => 'width:100%']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">মৌজা<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('area_id', $areas, $land->area_id, ['class' => 'form-control select2','placeholder' => 'Select Land Area', 'style' => 'width:100%']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="source_id" class="col-md-3 control-label">প্রাপ্তি উৎস<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('land_source_id', $sources, $land->land_source_id, ['class' => 'form-control select2','placeholder' => 'Select Land Source type', 'style' => 'width:100%']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="address" class="col-md-3 control-label">ঠিকানা <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('address', $land->address, ['class' => 'form-control', 'id' => 'searchTextField', 'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="dag_no" class="col-md-3 control-label">দাগ নং <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('dag_no', $land->dag_no, ['class' => 'form-control', 'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="khotian" class="col-md-3 control-label">খতিয়ান নং <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('khotian', $land->khotian, ['class' => 'form-control', 'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="quantity" class="col-md-3 control-label">জমির পরিমান</label>
              <div class="col-md-5">
                  {{ Form::text('quantity', $land->quantity, ['class' => 'form-control']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="khajna_land" class="col-md-3 control-label">খাজনা প্রদানকৃত জমির পরিমান</label>
              <div class="col-md-5">
                  {{ Form::text('khajna_land', $land->khajna_land, ['class' => 'form-control']) }}
              </div>
          </div>
          <!-- <div class="form-group col-md-12">
              <label for="ownership_details" class="col-md-3 control-label">প্রাপ্তি উৎস <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('ownership_details', $land->ownership_details, ['class' => 'form-control', 'required']) }}
              </div>
          </div> -->
          <div class="form-group col-md-12">
              <label for="current_status" class="col-md-3 control-label">বর্তমান অবস্থা <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('current_status', $land->current_status, ['class' => 'form-control', 'required']) }}
              </div>
          </div>
          {{-- <div class="form-group col-md-12">
              <label for="khajna" class="col-md-3 control-label">ভূমি উন্নয়ন করের বিবরণ <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('khajna', $land->khajna, ['class' => 'form-control', 'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="namjari" class="col-md-3 control-label">নামজারীর বিবরণ <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('namjari', $land->namjari, ['class' => 'form-control', 'required']) }}
              </div>
          </div> --}}
          <div class="form-group col-md-12">
              <label for="comment" class="col-md-3 control-label">মন্তব্য </label>
              <div class="col-md-5">
                  {{ Form::text('comment', $land->comment, ['class' => 'form-control']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="status" class="col-md-3 control-label">Status <span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], $land->status, ['class' => 'form-control','placeholder' => 'Select Status','style' => 'width:100%']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="coordinates" class="col-md-3 control-label">Coordinates</label>
              <div class="col-md-5">
                  {{ Form::textarea('coordinates', $land->coordinates, ['class' => 'form-control MapLat', 'id' => 'coordinates', 'readonly']) }}
              </div>
          </div>

          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 1</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_1', $land->doc_name_1, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_1', null, ['class' => '']) }}
                <span class="col-md-3"><img class="card-img-top" src="{{ asset($land->doc_1) }}" alt="doc_1" style="height: 50px; width: 100px;" /></span>
            </div>
          </div>
          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 2</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_2', $land->doc_name_2, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_2', null, ['class' => '']) }}
                <span class="col-md-3"><img class="card-img-top" src="{{ asset($land->doc_2) }}" alt="doc_2" style="height: 50px; width: 100px;" /></span>
            </div>
          </div>
          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 3</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_3', $land->doc_name_3, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_3', null, ['class' => '']) }}
                <span class="col-md-3"><img class="card-img-top" src="{{ asset($land->doc_3) }}" alt="doc_3" style="height: 50px; width: 100px;" /></span>
            </div>
          </div>
          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 4</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_4', $land->doc_name_4, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_4', null, ['class' => '']) }}
                <span class="col-md-3"><img class="card-img-top" src="{{ asset($land->doc_4) }}" alt="doc_4" style="height: 50px; width: 100px;" /></span>
            </div>
          </div>
          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 5</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_5', $land->doc_name_5, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_5', null, ['class' => '']) }}
                <span class="col-md-3"><img class="card-img-top" src="{{ asset($land->doc_5) }}" alt="doc_5" style="height: 50px; width: 100px;" /></span>
            </div>
          </div>

          <hr>
          <div class="form-group">
              <div class="col-md-11 text-center" style="padding-bottom: 20px; margin-top: 10px;">
                  <button type="submit" class="btn blue">Submit</button>
              </div>
          </div>
          {{Form::close()}}
          <div id="map_canvas" class="col-md-12" style="height: 450px; margin: 0.6em;"></div>

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

    highlight_nav('land');
  });
</script>


@endsection

@section('scripts')
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                center: {lat: 23.7532387, lng: 90.392429},
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            });

            var drawingManager = new google.maps.drawing.DrawingManager({
                polygonOptions: {
                    fillOpacity: 0.2,
                    strokeWeight: 3,
                    editable: true,
                    draggable: true,
                    zIndex: 1
                },
                map: map,
                drawingControl: false,
            });

            drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
                // When draw mode is set to null you can edit the polygon you just drawed

                getCoordinates(event);
                drawingManager.setDrawingMode(null);
                google.maps.event.addListener(event.overlay.getPath(), 'remove_at', function(){
                    getCoordinates(event);
                });
                google.maps.event.addListener(event.overlay.getPath(), 'set_at', function(){
                    getCoordinates(event);
                });
                google.maps.event.addListener(event.overlay.getPath(), 'insert_at', function(){
                    getCoordinates(event);
                });
            });
        }

        function getCoordinates(drawingManager){
            var vertices = drawingManager.overlay.getPath();
            var coordinates = "";
            for (var i =0; i < vertices.getLength(); i++) {
                var xy = vertices.getAt(i);
                if(i > 0)
                    coordinates += ",";
                coordinates += xy.lat()+","+xy.lng();
            }
            document.getElementById('coordinates').innerHTML = coordinates;
        }

    </script>

{{--<script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE"></script>--}}
<script>
  $(function () {
    var coords = "{{ $land->coordinates ?  $land->coordinates  : '23.75320440677523,90.3925051076808' }}";
    var points = coords.split(',');
    var paths = [];
    for (var i in points) {
      if(i % 2 == 1)
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
            fillOpacity: 0.35,
            editable: true
          });
        polygon.setMap(map);
    map.fitBounds(bounds);

    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                            this.setZoom(14);
                            google.maps.event.removeListener(boundsListener);
                          });

    google.maps.event.addListener(polygon.getPath(), 'remove_at', function(){
      getCoordinates(polygon);
    });
    google.maps.event.addListener(polygon.getPath(), 'set_at', function(){
      getCoordinates(polygon);
    });
    google.maps.event.addListener(polygon.getPath(), 'insert_at', function(){
      getCoordinates(polygon);
    });

    function getCoordinates(drawingManager){
      var vertices = drawingManager.getPath();
      var coordinates = "";
      for (var i =0; i < vertices.getLength(); i++) {
        var xy = vertices.getAt(i);
        if(i > 0)
          coordinates += ",";
        coordinates += xy.lat()+","+xy.lng();
      }
      document.getElementById('coordinates').innerHTML = coordinates;
    }
  });
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE&libraries=drawing&callback=initMap&language=en&sensor=true"
            async defer>
    </script>
<script>
    $(document).ready(function() {
        $('select[name="zone_id"]').on('change', function() {
            var zoneID = $(this).val();
            var url = '{{ url("land/getareas/")}}/' + zoneID;
            if(zoneID) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="area_id"]').empty();
                        $('select[name="area_id"]').append('<option value="">Select Area</option>');
                        $.each(data, function(key, value) {
                            $('select[name="area_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });

        $('select[name="zila_id"]').on('change', function() {
            var zilaID = $(this).val();
            var url = '{{ url("land/getthanas/")}}/' + zilaID;
            if(zilaID) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="thana_id"]').empty();
                        $('select[name="thana_id"]').append('<option value="">Select Thana</option>');
                        $.each(data, function(key, value) {
                            $('select[name="thana_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
    });
</script>
@endsection
