@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">
  @include('errorOrSuccess')
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-red-sunglo">
              <i class="icon-settings font-red-sunglo"></i>
              <span class="caption-subject bold uppercase">Property management</span>
          </div>
      </div>

      <div class="portlet-body">
        {{Form::open(['url'=>'land/property','method'=>'post','class'=>"form-horizontal",'role'=>'form'])}}
          <div class="form-group col-md-12">
              <label for="title" class="col-md-3 control-label">Title <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('title', null, ['class' => 'form-control' , 'id' => 'title','required'=>'required']) }}
              </div>
          </div>
          <input type="hidden" name="land_id" value="{{ $land->id }}">
          <div class="form-group col-md-12">
              <label for="property_type_id" class="col-md-3 control-label">Property Type<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('property_type_id', $propertyTypes, null, ['class' => 'form-control select2','placeholder' => 'Property Type', 'style' => 'width:100%']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="latitude" class="col-md-3 control-label">Latitude <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('latitude', null, ['class' => 'form-control MapLat', 'id'=>'latitude', 'required', 'readonly']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="longitude" class="col-md-3 control-label">Longitude <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('longitude', null, ['class' => 'form-control MapLon', 'id'=>'longitude', 'required', 'readonly']) }}
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
  $(function () {
    var coords = "{{ $land->coordinates }}";
    var points = coords.split(',');
    var paths = [];
    for (var i in points) {
      if(i % 2 == 1)
        continue;
      paths.push({lat: parseFloat(points[i++]), lng: parseFloat(points[i])});
    }
      $('.MapLat').val(paths[0].lat);
      $('.MapLon').val(paths[0].lng);
    var image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png',
        bounds = new google.maps.LatLngBounds();
        mapOptions = {
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
        };
        position = new google.maps.LatLng(paths[0]["lat"], paths[0]["lng"]);
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        polygon = new google.maps.Polygon({
            paths: paths,
            strokeColor: '#5f5f5f',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillOpacity: 0
          });

    polygon.setMap(map);
    bounds.extend(position);
    map.fitBounds(bounds);

    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
          this.setZoom(14);
          google.maps.event.removeListener(boundsListener);
        });

    marker = new google.maps.Marker({
      position: position,
      map: map,
      icon: image
    });
      polygon.addListener('click', function (event) {
        alert(event)
      if(google.maps.geometry.poly.containsLocation(event.latLng, polygon)){
        var lat = event.latLng.lat(),
            lng = event.latLng.lng(),
            latlng = new google.maps.LatLng(lat, lng);
        marker.setIcon(image);
        marker.setPosition(latlng);
        $('.MapLat').val(lat);
        $('.MapLon').val(lng);
      }
    });
  });
</script>
<script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE"></script>
@endsection
