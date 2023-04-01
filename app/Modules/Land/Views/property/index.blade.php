@extends('main_layouts.app')

@section('content')
<div class="row animated zoomIn">
	@include('errorOrSuccess')
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<!-- <i class="icon-settings font-green"></i> -->
					<span class="caption-subject bold uppercase">Property</span>

				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="padding: 8px !important;">ক্রমিক নং</th>
							<th style="padding: 8px !important;">Title</th>
							<th style="padding: 8px !important;">Land Title</th>
							<th style="padding: 8px !important;">Property Type</th>
							<th style="padding: 8px !important;">Latitude</th>
							<th style="padding: 8px !important;">Longitude</th>
							<th style="padding: 8px !important;">Status</th>
							<th style="padding: 8px !important;">Action</th>
						</tr>
					</thead>
					<tbody>
						@if(count($properties) > 0)
							<?php $i = 1; ?>
							@foreach($properties as $property)
							<tr>
								<td>{{ en2bn($i++) }}</td>
								<td>{{$property->title or ''}}</td>
								<td>{{$property->land->title or ''}}</td>
								<td>{{$property->propertyType->title or ''}}</td>
								<td>{{$property->latitude or ''}}</td>
								<td>{{$property->longitude or ''}}</td>
								<td>
									@if($property->status == 0)
									Inactive
									@elseif($property->status == 1)
									Active
									@else
									N/A
									@endif
								</td>
								<td>
									<a href="{{ url('land/property/'.$property->id.'/edit') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>Edit</button></a>
									<a href="{{ url('land/property/'.$property->id) }}"><button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>View</button></a>
								</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				<div id="map_canvas" class="col-md-12" style="height: 450px; margin: 0.6em;"></div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>

<script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$('#nopagination').DataTable({
			"paging": true,
			"bFilter": true,
			"info": true,
                        "iDisplayLength": 25
		});

		highlight_nav('land_land');
	});
</script>

@endsection

@section('scripts')
<script>
	$(function () {
		var markers = [];
		@foreach($properties as $property)
			var pos = new Array();
			pos[0] = {{ $property->latitude }};
			pos[1] = {{ $property->longitude }};
			pos[2] = "{{ $property->title }}";
			markers.push(pos);
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
		for( i = 0; i < markers.length; i++ ) {
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
	    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
				this.setZoom(14);
        		google.maps.event.removeListener(boundsListener);
    		});
	});
Add a comment to this line
+</script>
@endsection
