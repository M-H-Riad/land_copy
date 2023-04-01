<div id="quarter-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => 'employee-quarter', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Quarter Information </h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">

        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th style="width: 50%;">Allotment Reference</th>
              <td>{{ Form::text("allotment_reference",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Ref. Date</th>
              <td>

                {!! Form::text('reference_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) !!}

              </td>
            </tr>
            <tr>
              <th width="50%">Positioning Date</th>
              <td>

                {!! Form::text('posting_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) !!}

              </td>
            </tr>
            <tr>
              <th width="50%">Location (e.g. Mirpur)</th>
              <td>{{ Form::select('location',$quarter_location,null, ['class' => 'form-control ','placeholder' => 'Select Quarter Location']) }}</td>
            </tr>
            {{-- <tr>
              <th style="width: 50%;">Location (e.g. Mirpur)</th>
              <td>{{ Form::text("location",null,["class" => "form-control focus_it"]) }}</td>
            </tr> --}}
            <tr>
              <th style="width: 50%;">Road #</th>
              <td>{{ Form::text("road",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th colspan="2" class="text-center" style="width: 50%;">Flat Specification</th>
            </tr>
            <tr>
              <th style="width: 50%;">Building #</th>
              <td>{{ Form::text("building",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th style="width: 50%;">Flat #</th>
              <td>{{ Form::text("flat",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th style="width: 50%;">Flat type #</th>
              <td>{{ Form::text("flat_type",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th style="width: 50%;">Size (SFT) #</th>
              <td>{{ Form::text("size_sft",null,["class" => "form-control focus_it"]) }}</td>
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