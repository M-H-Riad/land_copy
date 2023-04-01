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
							{!! Form::select('festival',$settings,request('festival'), ['class' => 'form-control select2', 'id' => 'slug','placeholder' => 'Select festival','style' => 'width:100%']) !!}
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
						<span class="caption-subject bold uppercase">Festival Bonus Setting</span>

					</div>
					<div class="actions">
						@if(Auth::user()->can('bonus_setting_create'))
							<button data-toggle="modal" data-target="#add-bonus_setting-modal" type="button" class="btn btn-success bnt-lg"><i class="fa fa-plus"></i> Add</button>
						@endif
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover" id="nopagination">
						<thead>
						<tr>
							<th style="padding: 8px !important;">Festival</th>
							<th style="padding: 8px !important;">Religion </th>
							<th style="padding: 8px !important;">Percentage </th>
							<th style="padding: 8px !important;">Status</th>
							<th style="padding: 8px !important;">Action</th>
						</tr>
						</thead>
						<tbody>
						@if(count($bonus_settings) > 0)
							@foreach($bonus_settings as $bonus_setting)
								<tr>
									<td>{{$bonus_setting->title or ''}}</td>
									<td>{{$bonus_setting->bonus_for}}</td>
									<td>{{$bonus_setting->percentage}}</td>
									<td>{{ ucfirst($bonus_setting->status)}}</td>

									<td>
										@if(Auth::user()->can('bonus_setting_update'))
											<button  data-toggle="modal" data-target="#edit-bonus_setting-modal-{{$bonus_setting->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
											@include('Payroll::bonus_setting.edit')
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
	@include('Payroll::bonus_setting.create')
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

			highlight_nav('bonus_setting');
		});
	</script>

@endsection