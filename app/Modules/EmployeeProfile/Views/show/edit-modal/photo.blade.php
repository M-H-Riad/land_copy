<div id="photo-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      {!! Form::open(['url' => 'employee-profile/photo', 'method' => 'post','files'=>True]) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pictures</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th width="50%">Photo</th>
              <td>{{ Form::file("photo",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Signature</th>
              <td>{{ Form::file("signature",null,["class" => "form-control"]) }}</td>
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