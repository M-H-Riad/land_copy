@extends('main_layouts.app')

@section('content')

	@include('errorOrSuccess')
	<div class="row animated flipInX">

		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-green">
						<!-- <i class="icon-settings font-green"></i> -->
						<span class="caption-subject bold uppercase">Monthly Salary Generation

						</span>
					</div>
				</div>
				<div class="portlet-body">

					<div class="note note-success">
						<h4 class="block">{{$data->title}}
							@if($data->is_locked == 1 && !$data->send_alert && Auth::user()->can('send_salary_confirmation_alert') && config('app.salary_confirmation_alert') == true)
								<a href="{{route('payroll.salary_confirmation_alert',$data->id)}}" class="btn btn-lg red" onclick="return confirm('Are you sure to send salary confirmation alert?')"
								   style="float: right">
									<i class="fa fa-send"></i>
									Salary Confirmation Alert Send
								</a>
							@endif
						</h4>
						<p>{{($data->total_days)}} Days, Month: {{monthName($data->month)}}, Year: {{$data->year}}</p>

					</div>
					@if(!$data->is_locked && Auth::user()->can('generate_salary'))
						{!! Form::model($formData,['route' => ['payroll.generate'], 'method'=>'post','id' => 'generate-form']) !!}
						<div class="note note-info">

							<div class="row">
								<div class="well">
									<div class="row">

									</div>
									<div class="col-md-3">
										<h5>Bonus Allowance</h5>
										@foreach($bonus_settings as $bonus)
											<label>{{ Form::checkbox('festivals[]',$bonus->id,null) }} {{ $bonus->title }} </label><br>
										@endforeach
									</div>
									<div class="col-md-3">
										<h5>Others Allowance</h5>
										{{ Form::checkbox('dearness',1,null, ['id'=>'dearness']) }}
										{{ Form::label('dearness',' Dearness Allowance') }} <br/>
										<div class="input-group dearness_percentage" @if(isset($formData['dearness']) && $formData['dearness'] == 1)  @else style="display: none" @endif>
											<span class="input-group-addon">%</span>
											{{ Form::number('dearness_percent',isset($formData['dearness_percent']) ? $formData['dearness_percent'] : 100,['class'=>' form-control', 'style'=>'width:50%','step'=>'any']) }}
										</div>
									</div>
									<div class="col-md-3">
										<h5> Deduction</h5>
										{{ Form::checkbox('rev_stamp', 1, true, ['id'=>'rev_stamp','onClick="this.checked=!this.checked;"']) }}
										{{ Form::label('rev_stamp','Revenue Stamp') }} <br/>

										{{ Form::checkbox('one_day_salary',1,null, ['id'=>'one_day_salary']) }}
										{{ Form::label('one_day_salary') }} <br/>

									</div>

								</div>
							</div>
						</div>
					@endif

					<div class="note ">
						@if($data->generate_count == 0)
							<h5 class="block">
								Salary is not generated yet!
							</h5>
						@elseif($data->generate_count >= 1 && !$data->is_locked)
							<h5 class="block">
								Salary is generated {{$data->generate_count}} times.
								<span class="info">Please lock your salary sheet after confirming Salary.</span>
							</h5>
						@endif


						<input type="hidden" name="month_id" value="{{$data->id}}">
						@if(Auth::user()->can('generate_salary'))
							@if($data->waiting_job == 1 && $data->is_generated == 0)
								<div class="alert alert-info">
									<span class="">Status: {{$data->queue_status}}</span> <br/>
									Your Job is processing. It will take few minutes Based on Server resource/queue to be done. Please wait...
									or <a class=" text-danger" onclick="return confirm('Are you sure? Please reset if you are waiting more than 5 minutes in a same status!!')" href="{{route('payroll.reset', $data->id)}}"> <i class="fa fa-reset"></i> Click to Reset</a>
									(Not recommended)
								</div>
							@elseif($data->is_locked ==0)
								<button type="submit" class="btn btn-lg yellow" onclick="return confirm('Salary will generate now?')">
									<i class="fa fa-gear"></i>
									Generate Salary
								</button>
								{!! Form::close() !!}
							@endif
						@endif


						@if($data->generate_count >= 1 && $data->is_generated == 1)

							@if(!$data->is_locked && Auth::user()->can('confirm_salary'))
								<a href="{{route('payroll.lock',$data->id)}}" class="btn btn-lg red" onclick="return confirm('Are you sure to Confirm it?')">
									<i class="fa fa-check"></i>
									Confirm
								</a>
							@endif

							@if($data->is_generated == 1)
								<!-- @if( Auth::user()->can('download_department_report'))
									<a target="_blank" href="{{ asset('downloads/salary-reports/'.$data->title.'.pdf')}}" class="btn btn-lg blue">
										<i class="fa fa-file-pdf-o"></i> {{$data->title}} Salary Report Download PDF
									</a>
								@endif -->
								@if( Auth::user()->can('download_monthly_salary_csv'))
									<a target="_blank" href="{{route('payroll.download-csv',$data->id)}}" class="btn btn-lg blue" title="Salary {{$data->title}}  ">
										<i class="fa fa-file-excel-o"></i>
										{{$data->title}}  Salary Download CSV
									</a>
								@endif
								@if( Auth::user()->can('download_income_tax_summery_monthly'))
									<a target="_blank" href="{{route('income-tax-info.download',$data->id)}}" class="btn btn-lg blue" title="Salary {{$data->title}}  ">
										<i class="fa fa-file-pdf-o"></i>
										{{$data->title}}  Income Tax Summery PDF
									</a>
								@endif
								@if(isset($departmentGroups) &&  Auth::user()->can('download_bank_report_csv'))
									<br/>
									<br/>
									@foreach($departmentGroups as $group)
										<a target="_blank" href="{{route('payroll.download-bank-csv',[$data->id, $group->id])}}" class="btn btn-lg blue"  title="Download Bank Report of {{$group->group_name}}">
											<i class="fa fa-file-excel-o"></i>
											xlsx Bank Report of {{$group->group_name}}
										</a>
									@endforeach
								@endif
								@if(isset($departmentGroups) &&  Auth::user()->can('download_bank_report_pdf'))
									<br/>
									<br/>
									@foreach($departmentGroups as $group)
										<a target="_blank" href="{{route('payroll.download-bank-pdf',[$data->id, $group->id])}}" class="btn btn-lg blue"  title="Download Bank Report of {{$group->group_name}} PDF">
											<i class="fa fa-file-pdf-o"></i>
											PDF Bank Report of {{$group->group_name}}
										</a>
									@endforeach
								@endif
								<br><br>
								<div id="departmentsDropDown">
									@if( Auth::user()->can('download_bank_report_pdf'))
										<a onclick="myFunctionAdvice()" class="dropbtn btn btn-lg blue">Advice For Bank  <i class="fa fa-angle-down"></i></a>
										<a href="{{route('payroll.download-bank-pdf-wasa-drainage',$data->id)}}" class="dropbtn btn btn-lg blue" target="_blank"><i class="fa fa-file-pdf-o"></i> WASA & Drainage Bank Report PDF</a>
									@endif
									@if(Auth::user()->can('download_bank_report_csv'))
										<a href="{{route('payroll.download-bank-csv-wasa-drainage',$data->id)}}" class="dropbtn btn btn-lg blue" target="_blank"><i class="fa fa-file-pdf-o"></i> WASA & Drainage Bank Report xlsx</a>
									@endif
									@if( Auth::user()->can('download_bank_report_pdf'))
										<div id="myDropdownAdvice" class="dropdown-content" style="width: 25%">
											@foreach($departmentGroups as $group)
												<form action="{{route('payroll.advice-bank-pdf',[$data->id, $group->id])}}" target="_blank" method="get">
													<div class="row">
														<input type="date" name="date" class="col-md-6" required >
														<button  type="submit" class="btn btn-sm btn-success col-md-6">	<i class="fa fa-file-pdf-o"></i> {{$group->group_name}}</button>
													</div>
												</form>
												<br>
											@endforeach
											<a class="btn btn-lg" onclick="myFunctionAdvice()" style="border: none;">Hide</a>
										</div>
									@endif
								</div>

								@if(isset($festivalBonus) && $festivalBonus->count() > 0 && Auth::user()->can('download_festival_bonus_csv'))

									<br/>
									@foreach($festivalBonus as $festival)
										<a target="_blank" href="{{route('bonus.download-csv',$festival->id)}}" class="btn btn-lg blue" title="Festival Bonus {{$festival->title}}" style="margin-bottom: 10px">
											<i class="fa fa-file-excel-o"></i>
											{{$festival->title}} Bonus	Download CSV
										</a>
									@endforeach
								@endif
								<br/>
								@if(Auth::user()->can('download_total_summery'))

									<a target="_blank" href="{{route('payroll.download-summery-total',[$data->id])}}" class="btn btn-lg blue"  title="Summery of {{$data->title}}">
										<i class="fa fa-file-pdf-o"></i>
										Total Summery of {{$data->title}}
									</a>
								@endif
								@if(isset($departmentGroups) && Auth::user()->can('download_group_summery'))
									@foreach($departmentGroups as $group)
										<a target="_blank" href="{{route('payroll.download-summery',[$data->id, $group->id])}}" class="btn btn-lg blue"  title="Summery of {{$group->group_name}}">
											<i class="fa fa-file-pdf-o"></i>
											Summery of {{$group->group_name}}
										</a>
									@endforeach
								@endif
								<br/>
								<br/>

								<div id="departmentsDropDown">
									@if(Auth::user()->can('download_department_report'))
										<a onclick="myFunction()" class="dropbtn btn btn-lg blue"> Department Salary Report  <i class="fa fa-angle-down"></i></a>
									@endif
									@if(Auth::user()->can('download_all_department_summery'))
										<a target="_blank" href="{{route('payroll.download-all-department-summery',[$data->id])}}" class="btn btn-lg blue"  title="All Department Summery of {{$data->title}}">
											<i class="fa fa-file-pdf-o"></i>
											All Department Summery of {{$data->title}}
										</a>
									@endif
									@if(Auth::user()->can('download_department_report'))
										<div id="myDropdown" class="dropdown-content">
											<input type="text" placeholder="Search.." id="myInput" class="form-control focus_it" onkeyup="filterFunction()">

											@foreach($departments as $department)
												<a  target="_blank" href="{{route('payroll.download-report-department',[$data->id,$department->id])}}">	<i class="fa fa-file-pdf-o"></i> {{$department->department_name}}</a>
											@endforeach

											<a class="btn btn-lg" onclick="myFunction()" style="border: none;">Hide</a>
										</div>
									@endif
								</div>

							@endif
						@endif

					</div>
					@if($payrollEmployee->count() >0 )
						<div class="table-responsive">
							<h3 class="bg-danger">
								Negative salary generated employee list
							</h3>
							<table class="table table-bordered">
								<thead>
								<tr>
									<th>PFNO</th>
									<th>Name</th>
									<th>Department</th>
									<th>Gross Pay</th>
									<th>Deduction</th>
									<th>Net Payable</th>
								</tr>
								</thead>
								<tbody>
								@foreach($payrollEmployee as $row)
									<?php $empData = json_decode($row->employee_data); ?>
									<tr>
										<td> {{$empData->pfno}}</td>
										<td> {{$empData->name}}</td>
										<td> {{$empData->designation}}</td>
										<td> {{$row->gross_pay}}</td>
										<td> {{$row->total_ded}}</td>
										<td class="bg-danger"> {{$row->net_payable}}</td>
									</tr>
								@endforeach

								</tbody>
							</table>
						</div>

					@endif
				</div>

			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>

	</div>
	<style>
		.dropbtn {
			color: white;
			border: none;
			cursor: pointer;
		}

		.dropbtn:hover, .dropbtn:focus {
			background-color: #3e8e41;
		}



		#myInput:focus {outline: 3px solid #ddd;}

		.dropdown {
			position: relative;
			display: inline-block;
		}

		.dropdown-content {
			display: none;
			background-color: #f6f6f6;
			min-width: 230px;
			width: 200px;
			overflow: auto;
			border: 1px solid #ddd;
			z-index: 1;
		}

		.dropdown-content a {
			padding: 4px 0px;
			text-decoration: none;
			display: block;
			border-bottom: 1px solid;
		}

		.dropdown a:hover {background-color: #ddd;}

		.show {display: block;}
	</style>
	<script type="text/javascript">
		$(document).ready(function () {

			$('#nopagination').DataTable({
				"paging": false,
				"iDisplayLength": 25
			});

			highlight_nav('payroll');
		});

		$(function () {
			$('#dearness').on('change',function () {
				$('.dearness_percentage').toggle('fast');
			})
		});

		/* When the user clicks on the button,
        toggle between hiding and showing the dropdown content */
		function myFunction() {
			document.getElementById("myDropdown").classList.toggle("show");
		}
		function filterFunction() {
			var input, filter, ul, li, a, i;
			input = document.getElementById("myInput");
			filter = input.value.toUpperCase();
			div = document.getElementById("myDropdown");
			a = div.getElementsByTagName("a");
			for (i = 0; i < a.length; i++) {
				txtValue = a[i].textContent || a[i].innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					a[i].style.display = "";
				} else {
					a[i].style.display = "none";
				}
			}
		}
		function myFunctionAdvice() {
			document.getElementById("myDropdownAdvice").classList.toggle("show");
		}

	</script>
@endsection
