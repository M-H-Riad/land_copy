@extends('main_layouts.app')

@section('content')

	@include('errorOrSuccess')
	<div class="row animated flipInX">

		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-green col-md-2 ">
						<!-- <i class="icon-settings font-green"></i> -->
						<span class="caption-subject bold uppercase">Overtime Generation

						</span>
					</div>
					<div class=" actions col-md-2 side-padding-none">
						@if(Auth::user()->can('create_overtime'))
							<a href="{{ route('overtime.create') }}" class="btn red" style="width: 100%">
								<i class="fa fa-plus"></i>Create Overtime
							</a>
						@endif
					</div>
				</div>
				<div class="portlet-body">
					<div class="note note-success" style=" margin: 0px;">
						<h4 class="block">{{$overtime->title}}</h4>
						{{--						<p> <strong>Memo No:</strong>{{$overtime->memo_no}} | <strong>Bank Account Number:</strong>{{$overtime->bank_account_number}} | <strong>Void Date:</strong>{{ date('d M, Y',strtotime( $overtime->void_date))}}</p>--}}

					</div>

					<div class="note " style=" margin: 0px;">

						<div class="row">


{{--							@if(Auth::user()->can('re_generate_overtime'))--}}
{{--								<div class="col-md-12">--}}
{{--									<br>--}}
{{--									{!! Form::open(array('route' =>'overtime.store','method' => 'post', 'class' => 'from-control','files'=>True)) !!}--}}
{{--									<table class="table  dt-responsive" class="nopagination" width="100%">--}}

{{--										<tbody>--}}
{{--										<tr>--}}
{{--											<td >--}}
{{--												{!! Form::select('department_id',$departments,request('department_id'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select Department','style' => 'width:100%','required']) !!}--}}
{{--											</td>--}}
{{--											<td>--}}
{{--												{{ Form::text('bank_account_number','CD-200040491', ['class' => 'form-control', 'id' => 'bank_account_number','placeholder'=>'Bank Account Number','required']) }}--}}
{{--											</td>--}}
{{--											<td>--}}
{{--												{{ Form::text('memo_no','46.113.317.00.00.'.date('Y').'/', ['class' => 'form-control', 'id' => 'memo_no','placeholder'=>'Memo No','required']) }}</td>--}}
{{--											<td>--}}

{{--												<input type="file" name="file" class="form-control"  id="file" accept=".xls,.xlsx,.csv" required>--}}
{{--												<input type="hidden" name="month" class="form-control" value="{{$overtime->month}}"  >--}}
{{--												<input type="hidden" name="year" class="form-control" value="{{$overtime->year}}"  >--}}
{{--											</td>--}}

{{--											<td>--}}
{{--												<button type="submit" class="btn btn-lg yellow" onclick="return confirm('{{$overtime->title}} overtime will generate now?')">--}}
{{--													<i class="fa fa-gear"></i>--}}
{{--													Generate Overtime--}}
{{--												</button>--}}
{{--											</td>--}}
{{--											<td class="text-center">--}}
{{--												<a href="{{ route('overtime.create') }}" class="btn red">--}}
{{--													<i class="fa fa-plus"></i>--}}
{{--													Create Overtime--}}
{{--												</a>--}}
{{--												@if( Auth::user()->can('download_overtime_department_report'))--}}
{{--													<a class="btn btn-primary" target="_blank" href="{{route('overtime.download-report-department',[$overtime->id])}}">	<i class="fa fa-file-pdf-o"></i> All Department Overtime Sheet</a>--}}
{{--												@endif--}}
{{--											</td>--}}
{{--										</tr>--}}
{{--										</tbody>--}}

{{--									</table>--}}

{{--									{!! Form::close() !!}--}}
{{--								</div>--}}
{{--							@endif--}}

							<div class="col-md-12">
								<table class="table table-striped table-bordered table-hover" id="nopagination">
									<thead>
									<tr>
										<th>S/N</th>
										<th>Department</th>
										<th>Memo No</th>
										<th>Bank Account Number</th>
										<th>Status</th>
										<th class="text-center">Action</th>
									</tr>

									</thead>
									<tbody>

									@foreach($overtime_department as $indexKey => $row)
										<tr>
											<td>{{++$indexKey}}</td>
											<td>{{ $row->title}}</td>
											<td>{{ $row->memo_no}}</td>
											<td>{{ $row->bank_account_number }}</td>
											<td>
												{!! $row->is_locked == 1?'<span class="text text-primary">Completed</span>':'<span class="text text-danger">Not Completed</span>' !!}
												@if($row->generate_count >= 1 && !$row->is_locked)
													Generated {{$row->generate_count}} times.
												@endif
												@if($row->waiting_job == 1 && $row->is_generated == 0  && Auth::user()->can('create_overtime'))
													<br>Your Job is processing....
												@endif
											</td>
											<td class="text-center">
												@if($row->waiting_job == 1 && $row->is_generated == 0  && Auth::user()->can('create_overtime'))
													<a class=" text-danger" onclick="return confirm('Are you sure? Please reset if you are waiting more than 5 minutes in a same status!!')" href="{{route('overtime.reset', $row->id)}}"> <i class="fa fa-reset"></i> Click to Reset</a>
													(Not recommended)
												@else
													@if($row->is_locked == 0 && Auth::user()->can('edit_overtime'))
														<button  data-toggle="modal" data-target="#edit-modal-{{$row->id}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
														@include('Payroll::overtime.edit')
													@endif
												@endif

												@if($row->generate_count >= 1 && $row->is_generated == 1)
													@if($row->is_generated == 1)

														@if(!$row->is_locked  && Auth::user()->can('confirm_overtime'))
															<a href="{{route('overtime.lock',$row->id)}}" class="btn btn-lg red" onclick="return confirm('Are you sure to Confirm it?')">
																<i class="fa fa-check"></i>
																Confirm Overtime
															</a>
														@endif
														@if( Auth::user()->can('download_overtime_department_report'))
																<form action="{{route('overtime.download-report-department',[$row->overtime_id,$row->department_id])}}" target="_blank" method="get">
																	<div class="" style="padding: 5px">
																		<input type="date" name="date" required>
																		<button  type="submit" class="btn btn-sm btn-primary ">	<i class="fa fa-file-pdf-o"></i> Download PDF</button>
																	</div>
																</form>
{{--															<a class="btn btn-primary" target="_blank" href="{{route('overtime.download-report-department',[$row->overtime_id,$row->department_id])}}">	<i class="fa fa-file-pdf-o"></i> Download PDF</a>--}}
															<a class="btn btn-primary" target="_blank" href="{{route('overtime.download-report-department-xlxs',[$row->overtime_id,$row->department_id])}}">	<i class="fa fa-file-excel-o"></i> Download xlxs for Bank</a>

														@endif
													@endif
												@endif

											</td>
										</tr>
									@endforeach
									</tbody>

								</table>

							</div>

						</div>
					</div>
				</div>

			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>

	</div>
	<script type="text/javascript">
		$(document).ready(function () {

			$('#nopagination').DataTable({
				"paging": false,
				"iDisplayLength": 25
			});

			highlight_nav('overtime');
		});
	</script>

@endsection
