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
					<span class="caption-subject bold uppercase">Salary Increment </span>
				</div>

			</div>
			<div class="portlet-body">


				<table class="table table-striped table-bordered table-hover" id="nopagination">
					<thead>
						<tr>
							<th>S/N</th>
							<th>Title</th>
							<th>Status</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>

					@foreach($payrollSalaryIncrements as $indexKey => $row)
						<tr>
							<td>{{++$indexKey}}</td>
							<td>Salary Increment {{$row->year}}</td>
							<td>{{$row->status}}</td>
							<td>
								@if($row->is_locked != 1)
								<a class="  @if($row->ready_for_generate == 0 )btn btn-primary @else  btn btn-info  @endif btn-sm mt-ladda-btn ladda-button" style=" padding: 5px;" data-style="zoom-in" href="{{ route('salary-increment',$row->id) }}" onclick="return confirm('Are you confirm to do this ?')">
                                    <span class="ladda-label">
                                       @if($row->ready_for_generate == 0 )  Confirm Increment {{$row->year}} @else  Increment Now  @endif
                                    </span>
								</a>
								@endif
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

<script type="text/javascript">
	$(document).ready(function () {

		$('#nopagination').DataTable({
			"paging": false,
//			"bFilter": false,
// 			"info": false,
// 			'sort' : false,
            "iDisplayLength": 25
		});

		highlight_nav('salary_increments');
	});
</script>

@endsection