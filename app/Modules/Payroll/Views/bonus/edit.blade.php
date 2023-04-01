<div id="edit-bonus-modal-{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::model($row,['route' => ['bonus.update',$row->id], 'method' => 'put']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Update Bonus Type</h4>
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
                 {{ Form::selectMonth('month',null, ['class' => 'form-control','placeholder'=>'Select Month','style'=>'width:100%','disabled' ]) }}
             </td>
         </tr>
         <tr>
             <th style="width: 50%;">Year</th>
             <td>

                 {{ Form::text('year',null, ['class' => 'form-control','placeholder'=>'Select Year','style'=>'width:100%','disabled']) }}

             </td>
         </tr>

     </tbody>

   </table>

 </div>
 <div class="modal-footer">
  <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
  <button type="submit" class="btn btn-primary" onclick="return confirm('You can update bonus type only time. Are sure to do that ? ')">Save & Close</button>
</div>
{!! Form::close()  !!}
</div>
</div>
</div>
