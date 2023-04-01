<div id="present-address-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Present Address</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['url' => 'employee-addresss', 'method' => 'post']) !!}
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <input type="hidden" name="address_type" value="Present">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th width="50%">Name Of Division</th>
              <td>{{ Form::select('division_id',$division,null, ['class' => 'form-control js-example-basic-single','style' => 'width:100%','id' => 'division_id_0','onchange' => 'get_district(0)']) }}</td>
            </tr>
            <tr>
              <th width="50%">Name Of District</th>
              <td>{{ Form::select('district_id',[],null, ['class' => 'form-control js-example-basic-single' , 'id' => 'district_id_0','style' => 'width:100%','onchange' => 'get_thana(0)']) }}</td>
            </tr>
            <tr>
              <th width="50%">Thana/Upazila</th>
              <td>{{ Form::select('thana_id',[],null, ['class' => 'form-control js-example-basic-single' , 'id' => 'thana_id_0','style' => 'width:100%','onchange' => 'get_post_office(0)']) }}</td>
            </tr>
            <tr>
              <th width="50%">Post Office</th>
              <td>{{ Form::select("post_office",[],null,["class" => "form-control focus_it",'id'=>'post_office_id_0']) }}</td>
            </tr>
            <tr>
              <th width="50%">Village/Road etc.</th>
              <td>{{ Form::text("village_road",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
<!--            <tr>
              <th width="50%">Post Code</th>
              <td>{{ Form::text("post_code",null,["class" => "form-control focus_it"]) }}</td>
            </tr>-->
            <tr>
              <th width="50%">Phone & Mobile No.</th>
              <td>{{ Form::text("mobile",null,["class" => "form-control focus_it"]) }}</td>
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