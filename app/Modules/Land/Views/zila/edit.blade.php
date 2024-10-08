<div id="edit-land_zila-modal-{{$zila->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        {!! Form::model($zila, ['url' => 'land/zila/'.$zila->id, 'method' => 'put']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Update Zila</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">
            <tbody>
              <tr>
                <th style="width: 50%;">Title</th>
                <td>{{ Form::text("title", $zila->title, ["class" => "form-control focus_it"]) }}</td>
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