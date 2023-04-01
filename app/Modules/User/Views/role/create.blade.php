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

{{ Form::open(['route' => 'role.store']) }}

<div class="row animated zoomIn">

  <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption font-green">
          <!-- <i class="icon-settings font-green"></i> -->
          <span class="caption-subject bold uppercase">{{$title}}</span>
        </div>
        <div class="tools"> </div>
      </div>
      <div class="portlet-body">

        @include('errors.validation')

        <div class="col-md-6">
         <div class="form-group">
           {{Form::label('inputParentRole', 'Parent Role', ['class' => 'form-label'])}}

           {!! Form::select('parent_id',['' => 'Select Parent Role']+$roles,null, ['class' => 'form-control js-example-basic-single', 'id' => 'parent_id']) !!}
         </div>
         <div class="form-group">
          {{Form::label('inputRoleName', 'Display Name', ['class' => 'form-label'])}}
          {{ Form::text('display_name', null, ['class' => 'form-control', 'id' => 'inputRoleName', 'required' => 'required']) }}
        </div>
        <div class="form-group">
          {{Form::label('inputName', 'Unique Name', ['class' => 'form-label'])}}
          {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName', 'readonly' => 'readonly', 'required' => 'required']) }}
        </div>
      </div>

      <div class="col-md-6">
        <h4><u>Assign Permision :</u></h4>
        @if(count($modules) > 0)
        @foreach($modules as $module)
        <ul>
          <li style="display: block;">
            @if(count($module->permissions) > 0)
            <input type="checkbox">

            <span style="font-weight: 600; font-size: 15px">{{$module->title}}</span>
            <br>
            @endif
            <ul>
              @if(count($module->permissions) > 0)
              @foreach($module->permissions as $permission)
              <li style="display: block;">
                <input value="{{$permission->id}}" name="permission_ids[]" type="checkbox"> {{$permission->display_name}}
                <br>
              </li>

              @endforeach
              @endif
            </ul>

          </li>

        </ul>

        @endforeach
        @endif
        {{-- <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="">
          <thead>
            <tr>
              <th></th>
              <th class="all">Permission</th>
              <th class="min-phone-l">Title</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $permission)
            <tr>
              <th></th>
              <td style="text-align:right;">
                {{ Form::checkbox('permission_ids[]', $permission->id, false, ['id' => 'checkbox'.$permission->id]) }}
              </td>
              <td>
                {{ $permission->display_name }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table> --}}
      </div>

      <div class="col-md-12" style="margin-top: 10px;">

        <a class="btn default mt-ladda-btn ladda-button" data-style="zoom-in" href="javascript:history.back()">
          <span class="ladda-label">
            <i class="icon-arrow-left"></i> Cancel
          </span>
        </a>

        <button type="submit" class="btn green pull-right mt-ladda-btn ladda-button" data-style="zoom-in">
          <span class="ladda-label">
            <i class="icon-arrow-right"></i> Create
          </span>
        </button>

      </div>

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