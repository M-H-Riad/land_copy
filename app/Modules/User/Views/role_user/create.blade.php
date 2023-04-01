@extends('main_layouts.app')

@section('content')

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
    <span class="active">Create</span>
  </li>
</ul>
<!-- END PAGE BREADCRUMB -->

{{ Form::open(['route' => 'role-user.store']) }}

<div class="row animated zoomIn">

  <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption font-green">
          <!-- <i class="icon-settings font-green"></i> -->
          <span class="caption-subject bold uppercase">Create New Role User</span>
        </div>
        <div class="tools"> </div>
      </div>
      <div class="portlet-body">

        @include('errors.validation')

        <div class="col-md-3"></div>

        <div class="col-md-6">
         <div class="form-group">
           {{Form::label('inputParentRole', 'Parent Role Name', ['class' => 'form-label'])}}

           {!! Form::select('role_id',['' => 'Select Parent Role']+$roles,null, ['class' => 'form-control js-example-basic-single', 'id' => 'role_id']) !!}
         </div>
          <div class="form-group">
            {{Form::label('inputParentRole', 'User Name', ['class' => 'form-label'])}}

            {!! Form::select('user_id',['' => 'Select User']+$users,null, ['class' => 'form-control js-example-basic-single', 'id' => 'user_id']) !!}
          </div>

      </div>

        <div class="col-md-3"></div>

        <div class="col-md-3"></div>

      <div class="col-md-6" style="margin-top: 10px;">



        <button type="submit" class="btn green pull-right mt-ladda-btn ladda-button" data-style="zoom-in">
          <span class="ladda-label">
            <i class="icon-arrow-right"></i> Create
          </span>
        </button>

      </div>

        <div class="col-md-3"></div>

    </div>
  </div>
</div>

</div>

{{ Form::close() }}
<script type="text/javascript">
  $(document ).ready(function() {
    highlight_nav('role','role-add');
  });
</script>
<script type="text/javascript">

  $("#inputRoleName").keyup(function() {
    var display_name = $("#inputRoleName").val().toLowerCase().replace(/\s/g,'');
    $("#inputName").val(display_name);
  });

</script>
<script type="text/javascript">


  $(function() {
    $("li:has(li) > input[type='checkbox']").change(function() {
      $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
    });
    $("input[type='checkbox'] ~ ul input[type='checkbox']").change(function() {
      $(this).closest("li:has(li)").children("input[type='checkbox']").prop('checked', $(this).closest('ul').find("input[type='checkbox']").is(':checked'));
    });
  });

</script>

@endsection