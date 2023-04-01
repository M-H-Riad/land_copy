<div id="leave-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{Form::open(['method'=>'put','url'=> route('employee-leave.update',$row->id)])}}
            <input type="hidden" value="{{$employee->id}}" name="employee_id">
            <input type="hidden" value="{{$row->id}}" name="leave_id">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Leave Information</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                    <tr>
                        <th style="width: 50%;">Leave Type</th>
                        <td>{{ Form::select("type_id",$leave_types,$row->type_id,["class" => "form-control focus_it"]) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Reference No</th>
                        <td>
                            {{ Form::text('ref_no',$row->ref_no, ['class' => 'form-control']) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Reference Date</th>
                        <td>
                            {{ Form::text('ref_date',dateFormat($row->ref_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">From Date</th>
                        <td>
                            {{ Form::text('from_date',dateFormat($row->from_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' ]) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">To Date</th>
                        <td>
                            {{ Form::text('to_date',dateFormat($row->to_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Leave Reason</th>
                        <td>
                            {{ Form::text('details',$row->details, ['class' => 'form-control']) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Approval</th>
                        <td>
                            <?php
                            $approval = ['Approved'=>'Approved','Not-Approved'=>'Not Approved'];
                            ?>
                            {{ Form::select('approval',$approval, $row->approval, ['class' => 'form-control']) }}
                        </td>
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