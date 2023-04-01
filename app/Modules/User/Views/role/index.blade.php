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
          <span class="active">Role</span>
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
                  <span class="caption-subject bold uppercase">Roles</span>
              </div>
              <div class="tools"> </div>
          </div>
          <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover" id="nopagination">
                  <thead>
                      <tr>
                          <th></th>
                          <th class="all" width="15%">Title</th>
                          <th class="min-phone-l">Permissions</th>
                          <th class="min-tablet" width="5%">Edit</th>
                      </tr>
                  </thead>
                  <tbody>
                     @if(count($roles))
                      @foreach($roles as $role)
                        <tr>
                            <th></th>
                            <td>{{ $role->display_name }}</td>
                            <td>
                              @if(count($role->perms))
                                  @foreach($role->perms as $key=>$perm)
                                      @if($key<=5)
                                            <span class="btn btn-default margin-bottom-10">{{ $perm->display_name }},</span>
                                      @else
                                            <span style="display: none" class="hidden-text btn btn-default margin-bottom-10">{{ $perm->display_name }},</span>
                                      @endif
                                  @endforeach
                                  @if($key>5)<span class="show_hidden text-primary " role="button">More...</span>@endif
                              @endif
                            </td>
                            <td>
                              <a class="btn btn-success btn-sm mt-ladda-btn ladda-button" data-style="zoom-in" href="{{ URL::route('role.edit', $role->id) }}">
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
    highlight_nav('role','role-manage');
  });
</script>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('.show_hidden').on('click',function () {
                $(this).parent().find('.hidden-text').show();
                $(this).hide();
            })
        })
    </script>
@endsection