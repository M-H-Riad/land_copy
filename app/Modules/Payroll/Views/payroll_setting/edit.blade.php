<div id="edit-payroll_setting-modal-{{$payroll_setting->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::model($payroll_setting,['url' => 'payroll-setting/'.$payroll_setting->id, 'method' => 'put']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Update Payroll Setting</h4>
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
                        <th style="width: 50%;">Basic Pay</th>
                        <td>{{ Form::text("basic_pay",null,["class" => "form-control focus_it"]) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Grade</th>
                        <td>
                            {!! Form::select('grade',$grades,null, ['class' => 'form-control select2','placeholder' => 'Select Grade','style' => 'width:40%']) !!}
                            To
                            {!! Form::select('grade_max',$grades,null, ['class' => 'form-control select2','placeholder' => 'Select Grade','style' => 'width:40%']) !!}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Rate</th>
                        <td>{{ Form::text("rate",null,["class" => "form-control focus_it"]) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Minimum Amount</th>
                        <td>{{ Form::text("min",null,["class" => "form-control focus_it"]) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Maximum Amount</th>
                        <td>{{ Form::text("max",null,["class" => "form-control focus_it"]) }}</td>
                    </tr>
                    <tr><tr>
                        <th style="width: 50%;">Is Fixed?</th>
                        <td>{{ Form::checkbox("is_fixed",1) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Special</th>
                        <td>

                            {!! Form::select('ref_id',$ref_types,0, ['class' => 'form-control select2','style' => 'width:100%']) !!}

                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Comments</th>
                        <td>{{ Form::text("comments",null,["class" => "form-control focus_it"]) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Status</th>
                        <td>{!! Form::select('active',['0' => 'Inactive','1' => 'Active'],null, ['class' => 'form-control','placeholder' => 'Select Status']) !!}</td>
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