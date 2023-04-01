@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">
	<div class="col-md-8">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<!-- <i class="icon-settings font-green"></i> -->
					<span class="caption-subject bold uppercase">Property</span>

				</div>
				<a href="{{ url('land/property/'.$property->id.'/edit') }}" class="actions font-white"><button type="button" class="btn btn-success bnt-lg pull-right"><i class="fa fa-edit"></i> Edit</button></a>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover">
					<tbody>
						<dl class="dl-horizontal">
							<dt>Property Title</dt>
							<dd>{{$property->title or ''}}</dd>
						</dl>
						<dl class="dl-horizontal">
							<dt>Land Title</dt>
							<dd>{{$property->land->title or ''}}</dd>
						</dl>
						<dl class="dl-horizontal">
							<dt>Property Type</dt>
							<dd>{{$property->propertyType->title or ''}}</dd>
						</dl>
						<dl class="dl-horizontal">
							<dt>Latitude</dt>
							<dd>{{$property->latitude or ''}}</dd>
						</dl>
						<dl class="dl-horizontal">
							<dt>Longitude</dt>
							<dd>{{$property->longitude or ''}}</dd>
						</dl>
						<dl class="dl-horizontal">
							<dt>Status</dt>
							<dd>
								@if($property->status == 0)
								Inactive
								@elseif($property->status == 1)
								Active
								@else
								N/A
								@endif
							</dd>
						</dl>
					</tbody>
				</table>
				<div id="map_canvas" class="col-md-12" style="height: 450px; margin: 0.6em;"></div>
			</div>

		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {

		$('#nopagination').DataTable({
			"paging": true,
			"bFilter": true,
			"info": true
		});

		highlight_nav('land_area');
	});
</script>

@endsection


@section('scripts')
<script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE"></script>
<script>
  $(function () {
    var coords = "{{ (isset($property->land) && $property->land != null) ? $property->land->coordinates : '' }}";
    var points = coords.split(',');
    var paths = [];
    for (var i in points) {
      if(i % 2 == 1)
        continue;
      paths.push({lat: parseFloat(points[i++]), lng: parseFloat(points[i])});
    }

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
        },
        position = new google.maps.LatLng({{ $property->latitude }}, {{ $property->longitude }});
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        polygon = new google.maps.Polygon({
            paths: paths,
            strokeColor: '#5f5f5f',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillOpacity: 0
          });
        
    polygon.setMap(map);
    bounds.extend(position),
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
  });
</script>
@endsection
