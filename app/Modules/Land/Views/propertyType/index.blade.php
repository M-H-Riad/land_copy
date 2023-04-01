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
					<span class="caption-subject bold uppercase">Land Property Type</span>

				</div>
				<button data-toggle="modal" data-target="#add-land_propertyType-modal" type="button" class="btn btn-success bnt-lg pull-right actions font-white"><i class="fa fa-plus"></i> Add &nbsp;</button>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="nopagination">
					<thead>
						<tr>
							<th style="padding: 8px !important;">ক্রমিক নং</th>
							<th style="padding: 8px !important;">Property Type Title</th>
							<th style="padding: 8px !important;">Status</th>
							<th style="padding: 8px !important;">Action</th>
						</tr>
					</thead>
					<tbody>
						@if(count($propertyTypes) > 0)
						@foreach($propertyTypes as $propertyType)
						<tr>
							<td>{{ en2bn($propertyType->id) }}</td>
							<td>{{$propertyType->title or ''}}</td>
							<td>
								@if($propertyType->status == 0)
								Inactive
								@elseif($propertyType->status == 1)
								Active
								@else
								N/A
								@endif
							</td>
							<td>
								<button  data-toggle="modal" data-target="#edit-land_propertyType-modal-{{$propertyType->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
								@include('Land::propertyType.edit')
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>

		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>

</div>
@include('Land::propertyType.create')
<script type="text/javascript">
	$(document).ready(function () {

		$('#nopagination').DataTable({
			"paging": true,
			"bFilter": true,
			"info": true,
                        "iDisplayLength": 25
		});

		highlight_nav('land_propertyType');
	});
</script>

@endsection