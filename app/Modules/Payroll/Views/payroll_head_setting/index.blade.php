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
						{!! Form::select('payroll_head_id_s',$payroll_heads,request('payroll_head_id_s'), ['class' => 'form-control select2', 'id' => 'payroll_head_id_s','placeholder' => 'Select Head','style' => 'width:100%']) !!}
					</div>
					<div class="col-md-3" style="margin-bottom:5px;">
						{!! Form::text('amount_s',null, ['class' => 'form-control focus_it','placeholder' => 'Amount']) !!}
					</div>
				{{-- 	<div class="col-md-3" style="margin-bottom:5px;">
						{{ Form::selectMonth('end_month',null, ['class' => 'form-control','placeholder'=>'Select Month','style'=>'width:100% !important;' ]) }}
					</div>
					<div class="col-md-3" style="margin-bottom:5px;">
						{{ Form::selectYear('start_year',date('Y'),2018,null, ['class' => 'form-control','placeholder'=>'Select Year']) }}
					</div> --}}
					<div class="col-md-3" style="margin-bottom:5px;">
						{!! Form::select('type_s',$types,request('type_s'), ['class' => 'form-control select2', 'id' => 'type_s','placeholder' => 'Select Type','style' => 'width:100%']) !!}
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
				<button data-toggle="modal" data-target="#add-payroll_head_setting-modal" type="button" class="btn btn-success bnt-lg pull-right"><i class="fa fa-plus"></i> Add</button>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="nopagination">
					<thead>
						<tr>
							<th style="padding: 8px !important;">Head</th>
							<th style="padding: 8px !important;">Amount</th>
							<th style="padding: 8px !important;">Type</th>
							<th style="padding: 8px !important;">Start</th>
							<th style="padding: 8px !important;">End</th>
							<th style="padding: 8px !important;">Status</th>
							<th style="padding: 8px !important;">Action</th>
						</tr>
					</thead>
					<tbody>
						@if(count($payroll_head_settings) > 0)
						@foreach($payroll_head_settings as $payroll_head_setting)
						<tr>
							<td>{{$payroll_head_setting->payroll_head->title or ''}}</td>
							<td>{{$payroll_head_setting->amount}}</td>
							<td>{{$payroll_head_setting->type}}</td>
							<td>
								Month : {{$payroll_head_setting->start_month}} <br>
								Year : {{$payroll_head_setting->start_year}}
							</td>
							<td>
								Month : {{$payroll_head_setting->end_month}} <br>
								Year : {{$payroll_head_setting->end_year}}
							</td>
							<td>
								@if($payroll_head_setting->status == 0)
								Inactive
								@elseif($payroll_head_setting->status == 1)
								Active
								@else
								N/A
								@endif
							</td>
							<td>
								<button  data-toggle="modal" data-target="#edit-payroll_head_setting-modal-{{$payroll_head_setting->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
								@include('Payroll::payroll_head_setting.edit')
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
@include('Payroll::payroll_head_setting.create')
<script type="text/javascript">
	$(document).ready(function () {

		$('#nopagination').DataTable({
			"paging": true,
			"bFilter": true,
			"info": true,
                        "iDisplayLength": 25
		});

		highlight_nav('payroll_head_setting');
	});
</script>

@endsection