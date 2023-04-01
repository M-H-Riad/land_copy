<div id="leave-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{Form::open(['method'=>'post','route'=>'employee-leave.store'])}}
            <input type="hidden" value="{{$employee->id}}" name="employee_id">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Leave Information</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive nopagination" width="100%">

                    <tbody>
                    <tr>
                        <th style="width: 50%;">Leave Type</th>
                        <td>{{ Form::select("type_id",$leave_types,null,["class" => "form-control focus_it"]) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Reference No</th>
                        <td>
                            {{ Form::text('ref_no',null, ['class' => 'form-control']) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Reference Date</th>
                        <td>
                            {{ Form::text('ref_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">From Date</th>
                        <td>
                            {{ Form::text('from_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' ]) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">To Date</th>
                        <td>
                            {{ Form::text('to_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Leave Reason</th>
                        <td>
                            {{ Form::text('details',null, ['class' => 'form-control']) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Approval</th>
                        <td>
                            <?php
                            $approval = ['Approved'=>'Approved','Not-Approved'=>'Not Approved'];
                            ?>
                            {{ Form::select('approval',$approval, null, ['class' => 'form-control']) }}
                        </td>
                    </tr>
                    </tbody>

                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary">Save & Close</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
