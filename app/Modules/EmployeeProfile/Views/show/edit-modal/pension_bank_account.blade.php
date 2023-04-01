<div id="pension-bank-account-edit-modal_{{$pensionBankAccount->id}}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => url('pension-bank-account',$pensionBankAccount->id), 'method' => 'put']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pension Bank Acoount Infomation</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <input type="hidden" name="pension_bank_account_id" value="{{$pensionBankAccount->id}}">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>

          <tr>
            <th width="50%">Account Holder Name</th>
            <td>{{ Form::text("account_holder_name",$pensionBankAccount->account_holder_name,["class" => "form-control focus_it"]) }}</td>
          </tr>
           <tr>
            <th width="50%">Bank</th>
            <td>{{ Form::select('bank_id',$bank,$pensionBankAccount->bank_id, ['class' => 'form-control ', 'id' => 'bank_name']) }}</td>
          </tr>
          <tr>
            <th  width="50%">Branch</th>
            <td id="branch_list">{{ Form::select('branch_id',get_branch_list($pensionBankAccount->bank_id),$pensionBankAccount->branch_id, ['class' => 'form-control select2','style'=>'width:100%', 'id' => 'branch_name']) }}</td>
          </tr>

          <tr>
            <th width="50%">Account No (T24)</th>
            <td>{{ Form::text("account_no",$pensionBankAccount->account_no,["class" => "form-control focus_it"]) }}</td>
          </tr>
          <tr>
            <th width="50%">Account No Old</th>
            <td>{{ Form::text("account_no_old",$pensionBankAccount->account_no_old,["class" => "form-control focus_it"]) }}</td>
          </tr>
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