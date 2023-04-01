<div id="documents-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => 'land/land-document/store', 'method' => 'post','files'=>True]) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Documents</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="land_id" value="{{$land->id}}">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th width="50%">File Title</th>
              <td>{{ Form::text("file_title", null, ["class" => "form-control focus_it", 'required']) }}</td>
            </tr>
            <tr>
              <th width="50%">File Type</th>
              <td>{{ Form::select("file_type_id",$fileTypes, '',["class" => "form-control focus_it", 'required']) }}</td>
            </tr>
            <tr>
              <th width="50%">Documents</th>
              <td>{{ Form::file("document",null,["class" => "form-control"]) }}
              <span style="color:red">Max File Size 5MB</span>
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