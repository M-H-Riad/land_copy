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

  {!! Form::model($role, array('url' => 'role/'.$role->id, 'method' => 'put')) !!}

  <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption font-green">
          <!-- <i class="icon-settings font-green"></i> -->
          <span class="caption-subject bold uppercase">{{ $role->display_name }}</span>
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
      </div>

      <div class="col-md-6">

        <ul class="nav nav-tabs">
          <li class="active">
              <a href="#permissions" data-toggle="tab"> Permission </a>
          </li>
        </ul>
        <div class="tab-content">

            <div class="tab-pane fade active in" id="permissions">
                @if(count($modules) > 0)
                  @foreach($modules as $module)
                  <ul>
                    <li style="display: block;">
                      @if(count($module->permissions) > 0)
                      <input type="checkbox" class="parent_permission_checkbox" parent_id="{{ $module->id }}" id="parent_permission_{{ $module->id }}">

                      <span style="font-weight: 600; font-size: 20px">{{$module->title}}</span>
                      <br>
                      @endif
                      <ul>
                        @if(count($module->permissions) > 0)
                        @foreach($module->permissions as $permission)
                        <li style="display: block;">
                          {{ Form::checkbox('permission_ids[]', $permission->id, in_array($permission->id, $currentPermissions), ['id' => 'checkbox'.$permission->id,'class' => 'child_permission child_permission_'.$module->id,'parent_id' => $module->id]) }} {{$permission->display_name}}
                          <br>
                        </li>

                        @endforeach
                        @endif
                      </ul>

                    </li>
                  </ul>
                  @endforeach
                @endif
            </div>


        </div>
        <div class="clearfix margin-bottom-20"> </div>

        </div>

        <div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;">

          <a class="btn default mt-ladda-btn ladda-button" data-style="zoom-in" href="javascript:history.back()">
            <span class="ladda-label">
              <i class="icon-arrow-left"></i> Cancel
            </span>
          </a>

          <button type="submit" class="btn green pull-right mt-ladda-btn ladda-button" data-style="zoom-in">
            <span class="ladda-label">
              <i class="icon-arrow-right"></i> Update
            </span>
          </button>

        </div>

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