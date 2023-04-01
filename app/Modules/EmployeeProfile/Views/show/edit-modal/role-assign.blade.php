<div id="role-assign-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
      {!! Form::open(['url' => 'employee-user/update-role', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Change User</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <input type="hidden" name="user_id" value="{{$employee->user->id}}">
        <table class="table table-bordered table-hover dt-responsive" width="100%">

          <tbody>
            <tr>
              <th width="50%">Roles </th>
              <td>{{ Form::select("role_id",$roles,$current_role,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">User Login ID </th>
              <td>{{ Form::text("user_name",$employee->user->user_name,["class" => "form-control",'required']) }}</td>
            </tr>
            <tr>
              <th width="50%">User Status </th>
              <td>{{ Form::select("status",[1 => 'Active',0 => 'Disabled'],$employee->user->status,["class" => "form-control"]) }}</td>
            </tr>
          </tbody>

        </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
        <button type="submit" class="btn btn-primary">Save & Close</button>
      </div>

      {!! Form::close()  !!}
    </div>
  </div>
</div>