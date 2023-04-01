@extends('main_layouts.app')

@section('content')

    <div class="row employee-profile">
        @include('errorOrSuccess')
        <div class="row">
            <div class="col-md-9">
                @include('EmployeeProfile::info-left')
            </div>
            <div class="col-md-3">
                @include('EmployeeProfile::info-right')
            </div>
        </div>
        <div class="row">

        @if(Auth::user()->can('pension_fund_emp_view_only') && request('type')=='pension')
            <!-- BEGIN suspension -->
            @include('EmployeeProfile::show.pension_fund_emp')
            <!-- END suspension -->
            @endif


        </div>

    </div>

@endsection
@section('scripts')

    <script type="text/javascript">
        $('form').submit(function(){
            $(this).find('button[type=submit]').prop('disabled', true);
        });
        var site_path = "{{url('/')}}";
        highlight_nav('employee','manage-employee');

        $("#department_id").select2({
            allowClear: true,
            placeholder: 'Select Department'
        });

        function assignHOD() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var employee_id = $("#employee_id").val();
            var department_id = $("#department_id").val();
            if (department_id == null) {
                alert("Please select department first");
            } else {
                $.ajax({
                    url: "{{url('employee-profile/assign-hod')}}",
                    type: "post",
                    data: {
                        _token: CSRF_TOKEN,
                        employee_id: employee_id,
                        department_id: department_id
                    },
                    success: function (json_data) {
                        console.log(json_data);
                        var element = '';

                        $.each(json_data, function (index, value) {
                            element += '<li style="margin-bottom: 5px;">' + value + ' <button type="button" value="' + index + '"  onclick="removeHOD(this.value)"  class="btn btn-xs danger"><i class="fa fa-minus-circle"></i>' + '</button></li>';
                        });

                        $.each(department_id, function (index, value) {
                            $("#option_" + value).remove();
                        });

                        $("#assigned_hod").append(element);

                    },
                    error: function (data) {
                        alert("Something went wrong! Please reload and try again.");
                    }
                });
            }
        }

        function removeHOD(assignID) {
            var r = confirm("Are You Sure?");
            if (r == true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{url('employee-profile/remove-assign-hod')}}",
                    type: "post",
                    data: {
                        _token: CSRF_TOKEN,
                        assignID: assignID
                    },
                    success: function (json_data) {
                        console.log(json_data);
                        var element = '';

                        $.each(json_data, function (index, value) {
                            element += '<option id="option_' + index + '" value="' + index + '">' + value + '</option>';
                        });

                        $("#assign_" + assignID).remove();

                        $("#department_id").append(element);
                    },
                    error: function (data) {
                        alert("Something went wrong! Please reload and try again.");
                    }
                });
            }
        }
    </script>

    @if(request('type')=='pension')
    <script type="text/javascript">
        var site_path = "{{url('/')}}";
        highlight_nav('employee','pension-holder');
    </script>
    @endif
    <!--{{-- masud-suspension --}}-->

    <script src="{{URL::asset('custom/js/employee-profile-show.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('custom/js/location-list.js')}}" type="text/javascript"></script>

@endsection