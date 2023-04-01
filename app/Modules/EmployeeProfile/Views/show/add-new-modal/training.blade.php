<div id="training-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(['url' => 'employee-training', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Training</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th width="50%;">Training Course Title</th>
              <td>{{ Form::text("course_title",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Training Type</th>
              <td>{{ Form::select('training_type',[''=>'Select Training Type','local'=>'local','foregin'=>'foregin'],null, ['class' => 'form-control' ,'style' => 'width:100%']) }}</td>
            </tr>
            <tr>
              <th width="50%;">Country</th>
              <td>{{ Form::select('country',$country,null, ['class' => 'form-control' ,'style' => 'width:100%']) }}</td>
            </tr>
            <tr>
              <th width="50%;">Place/City</th>
              <td>{{ Form::text("place",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Institution</th>
              <td>{{ Form::text("institution",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            
            <tr>
              <th width="50%;">Financed By</th>
              <td>{{ Form::text("finance_by",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Amount</th>
              <td>{{ Form::text("amount",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Year</th>
              <td>{{ Form::text("year",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Duration (Month)</th>
              <td>{{ Form::text("duration",null,["class" => "form-control focus_it"]) }}</td>
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