<div id="add-bonus_setting-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => 'bonus-setting', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Add new festival bonus setting</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
          <tr>
            <th style="width: 50%;">Title</th>
            <td>{{ Form::text("title",null,["class" => "form-control focus_it",'placeholder' => 'Festival title','required']) }}</td>
          </tr>
          <tr>
            <th style="width: 50%;">Religion</th>
            <td>
              {!! Form::select('religion',$religion,null, ['class' => 'form-control select2','placeholder' => 'Select Religion','style' => 'width:100%','required']) !!}
            </td>
          </tr>
          <tr>
            <th style="width: 50%;">Bonus Percentage</th>
            <td>{{ Form::number("percentage",null,["class" => "form-control focus_it",'placeholder' => '00','required']) }}</td>
          </tr>
          <tr>
            <th style="width: 50%;">Status</th>
            <td>{!! Form::select('status',['active' => 'Active','inactive' => 'Inactive'],null, ['class' => 'form-control','required']) !!}</td>
          </tr>
          </tbody>

        </table>

      </div>
      <div class="modal-footer">
        <button class="btn btn-dark dark btn-outline" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
        <button type="submit" class="btn btn-primary">Save & Close</button>
      </div>
      {!! Form::close()  !!}
    </div>
  </div>
</div>