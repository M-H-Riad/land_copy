@extends('main_layouts.app')

@section('content')
<div class="row animated zoomIn">
	@include('errorOrSuccess')
	<div class="col-md-12">
		@include('User::department.filter')
	</div>
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<!-- <i class="icon-settings font-green"></i> -->
					<span class="caption-subject bold uppercase">Department</span>

				</div>
				<button data-toggle="modal" data-target="#add-designation-modal" type="button" class="btn btn-success bnt-lg pull-right"><i class="fa fa-plus"></i> Add</button>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="padding: 8px !important;">ক্রমিক নং</th>
							<th style="padding: 8px !important;">Department Name</th>
							<th style="padding: 8px !important;">Status</th>
							<th style="padding: 8px !important;">Action</th>
						</tr>
					</thead>
					<tbody>
 
					@if(count($departments) > 0)
						@php $i = $departments->toArray()['from'];  @endphp
						
						@foreach($departments as $department)
						<tr>
							<td>{{ en2bn($i++) }}</td>
							<td>{{$department->department_name}}</td>
							<td>
								@if($department->status == 0)
								Inactive
								@elseif($department->status == 1)
								Active
								@else
								N/A
								@endif
							</td>
							<td class="action_buttons_style">
								<button  data-toggle="modal" data-target="#edit-designation-modal-{{$department->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button>
								@include('User::department.edit')
								<form action="{{ route('department.destroy',$department->id) }}" method="POST">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this department')" title="Delete"><i class="fa fa-trash-o"></i>Delete </button>
				 				</form>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
			@if(count($departments)>0)
				{{$departments->appends($_REQUEST)->render()}}
			@endif
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>

</div>
@include('User::department.create')
<script type="text/javascript">
	$(document).ready(function () {

		highlight_nav('department');
	});
</script>

@endsection