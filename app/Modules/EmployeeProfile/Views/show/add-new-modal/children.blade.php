<div id="children-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(['url' => 'employee-children', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Children Information</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <table class="table table-bordered table-hover dt-responsive" width="100%">

          <tbody>
            <tr>
              <th width="50%">Name of Children</th>
              <td>{{ Form::text("children_name",null,["class" => "form-control focus_it",'required']) }}</td>
            </tr>
            <tr>
              <th width="50%">Sex</th>
              <td>{{ Form::select('sex',$sex,null, ['class' => 'form-control js-example-basic-single' ,'style' => 'width:100%']) }}</td>
            </tr>
            <tr>
              <th width="50%">Date of Birth</th>
              <td>
                
                  {{ Form::text('children_date_of_birth',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) }}
               
              </td>
            </tr>
            <tr>
              <th width="50%">Profession</th>
              <td>{{ Form::text("profession",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
            <td>Education Allowance</td>
            <td>
              {{ Form::checkbox("edu_alw",1,null,["class" => ""]) }}
            </td>
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