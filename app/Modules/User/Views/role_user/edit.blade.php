@extends('main_layouts.app')

@section('content')
@include('errorOrSuccess')
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
  <li>
    <a href="{{ url('/') }}">Home</a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    <a href="{{ url('/role') }}">Role</a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    <span class="active">Update</span>
  </li>
</ul>
<!-- END PAGE BREADCRUMB -->

<div class="row animated zoomIn">

  {!! Form::model($roleuser, array('url' => 'role-user/'.$roleuser[0]->user_id, 'method' => 'put')) !!}

  <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption font-green">
          <!-- <i class="icon-settings font-green"></i> -->
          <span class="caption-subject bold uppercase">{{--{{ $role->display_name }}--}}</span>
        </div>
        <div class="tools"> </div>
      </div>
      <div class="portlet-body">

        @include('errors.validation')

        <div class="col-md-3"></div>

        <div class="col-md-6">
          <div class="form-group">
           {{Form::label('inputParentRole', 'Parent Role', ['class' => 'form-label'])}}
            {!! Form::select('role_id',$roles,$roleuser[0]->role_id, ['class' => 'form-control js-example-basic-single', 'id' => 'role_id']) !!}
         </div>
         <div class="form-group">
          {{Form::label('inputRoleName', 'User Name', ['class' => 'form-label'])}}
           {!! Form::select('user_id',$users,$roleuser[0]->user_id, ['class' => 'form-control js-example-basic-single', 'id' => 'user_id']) !!}
        </div>
      </div>

      <div class="col-md-6">

        <div class="col-md-3"></div>



        <div class="col-md-3"></div>

        <div class="col-md-6" style="margin-top: 10px;">



          <button type="submit" class="btn green pull-right mt-ladda-btn ladda-button" data-style="zoom-in">
            <span class="ladda-label">
              <i class="icon-arrow-right"></i> Update
            </span>
          </button>

        </div>

        <div class="col-md-3"></div>

      </div>

    </div>

{{ Form::close() }}

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

</script>

@endsection