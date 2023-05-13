@extends('layouts.app_new')

@section('content')
<style>
    .help-block{
        color:red !important;
    }
    .text-danger{
        color:red !important;
    }
    .has-error .control-label{
        color:red !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register-create') }}" id="user_entry">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name (Eng) <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"  autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last Name (Eng) <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('first_name_ban') ? ' has-error' : '' }}">
                            <label for="first_name_ban" class="col-md-4 control-label">First Name (Ban)</label>

                            <div class="col-md-6">
                                <input id="first_name_ban" type="text" class="form-control" name="first_name_ban" value="{{ old('first_name_ban') }}"  autofocus>

                                @if ($errors->has('first_name_ban'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name_ban') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name_ban') ? ' has-error' : '' }}">
                            <label for="last_name_ban" class="col-md-4 control-label">Last Name (Bng)</label>

                            <div class="col-md-6">
                                <input id="last_name_ban" type="text" class="form-control" name="last_name_ban" value="{{ old('last_name_ban') }}"  autofocus>

                                @if ($errors->has('last_name_ban'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name_ban') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pf_no') ? ' has-error' : '' }}">
                            <label for="pf_no" class="col-md-4 control-label">PF No</label>

                            <div class="col-md-6">
                                <input id="pf_no" type="text" class="form-control" name="pf_no" value="{{ old('pf_no') }}" autofocus>

                                @if ($errors->has('pf_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pf_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('office_id') ? ' has-error' : '' }}">
                            <label for="office_id" class="col-md-4 control-label">Office Id <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="office_id" type="text" class="form-control" name="office_id" value="{{ old('office_id') }}" placeholder="Enter Office ID" autofocus>

                                @if ($errors->has('office_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('office_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                            <label for="department_id" class="col-md-4 control-label">Department <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select name="department_id" class="form-control select2">
                                    <option value="">---Select a department---</option>
                                     @foreach($departments as $department)
                                        <option value="{{$department->id}}">{{$department->department_name}}</option>
                                     @endforeach
                                </select>

                                @if ($errors->has('department_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('department_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="department_id" class="col-md-4 control-label">Phone <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('designation_id') ? ' has-error' : '' }}">
                            <label for="designation_id" class="col-md-4 control-label">Designation <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select name="designation_id" class="form-control select2">
                                    <option value="">---Select a designation---</option>
                                    @foreach($designations as $designation)
                                        <option value="{{$designation->id}}">{{$designation->title}}</option>
                                     @endforeach
                                </select>

                                @if($errors->has('designation_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('designation_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="pswd" class="col-md-4 control-label">Password <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="pswd" type="password" class="form-control" placeholder="Enter Password" name="password">
                                <span id="password_error" class="text-danger"></span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Enter Confirm Password">
                                <span id="password_match" style="display:none;color:red;">Password and confirm password Didn't match !!</span>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" class="btn btn-primary" id="form_submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->

<script> 

     $('#pswd').keyup(function(e){
        $("#password_error").html("Please give at least six length password. At least give One upper case, one lower case letter, one special character and one number"); 
     });
     $('#form_submit').click(function(){
         var password = $('#pswd').val();
         var confirm_password = $('#password-confirm').val();
         if(password==confirm_password){
            $('#password_match').hide();
            $("#user_entry").submit();
         }else{
             $('#password_match').show();
         }
     });


</script>
@endsection
