<div id="edit-land_thana-modal-{{$thana->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        {!! Form::model($thana, ['url' => 'land/thana/'.$thana->id, 'method' => 'put']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Update Land Thana</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">
            <tbody>
              <tr>
                <th style="width: 50%;">Title</th>
                <td>{{ Form::text("title", $thana->title, ["class" => "form-control focus_it"]) }}</td>
              </tr>
              <tr>
                <th style="width: 50%;">Zone</th>
                <td>
                  {!! Form::select('zila_id', $zilas, null, ['class' => 'form-control select2','placeholder' => 'Select Zila','style' => 'width:100%']) !!}
                </td>
              </tr>
              <tr>
                <th style="width: 50%;">Status</th>
                <td>
                  {!! Form::select('status', ['1' => 'Active','0' => 'Inactive'],null, ['class' => 'form-control','placeholder' => 'Select Status','style' => 'width:100%']) !!}
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