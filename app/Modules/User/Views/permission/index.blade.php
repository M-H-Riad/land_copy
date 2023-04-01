@extends('main_layouts.app')

@section('content')

  <!-- BEGIN PAGE BREADCRUMB -->
  <ul class="page-breadcrumb breadcrumb">
      <li>
          <a href="{{ url('/') }}">Home</a>
          <i class="fa fa-circle"></i>
      </li>
      <!-- <li>
          <a href="#">Blank Page</a>
          <i class="fa fa-circle"></i>
      </li> -->
      <li>
          <span class="active">Permission</span>
      </li>
  </ul>
  <!-- END PAGE BREADCRUMB -->

  <div class="row animated zoomIn">

    <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light bordered">
          <div class="portlet-title">
              <div class="caption font-green">
                  <!-- <i class="icon-settings font-green"></i> -->
                  <span class="caption-subject bold uppercase">Permissions</span>
              </div>
              <div class="tools"> </div>
          </div>
          <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
                  <thead>
                      <tr>
                          <th>Sl. No.</th>
                          <th>Module</th>
                          <th class="all">Permission</th>
                          <th class="min-tablet">Edit</th>
                      </tr>
                  </thead>
                  <tbody>
                     @if(count($permissions))
                     <?php $i = 1;?>
                      @foreach($permissions as $permission)
                        <tr>
                            <th>{{$i++}}</th>
                            <th>{{$permission->module->title or 'N/A'}}</th>
                            <td>{{ $permission->display_name }}</td>
                            <td>
                              <a class="btn btn-success btn-sm mt-ladda-btn ladda-button" data-style="zoom-in" href="{{ URL::route('permission.edit', $permission->id) }}">
                                <span class="ladda-label">
                                  <i class="fa falist fa-edit"></i> Edit
                                </span>
                              </a>
                            </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
              </table>
          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
    </div>

  </div>
<script type="text/javascript">
  $(document ).ready(function() {
    highlight_nav('permission');
  });
</script>
@endsection
