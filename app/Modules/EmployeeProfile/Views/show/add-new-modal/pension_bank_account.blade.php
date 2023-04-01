<div id="pension-bank-account-modal-add" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => 'pension-bank-account', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pension Bank Infomation</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <table class="table table-bordered table-hover dt-responsive" width="100%">

          <tbody>
            <tr>
              <th width="50%">Account Holder Name</th>
              <td>{{ Form::text("account_holder_name",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Bank</th>
              <td>{{ Form::select('bank_id',$bank,null, ['class' => 'form-control ', 'id' => 'bank_name2']) }}</td>
            </tr>
            <tr>
              <th  width="50%">Branch</th>
              <td id="branch_list">{{ Form::select('branch_id',[''=>'Select Branch'],null, ['class' => 'form-control select2','style'=>'width:100%', 'id' => 'branch_name2']) }}</td>
            </tr>

            <tr>
              <th width="50%">Account No (T24)</th>
              <td>{{ Form::text("account_no",null,["class" => "form-control focus_it"]) }}</td>
            </tr>
            <tr>
              <th width="50%">Account No Old</th>
              <td>{{ Form::text("account_no_old",null,["class" => "form-control focus_it"]) }}</td>
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