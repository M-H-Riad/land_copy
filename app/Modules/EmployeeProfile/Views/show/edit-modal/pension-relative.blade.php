<div id="pension-relative-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => route('employee.pension-relative'), 'method' => 'put']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pension Relative Information</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <input type="hidden" name="relative_id" value="{{$row->id}}">
        <table class="table table-bordered table-hover dt-responsive" width="100%">

          <tbody>
          <tr>
            <th width="50%">Name</th>
            <td>{{ Form::text("name",$row->name,["class" => "form-control focus_it",'required']) }}</td>
          </tr>
          <tr>
            <th width="50%">Relation</th>
            <td>{{ Form::select('relation',$relations,$row->relation, ['class' => 'form-control' , 'id' => '','style' => 'width:100%']) }}</td>
          </tr>
          <tr>
            <th width="50%">Phone No.</th>
            <td>{{ Form::text("phone_no",$row->phone_no,["class" => "form-control focus_it"]) }}</td>
          </tr>
          </tbody>

        </table>

      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
        <button type="submit" class="btn btn-primary">Update & Close</button>
      </div>
      {!! Form::close()  !!}
    </div>
  </div>
</div>