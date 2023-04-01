@extends('main_layouts.app')

@section('content')


	@include('errorOrSuccess')
	<div class="row animated zoomIn">

		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-green col-md-3">
						<!-- <i class="icon-settings font-green"></i> -->
						<span class="caption-subject bold uppercase">Monthly Salary </span>
					</div>

					<div class="actions col-md-9">

						<div class="row">
							@if(Auth::user()->can('salary_reconciliation'))
								{!! Form::open(array('route' =>'payroll.reconciliation','method' => 'post', 'id' => 'filter-form horizontal-form')) !!}
								<div class="col-md-2">
									{{ Form::select('to',$months,null, ['class' => 'form-control select2','placeholder'=>'Select Salary Month','required' ]) }}
								</div>
								<div class="col-md-2">
									<span class="caption-subject bold uppercase" style="color: white">Reconciliation With</span>

								</div>
								<div class="col-md-2">
									{{ Form::select('from',$months,null, ['class' => 'form-control select2','placeholder'=>'Select Salary Month','required']) }}
								</div>
								<div class="col-md-2">
									<button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-file-excel-o"></i> Download</button>
								</div>
								<div class="col-md-2">
									<a href="{{url('payroll')}}" class="btn btn-danger filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-times"></i> Refresh</a>
								</div>
								{!! Form::close() !!}
								<div class="col-md-2">
							@else
								<div class="col-md-2 col-md-offset-10">
							@endif

								@if(Auth::user()->can('create_payroll_month'))
									<button class="btn btn-square btn-sm red todo-bold" id="add-salary" data-toggle="modal" data-target="#add-salary-month">
										<i class="fa fa-plus"></i>
										Add Salary Month
									</button>
								@endif
							</div>
						</div>


						{{--@if(!Auth::user()->hasRole('pensionadmin'))--}}
						{{--<a href="{{route('payroll.create', \Request::all())}}" class="btn btn-primary btn-sm">--}}
						{{--<i class="fa fa-plus"></i>--}}
						{{--Add Monthly Salary--}}
						{{--</a>--}}


						{{--@endif--}}
					</div>
				</div>
				<div class="portlet-body">


					<table class="table table-striped table-bordered table-hover" id="nopagination">
						<thead>
						<tr>
							<th>S/N</th>
							<th>Salary Month</th>
							<th>Status</th>
							<th>Action</th>
						</tr>

						</thead>
						<tbody>
						@php $i = $data->toArray()['from'] @endphp
						@foreach($data as $row)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$row->title}}</td>
								<td>{!! $row->is_locked == 1?'<span class="text text-primary">Completed</span>':'<span class="text text-danger">Not Completed</span>' !!}</td>
								<td>
									<a class="btn btn-primary btn-sm mt-ladda-btn ladda-button" style=" padding: 5px;" data-style="zoom-in" href="{{ route('payroll.show',$row->id) }}">
                                    <span class="ladda-label">
                                        <i class="fa fa-folder-open"></i> Details
                                    </span>
									</a>
								</td>
							</tr>
						@endforeach
						</tbody>

					</table>
					@if(count($data)>0)
						{{$data->appends($_REQUEST)->render()}}
					@endif
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>

	</div>
	@include('Payroll::create')
	<script type="text/javascript">
		$(document).ready(function () {

			// $('#nopagination').DataTable({
			// 	"paging": false,
			// "bFilter": false,
			// "info": false,
			// 'sort' : false,
			// 	"iDisplayLength": 25
			// });

			highlight_nav('payroll');
		});
	</script>

@endsection