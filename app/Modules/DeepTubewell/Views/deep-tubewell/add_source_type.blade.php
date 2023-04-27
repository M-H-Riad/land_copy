<div id="deep_tubewell_source_type" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Add new Deep Tubewell Source Type</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th style="width: 50%;">Title</th>
              <td>{{ Form::text("title", null, ["class" => "form-control focus_it", "id" => "source_type_new"]) }}</td>
            </tr>
          </tbody>
     </table>
   </div>
   <div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
    <button class="btn btn-primary" onclick="add_new_Source_type()" data-dismiss="modal" aria-hidden="true">Save & Close</button>
  </div>
</div>
</div>
</div>

<script>
    function add_new_Source_type(){
        var source_type = $("#source_type_new").val();

        $.ajax({
            url: "{{ route('source_type.create-ajax') }}",
            method: "get",
            data:{ 
                // _token:'{{ csrf_token() }}',
                title: source_type,
            },
            cache: false,
            dataType: 'json',
            success: function(data){
                console.log(data);
                $.each(data.source_types,function(id, name){
                    $('#source_type').empty();
                    $("#source_type").append('<option class="form-control" value="'+id+'">'+name+'</option>');
                })
            }
        });
    }
</script>