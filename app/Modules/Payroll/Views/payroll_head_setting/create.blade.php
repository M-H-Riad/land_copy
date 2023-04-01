<div id="add-payroll_head_setting-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['url' => 'payroll-head-setting', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Add new Payroll Head Setting</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
           <tr>
            <th style="width: 50%;">Payroll Head</th>
            <td>
              {!! Form::select('payroll_head_id',$payroll_heads,null, ['class' => 'form-control select2','placeholder' => 'Select Head','style' => 'width:100%']) !!}
            </td>
          </tr>
          <tr>
            <th style="width: 50%;">Amount</th>
            <td>{{ Form::text("amount",null,["class" => "form-control focus_it"]) }}</td>
          </tr>
          <tr>
            <th style="width: 50%;">Type</th>
            <td>
              {!! Form::select('type',$types,null, ['class' => 'form-control','placeholder' => 'Select Type']) !!}
            </td>
          </tr>
          <tr>
            <th style="width: 50%;">Start Month</th>
            <td>

              {{ Form::selectMonth('start_month',null, ['class' => 'form-control','placeholder'=>'Select Month','style'=>'width:100% !important;' ]) }}

            </td>
          </tr>
          <tr>
            <th style="width: 50%;">Start Year</th>
            <td>

              {{ Form::selectYear('start_year',date('Y'),2018,null, ['class' => 'form-control','placeholder'=>'Select Year']) }}

            </td>
          </tr>
          <th style="width: 50%;">End Month</th>
          <td>

            {{ Form::selectMonth('end_month',null, ['class' => 'form-control','placeholder'=>'Select Month','style'=>'width:100% !important;' ]) }}

          </td>
        </tr>
        <tr>
          <th style="width: 50%;">End Year</th>
          <td>

           {{ Form::selectYear('end_year',date('Y'),2018,null, ['class' => 'form-control','placeholder'=>'Select Year']) }}

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