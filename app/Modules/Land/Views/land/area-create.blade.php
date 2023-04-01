<div id="add-land_area-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Add new Land Area</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th style="width: 50%;">Title</th>
              <td>{{ Form::text("title", null, ["class" => "form-control focus_it", "id" => "area_name"]) }}</td>
            </tr>
            <tr>
              <th style="width: 50%;">Zone</th>
              <td>
                {!! Form::select('zone_id', $zones, null, ['class' => 'form-control select2','placeholder' => 'Select Land Zone', 'id' => 'zone_id', 'style' => 'width:100%']) !!}
              </td>
            </tr>
          </tbody>
     </table>
   </div>
   <div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
    <button class="btn btn-primary" onclick="add_new_area()" data-dismiss="modal" aria-hidden="true">Save & Close</button>
  </div>
</div>
</div>
</div>

<script>
    function add_new_area(){
        var area_name = $("#area_name").val();
        var zone_id = $("#zone_id").val();

        $.ajax({
            url: "{{ route('area.create-ajax') }}",
            method: "get",
            data:{ 
                // _token:'{{ csrf_token() }}',
                title: area_name,
                zone_id: zone_id
            },
            cache: false,
            dataType: 'json',
            success: function(data){
                console.log(data);
                $.each(data.areas,function(id, name){
                    $('#area_id').empty();
                    $("#area_id").append('<option class="form-control" value="'+id+'">'+name+'</option>');
                })
            }
        });
    }
</script>