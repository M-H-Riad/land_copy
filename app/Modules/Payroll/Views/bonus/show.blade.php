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
                        <span class="caption-subject bold uppercase">Festival Bonus Generation

						</span>
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="note note-success">
                        <h4 class="block">{{$bonus->title}}</h4>
                        <p> Month: {{monthName($bonus->month)}}, Year: {{$bonus->year}}</p>

                    </div>
                    <div class="note ">
                        @if($bonus->payroll_month_id > 0 || $bonus->payroll_month_id != null)
                            @php
                                $salaryMonth = \App\Modules\Payroll\Models\PayrollMonth::where('id',$bonus->payroll_month_id)->first();
                            @endphp
                            <h5 class="block bg-warning" >

                                This Festival Bonus is generated from {{ $salaryMonth->title }} Salary.
                                @if(!$bonus->is_locked)
                                    <span class="info">This festival bonus sheet is lock after confirming <a href="{{ route('payroll.show',$salaryMonth->id) }}" class="btn btn-danger" target="_blank">{{ $salaryMonth->title }}</a>  salary.</span>
                                @endif
                            </h5>

                        @else
                            {!! Form::open(array('route' =>'bonus.generate','method' => 'post', 'id' => 'generate-form')) !!}
                            <input type="hidden" name="bonus_id" value="{{$bonus->id}}">
                            <div class="note note-info" style="border-left: none;">

                                <div class="well">
                                    <div class="col-md-3">
                                        <h5> Deduction</h5>
                                        {{ Form::checkbox('rev_stamp', 1, true, ['id'=>'rev_stamp','onClick="this.checked=!this.checked;"']) }}
                                        {{ Form::label('rev_stamp','Revenue Stamp') }} <br/>
                                    </div>
                                </div>

                            </div>
                            <h5 class="block">
                                @if($bonus->generate_count == 0)
                                    Festival Bonus is not generated yet!
                                @elseif($bonus->generate_count >= 1 && !$bonus->is_locked)
                                    Festival Bonus is generated {{$bonus->generate_count}} times.
                                    <span class="info">Please lock your festival bonus sheet after confirming bonus.</span>
                                @endif
                            </h5>


                            @if($bonus->waiting_job == 1 && $bonus->is_generated == 0)
                                <div class="alert alert-info">
                                    <span class="">Status: {{$bonus->queue_status}}</span> <br/>
                                    Your Job is processing. It will take few minutes Based on Server resource/queue to be done. Please wait...
                                    or <a class=" text-danger" onclick="return confirm('Are you sure? Please reset if you are waiting more than 5 minutes in a same status!!')" href="{{route('bonus.reset', $bonus->id)}}"> <i class="fa fa-reset"></i> Click to Reset</a>
                                    (Not recommended)
                                </div>
                            @elseif($bonus->is_locked == 0)
                                <button type="submit" class="btn btn-lg yellow" onclick="return confirm('{{$bonus->title}} bonus will generate now?')">
                                    <i class="fa fa-gear"></i>
                                    Generate Bonus
                                </button>
                                <br>
                            @endif
                            {!! Form::close() !!}
                        @endif

                        @if($bonus->generate_count >= 1 && $bonus->is_generated == 1)
                                <br/>
                            @if(!$bonus->is_locked && ( $bonus->payroll_month_id < 1 ||  $bonus->payroll_month_id == null ) && Auth::user()->can('confirm_salary'))
                                <a href="{{route('bonus.lock',$bonus->id)}}" class="btn btn-lg red" onclick="return confirm('Are you sure to Confirm it?')">
                                    <i class="fa fa-check"></i>
                                    Confirm
                                </a>
                            @endif

                            @if($bonus->is_generated == 1)
                                @if(Auth::user()->can('download_festival_bonus_csv'))
                                    <a target="_blank" href="{{route('bonus.download-csv',$bonus->id)}}" class="btn btn-lg blue" title="Festival Bonus {{$bonus->title}}">
                                        <i class="fa fa-file-excel-o"></i>
                                        {{$bonus->title}} Bonus	Download CSV
                                    </a>
                                    <br/>
                                    <br/>
                                @endif
                                @if( $bonus->payroll_month_id < 1 ||  $bonus->payroll_month_id == null )
                                    @if(isset($departmentGroups) &&  Auth::user()->can('download_bank_report_csv'))
                                        @foreach($departmentGroups as $group)
                                            <a target="_blank" href="{{route('bonus.download-bank-csv',[$bonus->id, $group->id])}}" class="btn btn-lg blue"  title="Download Bank Report of {{$group->group_name}}">
                                                <i class="fa fa-file-excel-o"></i>
                                                xlsx Bank Report of {{$group->group_name}}
                                            </a>
                                        @endforeach
                                    @endif

                                    @if(isset($departmentGroups) &&  Auth::user()->can('download_bank_report_pdf'))
                                        <br><br>

                                        @foreach($departmentGroups as $group)
                                            <a target="_blank" href="{{route('bonus.download-bank-pdf',[$bonus->id, $group->id])}}" class="btn btn-lg blue"  title="Download Bank Report of {{$group->group_name}}">
                                                <i class="fa fa-file-excel-o"></i>
                                                PDF Bank Report of {{$group->group_name}}
                                            </a>
                                        @endforeach
                                    @endif

                                    <br><br>
                                    <div id="departmentsDropDown">
                                        @if( Auth::user()->can('download_bank_report_pdf'))
                                            <a onclick="myFunctionAdvice()" class="dropbtn btn btn-lg blue">Advice For Bank  <i class="fa fa-angle-down"></i></a>
                                            <a href="{{route('bonus.download-bank-pdf-wasa-drainage',$bonus->id)}}" class="dropbtn btn btn-lg blue" target="_blank"><i class="fa fa-file-pdf-o"></i> WASA & Drainage Bank Report PDF</a>
                                        @endif
                                        @if(Auth::user()->can('download_bank_report_csv'))
                                            <a href="{{route('bonus.download-bank-csv-wasa-drainage',$bonus->id)}}" class="dropbtn btn btn-lg blue" target="_blank"><i class="fa fa-file-pdf-o"></i> WASA & Drainage Bank Report xlsx</a>
                                        @endif
                                        @if( Auth::user()->can('download_bank_report_pdf'))
                                            <div id="myDropdownAdvice" class="dropdown-content" style="width: 25%">
                                                @foreach($departmentGroups as $group)
                                                    <form action="{{route('bonus.advice-bank-pdf',[$bonus->id, $group->id])}}" target="_blank" method="get">
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

                                    <br>
                                @endif
                                @if(Auth::user()->can('download_total_summery'))

                                    <a target="_blank" href="{{route('bonus.download-summery-total',[$bonus->id])}}" class="btn btn-lg blue"  title="Summery of {{$bonus->title}}">
                                        <i class="fa fa-file-pdf-o"></i>
                                        Total Summery of {{$bonus->title}}
                                    </a>
                                @endif
                                @if(isset($departmentGroups) && Auth::user()->can('download_group_summery'))
                                    @foreach($departmentGroups as $group)
                                        <a target="_blank" href="{{route('bonus.download-summery',[$bonus->id, $group->id])}}" class="btn btn-lg blue"  title="Summery of {{$group->group_name}}">
                                            <i class="fa fa-file-excel-o"></i>
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
                                        <a target="_blank" href="{{route('bonus.download-all-department-summery',[$bonus->id])}}" class="btn btn-lg blue"  title="All Department Summery of {{$bonus->title}}">
                                            <i class="fa fa-file-pdf-o"></i>
                                            All Department Summery of {{$bonus->title}}
                                        </a>
                                    @endif
                                    @if(Auth::user()->can('download_department_report'))
                                        <div id="myDropdown" class="dropdown-content">
                                            <input type="text" placeholder="Search.." id="myInput" class="form-control focus_it" onkeyup="filterFunction()">

                                            @foreach($departments as $department)
                                                <a  target="_blank" href="{{route('bonus.download-report-department',[$bonus->id,$department->id])}}">	<i class="fa fa-file-pdf-o"></i> {{$department->department_name}}</a>
                                            @endforeach

                                            <a class="btn btn-lg" onclick="myFunction()" style="border: none;">Hide</a>
                                        </div>
                                    @endif
                                </div>


                            @endif
                        @endif

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

            highlight_nav('bonus');
        });
    </script>
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
    <script>
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
