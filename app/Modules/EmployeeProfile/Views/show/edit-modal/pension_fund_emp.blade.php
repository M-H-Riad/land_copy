<div id="pension-fund-emp-edit-modal_{{$pension_fund->id}}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::model($pension_fund,['url' => url('pension-fund-emp',$pension_fund->id), 'method' => 'put']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pension Fund Infomation</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <input type="hidden" name="pension_fund_emp_id" value="{{$pension_fund->id}}">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
            <tr>
              <th width="50%">PPO No</th>
              <td>{{ Form::text("ppo_no",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Pension Type</th>
              <td>{{ Form::select('pension_type_id',$pension_type,null, ['class' => 'form-control ']) }}</td>
            </tr>

            <tr>
              <th width="50%">Pension Holder Type</th>
              <td>{{ Form::select('pension_holder_type',$pension_holder_type,null, ['class' => 'form-control ']) }}</td>
            </tr>
            <tr>
              <th width="50%">Pension Holder Name</th>
              <td>{{ Form::text("pension_holder_name",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Mobile No</th>
              <td>{{ Form::text("mobile_no",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Present Address</th>
              <td>{{ Form::text("present_address",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Permanent Address</th>
              <td>{{ Form::text("permanent_address",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Opening Net pension</th>
              <td>{{ Form::text("opening_net_pension",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Current Net pension</th>
              <td>{{ Form::text("current_net_pension",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Previous Pension Date</th>
              <td>{{ Form::text('previous_date',dateFormat($pension_fund->previous_date), ['class' => 'form-control mask_date']) }}</td>
            </tr>
            <tr>
              <th width="50%">Pension Expire Date</th>
              <td>{{ Form::text('expire_date',dateFormat($pension_fund->expire_date), ['class' => 'form-control mask_date']) }}</td>
            </tr>
          {{--   <tr>
              <th width="50%">Medical Allowance</th>
              <td>{{ Form::text("medical_allowance",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">New Year Allowance</th>
              <td>{{ Form::text("new_year_allowance",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Festival Year Allowance</th>
              <td>{{ Form::text("festival_allowance",null,["class" => "form-control focus_it"]) }}</td>
            </tr> --}}
          </tbody>

        </table>

      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
        <button type="submit" class="btn btn-primary">Update & Close</button>
      </div>
      {!! Form::close()  !!}
    </div>
  </div>
</div>