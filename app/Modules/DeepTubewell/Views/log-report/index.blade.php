@extends('main_layouts.app')

@section('content')
<div class="row animated zoomIn">
	@include('errorOrSuccess')
	<div class="col-md-12">
		@include('DeepTubewell::log-report.filter')
	</div>
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<!-- <i class="icon-settings font-green"></i> -->
					<span class="caption-subject bold uppercase">লগ রিপোর্ট</span>

				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="padding: 8px !important;">ক্রমিক নং</th>
							<th style="padding: 8px !important;">User</th>
							<th style="padding: 8px !important;">Module Name</th>
							<th style="padding: 8px !important;">Manu Name</th>
							<th style="padding: 8px !important;">Operation</th>
							<th style="padding: 8px !important;">Status</th>
							<th style="padding: 8px !important;">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($loginfos as $key=>$loginfo)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$loginfo->user->name}}</td>
								<td>{{$loginfo->module_name}}</td>
								<td>{{$loginfo->menu_name}}</td>
								<td>
									@if($loginfo->operation == 1)
									Insert
									@elseif($loginfo->operation == 2)
									Update
									@elseif($loginfo->operation == 3)
									Delete
									@endif
								</td>
								<td>
									@if($loginfo->status == 0)
									Inactive
									@elseif($loginfo->status == 1)
									Active
									@else
									N/A
									@endif
								</td>
								<td>
									 <a href="{{ route('log.destroy',$loginfo->id)}}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
							    </td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>

</div>


@endsection