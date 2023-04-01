<div id="transfer-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
{{--            {{Form::open(['method'=>'put','url'=> url('employee-transfer', $row->id)])}}--}}
            {!! Form::model($row,['url' => url('employee-transfer',$row->id), 'method' => 'put']) !!}
            <input type="hidden" name="employee_id" value="{{$employee->id}}">
            <input type="hidden" name="transfer_id" value="{{$row->id}}">
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
                            <td>{{ Form::text("office_order_no",$row->office_order_no,["class" => "form-control focus_it",'required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Date</th>
                            <td>
                               
                                    {{ Form::text('date',dateFormat($row->order_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' ,'id' => 'date']) }}
                                
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Transfer with Promotion (Y/N)</th>
                            <td>{{ Form::select("transfer_with_promotion",[1=>"Yes",0=>"No"], $row->is_promotion,["class" => "form-control",'style'=>'width:100%','disabled'=>'disabled']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Designation</th>
                            <td>{{ Form::select("designation",$designation,$row->designation_id,["class" => "form-control",'style'=>'width:100%','required'=>'required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%">From (Division/Zone/Office)</th>
                            <td>{{ Form::select("old_division_id",$office_zone,null,["class" => "form-control",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%">To (Division/Zone/Office)</th>
                            <td>{{ Form::select("division",$office_zone,$row->division_id,["class" => "form-control",'required'=>'required','style'=>'width:100%']) }}</td>
                        </tr>
                    </tbody>

                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary">Update & Close</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>


<div id="show-transfer-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Transfer Records</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%" >

                    <tbody>

                    <tr>
                        <th style="width: 50%">Office Order No</th>
                        <td>{{ Form::text("office_order_no",$row->office_order_no,["class" => "form-control focus_it",'disabled']) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%">Date</th>
                        <td>

                            {{ Form::text('date',dateFormat($row->order_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' ,'disabled']) }}

                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%">Transfer with Promotion (Y/N)</th>
                        <td>{{ Form::select("transfer_with_promotion",[1=>"Yes",0=>"No"], $row->is_promotion,["class" => "form-control",'style'=>'width:100%','disabled'=>'disabled']) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%">Designation</th>
                        <td>{{ Form::select("designation",$designation,$row->designation_id,["class" => "form-control",'style'=>'width:100%','disabled'=>'disabled']) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%">From (Division/Zone/Office)</th>
                        <td>{{ Form::select("old_division_id",$office_zone,$row->old_division_id,["class" => "form-control",'style'=>'width:100%','disabled']) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%">To (Division/Zone/Office)</th>
                        <td>{{ Form::select("division",$office_zone,$row->division_id,["class" => "form-control",'disabled'=>'disabled','style'=>'width:100%']) }}</td>
                    </tr>
                    </tbody>

                </table>

            </div>
            <div class="modal-footer">

            </div>

        </div>
    </div>
</div>