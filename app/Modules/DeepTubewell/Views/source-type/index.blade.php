@extends('main_layouts.app')

@section('content')
<div class="row animated zoomIn">
	@include('errorOrSuccess')
	<div class="col-md-12">
		@include('Land::source.filter')
	</div>
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<!-- <i class="icon-settings font-green"></i> -->
					<span class="caption-subject bold uppercase">Land Source</span>

				</div>
				<button data-toggle="modal" data-target="#add-land_source-modal" type="button" class="btn btn-success bnt-lg pull-right"><i class="fa fa-plus"></i> Add</button>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="padding: 8px !important;">ক্রমিক নং</th>
							<th style="padding: 8px !important;">Source Type</th>
							<th style="padding: 8px !important;">Status</th>
							<th style="padding: 8px !important;">Action</th>
						</tr>
					</thead>
					<tbody>
					@if(count($source_types) > 0)
						@php $i = $source_types->toArray()['from'];  @endphp
						
						@foreach($source_types as $source_type)
						<tr>
							<td>{{ en2bn($i++) }}</td>
							<td>{{$source_type->title}}</td>
							<td>
								@if($source_type->status == 0)
								Inactive
								@elseif($source_type->status == 1)
								Active
								@else
								N/A
								@endif
							</td>
							<td class="action_buttons_style">
								<button  data-toggle="modal" data-target="#edit-land_source-modal-{{$source_type->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button>
								@include('DeepTubewell::source-type.edit')
								<form action="{{ route('source-type.destroy',$source_type->id) }}" method="POST">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this source Type')" title="Delete"><i class="fa fa-trash-o"></i>Delete </button>
				 				</form>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
			@if(count($sources)>0)
				{{$sources->appends($_REQUEST)->render()}}
			@endif
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>

</div>
@include('DeepTubewell::source-type.create')
<script type="text/javascript">
	$(document).ready(function () {

		highlight_nav('land_source');
	});
</script>

@endsection