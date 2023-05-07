<div id="add-land_zone-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => 'land/zone', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Add new Land Zone</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">
          <tbody>
          <tr>
            <th style="width: 50%;">Zone Name</th>
            <td>{{ Form::text("title", null, ["class" => "form-control focus_it"]) }}</td>
          </tr>
          <tr>
            <th style="width: 50%;">Order</th>
            <td>{{ Form::number("ordering", null, ["class" => "form-control focus_it"]) }}</td>
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