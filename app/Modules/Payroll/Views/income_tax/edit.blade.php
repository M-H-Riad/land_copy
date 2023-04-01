<div id="edit-income-tax-modal-{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::model($row,['url' => 'income-tax-report/'.$row->id, 'method' => 'put']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Update Income Tax Report Information</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

         <tbody>
          <tr>
            <th style="width: 50%;">Cheque No</th>
            <td>{{ Form::text("cheque_no",null,["class" => "form-control focus_it"]) }}</td>
          </tr>
          <tr>
              <th style="width: 50%;">Cheque Date</th>
              <td>{{ Form::text("cheque_date",dateFormat($row->cheque_date),["class" => "form-control focus_it mask_date"]) }}</td>
          </tr>
          <tr>
              <th style="width: 50%;">Bank</th>
              <td>
                  {{ Form::select('bank_id',$bank,null, ['class' => 'form-control ', 'id' => 'bank_name']) }}
              </td>
          </tr>
          <tr>
              <th style="width: 50%;">Branch Name</th>
              @php
              if($row->bank_id != null){
                  $branch = \App\Modules\EmployeeProfile\Models\BankBranch::where('bank_id',  $row->bank_id)->orderBy('branch_name', 'ASC')->pluck('branch_name', 'id')->toArray();
              }else{
                    $branch = array();
              }
              @endphp
              <td>
                  {{ Form::select('bank_branch_id',$branch,null, ['class' => 'form-control select2','style'=>'width:100%', 'id' => 'branch_name']) }}
              </td>
          </tr>
          <tr>
              <th style="width: 50%;">Bank Account No</th>
              <td>{{ Form::text("bank_account_no",null,["class" => "form-control focus_it"]) }}</td>
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
    $("#bank_name").change(function (e) {
        var bankId = $("#bank_name").val();
        $("#branch_name").html('<option value="">Loading...</option>');
        var url = "{{url('employee-profile/create/get-bank-branch')}}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {bank_id: bankId}
        })
            .done(function (data) {
                var option = '<option value="">Select Branch</option>';
                if (data.branchList == null)
                {
                    console.log("Branch not found");
                } else
                {
                    $.each(data.branchList, function (index, value) {
                        option += "<option value='" + value.id + "'>" + value.branch_name + "</option>";
                    });
                }
                $("#branch_name").html(option);
            });
    });
</script>