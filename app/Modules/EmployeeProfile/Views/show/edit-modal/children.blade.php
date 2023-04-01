<div id="children-modal{{$children->id}}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => url('employee-children',$children->id), 'method' => 'put']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Children Information</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <input type="hidden" name="children_id" value="{{$children->id}}">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th width="50%">Name of Children</th>
              <td>{{ Form::text("children_name",$children->children_name,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Sex</th>
              <td>{{ Form::select('sex',$sex, ucfirst($children->sex), ['class' => 'form-control','style' => 'width:100%']) }}</td>
            </tr>
            <tr>
              <th width="50%">Date of Birth</th>
              <td>
               
                  {{ Form::text('children_date_of_birth',dateFormat($children->date_of_birth), ['class' => 'form-control mask_date','placeholder' => 'dd-mm-yyyy']) }}
                
              </td>
            </tr>
            <tr>
              <th width="50%">Profession</th>
              <td>{{ Form::text("profession",$children->profession,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
{{--              {{dd($children)}}--}}
            <td>Education Allowance</td>
            <td>
              {{ Form::checkbox("edu_alw",1,$children->edu_alw,["class" => ""]) }}
            </td>
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