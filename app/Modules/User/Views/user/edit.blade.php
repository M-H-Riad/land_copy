@extends('main_layouts.app')

@section('content')

<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
  <li>
    <a href="{{ url('/') }}">Home</a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    <a href="{{ url('/role') }}">User</a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    <span class="active">Update</span>
  </li>
</ul>
@if (session('error'))
<div class="alert alert-danger">
    <p>{{session('error')}}</p>
</div>
@endif
<!-- END PAGE BREADCRUMB -->

<div class="row">
  <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
          <div class="panel-heading">Update User Information</div>

          <div class="panel-body">
              <form class="form-horizontal" method="POST" action="{{ route('update-user',$user->id)}}">
                  {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                      <label for="first_name" class="col-md-4 control-label">First Name (Eng)*</label>

                      <div class="col-md-6">
                          <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $user->first_name_eng}}"  autofocus>

                          @if ($errors->has('first_name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('first_name') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                      <label for="last_name" class="col-md-4 control-label">Last Name (Eng)*</label>

                      <div class="col-md-6">
                          <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name_eng}}" autofocus>

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
                          <input id="first_name_ban" type="text" class="form-control" name="first_name_ban" value="{{ $user->first_name_ban}}"  autofocus>

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
                          <input id="last_name_ban" type="text" class="form-control" name="last_name_ban" value="{{ $user->last_name_ban}}"  autofocus>

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
                          <input id="pf_no" type="text" class="form-control" name="pf_no" value="{{$user->pf_no}}" autofocus>

                          @if ($errors->has('pf_no'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('pf_no') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('office_id') ? ' has-error' : '' }}">
                      <label for="office_id" class="col-md-4 control-label">Office Id *</label>

                      <div class="col-md-6">
                          <input id="office_id" type="text" class="form-control" name="office_id" value="{{$user->office_id}}" autofocus>

                          @if ($errors->has('office_id'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('office_id') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                    <label for="department_id" class="col-md-4 control-label">Department *</label>

                    <div class="col-md-6">
                        <select name="department_id" class="form-control select2">
                            <option value="">---Select a department---</option>
                             @foreach($departments as $department)
                                <option value="{{$department->id}}" {{($user->department_id == $department->id)?'selected':''}}>{{$department->department_name}}</option>
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
                      <label for="department_id" class="col-md-4 control-label">Phone *</label>

                      <div class="col-md-6">
                          <input id="phone" type="text" class="form-control" name="phone" value="{{$user->phone}}" autofocus>

                          @if ($errors->has('phone'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('phone') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('designation_id') ? ' has-error' : '' }}">
                    <label for="designation_id" class="col-md-4 control-label">Designation *</label>

                    <div class="col-md-6">
                        <select name="designation_id" class="form-control select2">
                            <option value="">---Select a designation---</option>
                            @foreach($designations as $designation)
                                <option value="{{$designation->id}}" {{($user->designation_id == $designation->id)?'selected':''}}>{{$designation->title}}</option>
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
                      <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                      <div class="col-md-6">
                          <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">

                          @if ($errors->has('email'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <label for="pswd" class="col-md-4 control-label">Password</label>

                      <div class="col-md-6">
                          <input id="pswd" type="password" class="form-control" name="password" placeholder="Enter Password">
                          <span id="password_error" class="text-danger"></span>
                          @if ($errors->has('password'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                      <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Enter Confirm Password">
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                          <button type="submit" class="btn btn-primary" id="form_submit">
                              Update
                          </button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
<script type="text/javascript">

  $('.parent_menu_checkbox').change(function() {

    var parent_id = $(this).attr('parent_id');

    if ($(this).prop('checked')==true){
      $('.child_menu_'+parent_id).prop('checked', true);
    }else{
      $('.child_menu_'+parent_id).prop('checked', false);
    }

  });

  $('.child_menu').change(function() {

    var parent_id = $(this).attr('parent_id');

    if ($('.child_menu_'+parent_id+':checked').length == $('.child_menu_'+parent_id).length) {
      $('#parent_menu_'+parent_id).prop('checked', true);
    }

  });

  $('.parent_permission_checkbox').change(function() {

    var parent_id = $(this).attr('parent_id');

    if ($(this).prop('checked')==true){
      $('.child_permission_'+parent_id).prop('checked', true);
    }else{
      $('.child_permission_'+parent_id).prop('checked', false);
    }

  });

  $('.child_permission').change(function() {

    var parent_id = $(this).attr('parent_id');

    if ($('.child_permission_'+parent_id+':checked').length == $('.child_permission_'+parent_id).length) {
      $('#parent_permission_'+parent_id).prop('checked', true);
    }

  });

  $('#pswd').keyup(function(e){
        $("#password_error").html("Please give at least six length password. At least give One upper case, one lower case letter, one special character and one number"); 
     });
</script>

@endsection