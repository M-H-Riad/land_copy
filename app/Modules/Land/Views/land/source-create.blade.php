<div id="add-land_source-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Add new Land Source</h4>
      </div>
      <div class="modal-body">
      <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">
          <tbody>
          <tr>
            <th style="width: 50%;">Source Name</th>
            <td>{{ Form::text("title", null, ["class" => "form-control focus_it", "id" => "source_name"]) }}</td>
          </tr>
       </tbody>
     </table>
   </div>
   <div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
    <button class="btn btn-primary" onclick="add_new_source()" data-dismiss="modal" aria-hidden="true">Save & Close</button>
  </div>
</div>
</div>
</div>

<script>
    function add_new_source(){
        var source_name = $("#source_name").val();

        $.ajax({
            url: "{{ route('source.create-ajax') }}",
            method: "get",
            data:{
                title: source_name
            },
            cache: false,
            dataType: 'json',
            success: function(data){
                console.log(data);
                $.each(data.sources,function(id, name){
                    $('#land_source_id').empty();
                    $("#land_source_id").append('<option class="form-control" value="'+id+'">'+name+'</option>');
                })
            }
        });
    }
</script>