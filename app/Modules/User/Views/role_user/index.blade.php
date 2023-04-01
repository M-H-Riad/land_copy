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
          <span class="active">Role User</span>
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
                  <span class="caption-subject bold uppercase">Role User Information</span>
              </div>
              <div class="tools"> </div>
          </div>
          <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover" id="nopagination">
                  <thead>
                      <tr>
                          <th></th>
                          <th class="all" width="15%">User Name</th>
                          <th class="min-phone-l">Role Name</th>
                          <th class="min-tablet" width="5%">Edit</th>
                      </tr>
                  </thead>
                  <tbody>
                     @if(count($role_user))
                      @foreach($role_user as $roleuser)
                        <tr>
                            <th></th>
                            <td>{{ $roleuser->username['name'] }}</td>
                            <td>{{ $roleuser->role['display_name'] }}</td>
                            <td>
                              <a class="btn btn-success btn-sm mt-ladda-btn ladda-button" data-style="zoom-in" href="{{ URL::route('role-user.edit', $roleuser->user_id) }}">
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