<div id="suspension-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => 'employee-disciplinary-records', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Disciplinary Records</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th style="width: 50%;">Reference No.</th>
              <td>{{ Form::text("ref_no",null,["class" => "form-control",'required']) }}</td>
            </tr>
            <tr>
              <th width="50%">Reference Date</th>
              <td>
                  {{ Form::text('ref_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy','required']) }}
              </td>
            </tr>
            <tr>
              <th style="width: 50%;">Case No.</th>
              <td>{{ Form::text("case_no",null,["class" => "form-control focus_it",'required']) }}</td>
            </tr>
<!--            <tr>
              <th width="50%">Case Date</th>
              <td>{!! Form::text('case_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) !!}</td>
            </tr>-->
            <tr>
              <th style="width: 50%;">Allegation/Grievance as per DWASA Regulation</th>
              <td>{{ Form::textarea("allegation",null,["class" => "form-control",'required']) }}</td>
            </tr>
           
<!--            <tr>
              <th style="width: 50%;">Punishment in brief</th>
              <td>{{ Form::textarea("punishment",null,["class" => "form-control"]) }}</td>
            </tr>-->
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