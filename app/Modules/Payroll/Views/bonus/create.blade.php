
<div id="add-salary-month" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['route' => 'bonus.store', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Add Festival Bonus</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

          <tbody>
          <tr>
            <th style="width: 50%;">Festival Bonus</th>
            <td>

              {{ Form::select('bonus_type',$bonusSettings,null, ['class' => 'form-control','placeholder'=>'Select Festival Bonus','style'=>'width:100%','required' ]) }}

            </td>
          </tr>
          <tr>
            <th style="width: 50%;">Month</th>
            <td>

              {{ Form::selectMonth('month',null, ['class' => 'form-control','placeholder'=>'Select Month','style'=>'width:100%','required' ]) }}

            </td>
          </tr>
          <tr>
            <th style="width: 50%;">Year</th>
            <td>

              {{ Form::selectYear('year',date('Y'),2019,null, ['class' => 'form-control','placeholder'=>'Select Year','style'=>'width:100%','required']) }}

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