<div id="edit-modal-{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::model($row,['route' => ['overtime.update',$row->id], 'method' => 'put']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Update Information</h4>
      </div>
      <div class="modal-body">
          <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

              <tbody>
              <tr>
                  <th style="width: 50%;">Bank Account Number <span style="color:red">*</span></th>
                  <td>
                      {{ Form::text('bank_account_number',null, ['class' => 'form-control', 'id' => 'bank_account_number','placeholder'=>'Bank Account Number','required']) }}

                  </td>
              </tr>
              <tr>
                  <th style="width: 50%;">Memo No <span style="color:red">*</span></th>
                  <td>
                      {{ Form::text('memo_no',null, ['class' => 'form-control', 'id' => 'memo_no','placeholder'=>'Memo No','required']) }}

                  </td>
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