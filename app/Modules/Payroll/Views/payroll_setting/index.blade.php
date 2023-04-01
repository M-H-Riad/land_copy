@extends('main_layouts.app')

@section('content')

	<div class="row animated flipInX">

		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-green">
						<!-- <i class="icon-settings font-green"></i> -->
						<span class="caption-subject bold uppercase">Filter</span>
					</div>
				</div>
				<div class="portlet-body">
					@include('errorOrSuccess')
					{!! Form::open(array('method' => 'get', 'id' => 'filter-form')) !!}

					<div class="col-md-12 side-padding-none">
						<div class="col-md-3" style="margin-bottom:5px;">
							{!! Form::select('payroll_head_id_s',$payroll_heads,request('payroll_head_id_s'), ['class' => 'form-control select2', 'id' => 'payroll_head_id_s','placeholder' => 'All Head','style' => 'width:100%']) !!}
						</div>
						<div class="col-md-3" style="margin-bottom:5px;">
							{!! Form::select('grade_s',$grades,request('grade_s'), ['class' => 'form-control select2', 'id' => 'grade_s','placeholder' => 'Select Grade','style' => 'width:100%']) !!}
						</div>
						<div class="col-md-3" style="margin-bottom:5px;">
							{!! Form::text('basic_pay_s',null, ['class' => 'form-control focus_it','placeholder' => 'Basic Pay']) !!}
						</div>

						<div class="col-md-1">
							<button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-search"></i> Filter</button>
						</div>


						<div class="clearfix"></div>
					</div>



					{!! Form::close() !!}


				</div>

			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>

	</div>

	<div class="row animated zoomIn">

		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-green">
						<!-- <i class="icon-settings font-green"></i> -->
						<span class="caption-subject bold uppercase">Payroll Head Setting</span>

					</div>
					<div class="actions">
						@if(Auth::user()->can('payroll_setting_create'))
							<button data-toggle="modal" data-target="#add-payroll_setting-modal" type="button" class="btn btn-success bnt-lg"><i class="fa fa-plus"></i> Add</button>
						@endif
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover" id="nopagination">
						<thead>
						<tr>
							<th style="padding: 8px !important;">Head</th>
							<th style="padding: 8px !important;">Basic Pay</th>
							<th style="padding: 8px !important;">Grade</th>
							<th style="padding: 8px !important;">Rate/Amount</th>
							<th style="padding: 8px !important;">Minimum</th>
							<th style="padding: 8px !important;">Maximum</th>
							<th style="padding: 8px !important;">Fixed</th>
							<th style="padding: 8px !important;">Special Flag</th>
							<th style="padding: 8px !important;">Comments</th>
							<th style="padding: 8px !important;">Status</th>
							<th style="padding: 8px !important;">Action</th>
						</tr>
						</thead>
						<tbody>
						@if(count($payroll_settings) > 0)
							@foreach($payroll_settings as $payroll_setting)
								<tr>
									<td>{{$payroll_setting->payroll_head->title or ''}}</td>
									<td>{{$payroll_setting->basic_pay}}</td>
									<td>
										{{$payroll_setting->grade or ''}}
										@if($payroll_setting->grade_max>0) - {{$payroll_setting->grade_max}} @endif
									</td>
									<td>{{$payroll_setting->rate}}</td>
									<td>{{$payroll_setting->min}}</td>
									<td>{{$payroll_setting->max}}</td>
									<td>
										@if($payroll_setting->is_fixed == 1)
											Fixed
										@else
											Percentage
										@endif
									</td>
									<td>

										@if($payroll_setting->ref_id == 0)

										@elseif($payroll_setting->ref_id == 1)
											Dhaka
										@elseif($payroll_setting->ref_id == 2)
											Narayanganj
										@else
											Others
										@endif
									</td>
									<td>{{$payroll_setting->comments}}</td>
									<td>
										@if($payroll_setting->active == 0)
											Inactive
										@elseif($payroll_setting->active == 1)
											Active
										@else
											N/A
										@endif
									</td>
									<td>
										@if(Auth::user()->can('payroll_setting_update'))
											<button  data-toggle="modal" data-target="#edit-payroll_setting-modal-{{$payroll_setting->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
											@include('Payroll::payroll_setting.edit')
										@endif
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
	@include('Payroll::payroll_setting.create')
	<script type="text/javascript">
		$(document).ready(function () {

			$('#nopagination').DataTable({
				"paging": true,
				"bFilter": true,
				"info": true,
				"sort": false,
				"pageLength": 25,
				"iDisplayLength": 25
			});

			highlight_nav('payroll_setting');
		});
	</script>

@endsection