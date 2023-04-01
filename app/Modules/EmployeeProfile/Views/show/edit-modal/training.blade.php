<div id="training-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => url('employee-training',$row->id), 'method' => 'put']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Training</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <input type="hidden" name="training_id" value="{{$row->id}}">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th width="50%;">Training Course Title</th>
              <td>{{ Form::text("course_title",$row->course_title,["class" => "form-control focus_it"]) }}</td>
            </tr>
             <tr>
              <th width="50%;">Training Type</th>
              <td>{{ Form::select('training_type',['local'=>'local','foregin'=>'foregin'],$row->training_type, ['class' => 'form-control' ,'style' => 'width:100%']) }}</td>
            </tr>
             <tr>
              <th width="50%;">Country {{$row->country}}</th>
              <td>{{ Form::select('country',$country,$row->country, ['class' => 'form-control' ,'style' => 'width:100%']) }}</td>
            </tr>
            <tr>
              <th width="50%;">Place/City</th>
              <td>{{ Form::text("place",$row->place,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Institution</th>
              <td>{{ Form::text("institution",$row->institution,["class" => "form-control focus_it"]) }}</td>
            </tr>
           
            <tr>
              <th width="50%;">Financed By</th>
              <td>{{ Form::text("finance_by",$row->finance_by,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Amount</th>
              <td>{{ Form::text("amount",$row->amount,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Year</th>
              <td>{{ Form::text("year",$row->year,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%;">Duration (Month)</th>
              <td>{{ Form::text("duration",$row->duration,["class" => "form-control focus_it"]) }}</td>
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