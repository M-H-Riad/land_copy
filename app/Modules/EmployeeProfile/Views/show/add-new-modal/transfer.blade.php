<div id="transfer-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{Form::open(['method'=>'post','route'=>'employee-transfer.store'])}}
            <input type="hidden" name="employee_id" value="{{$employee->id}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Transfer Records</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                    <tr>
                        <th style="width: 50%">Currently Transfer</th>
                        <td>
                            <label>{{ Form::radio("current_transfer",1,false,["class" => "form-control1 h_rent_type",'required']) }} Yes </label>
                            <label>{{ Form::radio("current_transfer",0,false,["class" => "form-control1 h_rent_type",'required']) }} No </label>
                        </td>
                    </tr>
                        <tr>
                            <th style="width: 50%">Office Order No</th>
                            <td>{{ Form::text("office_order_no",null,["class" => "form-control focus_it",'required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Date</th>
                            <td>
                               
                                    {{ Form::text('date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy', 'id' => 'date','required']) }}
                              
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Transfer with Promotion (Y/N)</th>
                            <td>{{ Form::select("transfer_with_promotion",[''=>"Select",1=>"Yes",0=>"No",],null,["class" => "form-control",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Designation</th>
                            <td>{{ Form::select("designation",$designation,$employee->designation->id ?? null,["class" => "form-control",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%">From (Division/Zone/Office)</th>
                            <td>{{ Form::select("old_division_id",$office_zone,$employee->department->id ?? null,["class" => "form-control",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%">To (Division/Zone/Office)</th>
                            <td>{{ Form::select("division",$office_zone,null,["class" => "form-control",'style'=>'width:100%','required']) }}</td>
                        </tr>
                    </tbody>

                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary" >Save & Close</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>