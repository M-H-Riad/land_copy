@extends('metronic.layouts.app')

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
          <span class="active">Users</span>
        </li>
      </ul>
      <!-- END PAGE BREADCRUMB -->

      <div class="row animated flipInX">

        <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bordered">
            <div class="portlet-title">
              <div class="caption font-green">
                <!-- <i class="icon-settings font-green"></i> -->
                <span class="caption-subject bold uppercase">Filter</span>
              </div>
              <div class="tools"> </div>
            </div>
            <div class="portlet-body">

              {!! Form::open(array('method' => 'get', 'id' => 'filter-form')) !!}

              <div class="col-md-12 side-padding-none">

                <?php if(!isset($_GET['name'])){$_GET['name'] = null;} ?>
                <div class="col-md-4" style="margin-bottom:5px;">
                  <!-- <div class="row"> -->
                  <input type="text" value="{{$_GET['name']}}" class="form-control focus_it" name="name" id="name" placeholder="Name">
                  <!-- </div> -->
                </div>

                <?php if(!isset($_GET['emp_id'])){$_GET['emp_id'] = null;} ?>
                <div class="col-md-4" style="margin-bottom:5px;">
                  <!-- <div class="row"> -->
                  <input type="text" value="{{$_GET['emp_id']}}" class="form-control focus_it" name="emp_id" id="emp_id" placeholder="Employee Id">
                  <!-- </div> -->
                </div>

                <?php if(!isset($_GET['user_role_id'])){$_GET['user_role_id'] = null;} ?>
                <div class="col-md-4" style="margin-bottom:5px;">
                  <!-- <div class="row"> -->
                  {!! Form::select('user_role_id',['' => 'All Roles']+$roles,$_GET['user_role_id'], ['class' => 'form-control js-example-basic-single', 'id' => 'user_role_id']) !!}
                  <!-- </div> -->
                </div>

              </div>

              <div class="col-md-12 side-padding-none">

                <?php if(!isset($_GET['department_id'])){$_GET['department_id'] = null;} ?>
                <div class="col-md-4" style="margin-bottom:5px;">
                  <!-- <div class="row"> -->
                  {!! Form::select('department_id',['' => 'All Departments']+$departments,$_GET['department_id'], ['class' => 'form-control js-example-basic-single', 'id' => 'department_id']) !!}
                  <!-- </div> -->
                </div>

                <?php if(!isset($_GET['designation_id'])){$_GET['designation_id'] = null;} ?>
                <div class="col-md-4" style="margin-bottom:5px;">
                  <!-- <div class="row"> -->
                  {!! Form::select('designation_id',['' => 'All Designations']+$designations,$_GET['designation_id'], ['class' => 'form-control js-example-basic-single', 'id' => 'designation_id']) !!}
                  <!-- </div> -->
                </div>

                <div class="col-md-4">
                  <button type="submit" class="btn btn-primary filter-btn" style="width: 100%;"><i class="fa fa-search"></i> Filter</button>
                </div>
                <div class="clearfix"></div>

              </div>

              {!! Form::close() !!}

            </div>

          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
        </div>

      </div>

      <div class="row animated zoomIn">

        <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bordered">
            <div class="portlet-title">
              <div class="caption font-green">
                <!-- <i class="icon-settings font-green"></i> -->
                <span class="caption-subject bold uppercase">Users</span>
              </div>
              <div class="tools"> </div>
            </div>
            <div class="portlet-body">
              @include('errors.validation')
              <table class="table table-striped table-bordered table-hover dt-responsive" id="nopagination" width="100%">
                <thead>
                  <tr>
                    <th class="min-phone-l">Name</th>
                    <th class="min-phone-l">Employee Id</th>
                    <th class="min-phone-l">Role</th>
                    <th class="min-phone-l">Department</th>
                    <th class="min-phone-l">Designation</th>
                    <!-- <th class="min-phone-l">Email</th> -->
                  </tr>
                </thead>
                <tbody>
                 @if(count($users) > 0)
                 @foreach($users as $user)
                 <?php
                 $selected_roles = null;
                 if(count($user->userRole) > 0){
                  foreach ($user->userRole as $key => $value) {
                    $selected_roles[] = $value->role_id;
                  }
                }
                ?>
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->emp_id }}</td>
                  <td>
                    {!! Form::model($user, array('url' => 'roleuser/'.$user->id, 'method' => 'post')) !!}
                    <div class="form-group">
                      {!! Form::select('role_id[]',['' => 'Select Role']+$roles,$selected_roles, ['class' => 'form-control js-example-basic-single', 'required' => 'required', 'style' => 'width:100%' ,'multiple' =>'']) !!}

                      <button class="btn btn-success btn-sm mt-ladda-btn ladda-button" data-style="zoom-in" type="submit" style="width: 100%;">
                        <span class="ladda-label">
                          <i class="fa falist fa-repeat"></i>
                        </span>
                      </button>
                    </div>
                    {{ Form::close() }}
                  </td>
                  <td>{{ $user->department->dept_name }}</td>
                  <td>{{ $user->designation->designation_name }}</td>
                  <!-- <td>{{ $user->email }}</td> -->
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>

            <div class="pagination pull-right">
              {{ $users->render() }}
            </div>


          </div>

        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
      </div>

    </div>

    <script type="text/javascript">
      $(document ).ready(function() {

          $('#nopagination').DataTable( {
            "paging":   false,
            "bFilter":   false,
            "info":     false
          });
        });
      </script>

      @endsection