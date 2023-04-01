<div id="present-address-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => url('employee-addresss',$address->id), 'method' => 'put']) !!}
      <input type="hidden" name="address_id" value="{{$address->id}}">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Present Address</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <input type="hidden" name="address_type" value="Present">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
          <tr>
            <th width="50%">Name Of Division</th>
            <td>{{ Form::select('division_id',$division,$address->division_id, ['class' => 'form-control division_id','style' => 'width:100%','id' => 'division_id_0','onchange' => 'get_district_edit(0,'. $address->district_id .')']) }}</td>
          </tr>
          <tr>
            <th width="50%">Name Of District</th>
            <td>{{ Form::select('district_id',[],$address->district_id, ['class' => 'form-control district_id' , 'id' => 'district_id_0','style' => 'width:100%','onchange' => 'get_thana_edit(0,'. $address->thana_id .')']) }}</td>
          </tr>
          <tr>
            <th width="50%">Thana/Upazila</th>
            <td>{{ Form::select('thana_id',[],$address->thana_id, ['class' => 'form-control thana_id' , 'id' => 'thana_id_0','style' => 'width:100%','onchange' => 'get_post_office_edit(0,'. $address->post_office .')']) }}</td>
          </tr>
           <tr>
              <th width="50%">Post Office</th>
              <td>{{ Form::select("post_office",[],$address->post_office,["class" => "form-control focus_it",'id'=>'post_office_id_0']) }}</td>
            </tr>
          <tr>
            <th width="50%">Village/Road etc.</th>
            <td>{{ Form::text("village_road",$address->village_road,["class" => "form-control focus_it"]) }}</td>
          </tr>
<!--          <tr>
            <th width="50%">Post Code</th>
            <td>{{ Form::text("post_code",$address->post_code,["class" => "form-control focus_it"]) }}</td>
          </tr>-->
          <tr>
            <th width="50%">Phone & Mobile No.</th>
            <td>{{ Form::text("mobile",$address->mobile,["class" => "form-control focus_it"]) }}</td>
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

<script>
  $(function () {
      $('#division_id_0').trigger('change');
  });
</script>