@extends('main_layouts.app')

@section('content')


@include('errorOrSuccess')
<div class="row animated zoomIn">

	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<!-- <i class="icon-settings font-green"></i> -->
					<span class="caption-subject bold uppercase">Festival Bonus</span>
				</div>

				<div class="actions">
					<button class="btn btn-square btn-sm red todo-bold" id="add-salary" data-toggle="modal" data-target="#add-salary-month">
						<i class="fa fa-plus"></i>
						Add Festival Bonus Month
					</button>
					{{--@endif--}}
				</div>
			</div>
			<div class="portlet-body">


				<table class="table table-striped table-bordered table-hover" id="nopagination">
					<thead>
						<tr>
							<th>S/N</th>
							<th>Festival Bonus</th>
							<th>Status</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
					@php $i = $bonuses->toArray()['from'] @endphp
					@foreach($bonuses as $row)
						<tr>
							<td>{{$i++}}</td>
							<td>{{$row->title}}</td>
							<td>{!! $row->is_locked == 1?'<span class="text text-primary">Completed</span>':'<span class="text text-danger">Not Completed</span>' !!}</td>
							<td>
								<a class="btn btn-primary btn-sm mt-ladda-btn ladda-button" style=" padding: 5px;" data-style="zoom-in" href="{{ route('bonus.show',$row->id) }}">
                                    <span class="ladda-label">
                                        <i class="fa fa-folder-open"></i> Details
                                    </span>
								</a>
								@if($row->bonus_type == 0)
									<button  data-toggle="modal" data-target="#edit-bonus-modal-{{$row->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
									@include('Payroll::bonus.edit')
								@endif
							</td>
						</tr>
					@endforeach
					</tbody>

				</table>
				@if(count($bonuses)>0)
					{{$bonuses->appends($_REQUEST)->render()}}
				@endif
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>

</div>
 @include('Payroll::bonus.create')
<script type="text/javascript">
	$(document).ready(function () {

// 		$('#nopagination').DataTable({
// 			"paging": false,
// //			"bFilter": false,
// // 			"info": false,
// // 			'sort' : false,
//             "iDisplayLength": 25
// 		});

		highlight_nav('bonus');
	});
</script>

@endsection