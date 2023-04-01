@extends('main_layouts.app')

@section('content')

<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
  <li>
    <a href="{{ url('/') }}">Home</a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    <a href="{{ url('/permission') }}">Permission</a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    <span class="active">Update</span>
  </li>
</ul>
<!-- END PAGE BREADCRUMB -->

<div class="row animated zoomIn">

  {!! Form::model($permission, array('url' => 'permission/'.$permission->id, 'method' => 'put')) !!}

  <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption font-green">
          <!-- <i class="icon-settings font-green"></i> -->
          <span class="caption-subject bold uppercase">{{ $permission->display_name }}</span>
        </div>
        <div class="tools"> </div>
      </div>
      <div class="portlet-body">

        @include('errors.validation')

        <div class="col-md-12">
          <div class="form-group">
            {{Form::label('inputModul', 'Module', ['class' => 'form-label'])}}

            {!! Form::select('module_id',['' => 'Select Module']+$modules,null, ['class' => 'form-control js-example-basic-single', 'id' => 'module_id','required' => 'requiredq']) !!}
          </div>
          <div class="form-group">
            {{Form::label('inputPermissionDisplayName', 'Display Name', ['class' => 'form-label'])}}
            {{ Form::text('display_name', null, ['class' => 'form-control', 'id' => 'inputPermissionDisplayName', 'required' => 'required']) }}
          </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">

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
  </div>

  {{ Form::close() }}

</div>

<script type="text/javascript">
  $(document ).ready(function() {
    highlight_nav('permission');
    $('#example0').DataTable({
      "order": [],
    });
  });
</script>

@endsection