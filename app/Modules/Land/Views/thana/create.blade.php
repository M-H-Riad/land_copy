<div id="add-land_thana-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['url' => 'land/thana', 'method' => 'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Add new Thana</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">
  
            <tbody>
              <tr>
                <th style="width: 50%;">Title</th>
                <td>{{ Form::text("title", null, ["class" => "form-control focus_it"]) }}</td>
              </tr>
              <tr>
                <th style="width: 50%;">Zila</th>
                <td>
                  {!! Form::select('zila_id', $zilas, null, ['class' => 'form-control select2','placeholder' => 'Select Land zila', 'style' => 'width:100%']) !!}
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