
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="transfer">
    <div class="portlet-title">
        <div class="caption">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Transfer Records</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_transfer'))
            <a href="#transfer-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive nopagination" width="100%" style="text-align: center">

                <thead>
                    <tr>

                        <th class="min-phone-l text-center" width="20%">Office Order No</th>
                        <th class="min-phone-l text-center" width="10%">Date</th>
                        <th class="min-phone-l text-center" width="15%">Transfer with Promotion (Y/N)</th>
                        <th class="min-phone-l text-center" width="15%">Designation</th>
                        <th class="min-phone-l text-center" width="15%">From (Division/Zone/Office)</th>
                        <th class="min-phone-l text-center" width="15%">To (Division/Zone/Office)</th>
                        <th class="text-center" width="10%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->transfer as $key => $row)
                    <tr @if($row->current_transfer == 1) style="background-color: lightgreen" @endif>
                        <td>{!! $row->office_order_no or '' !!}</td>
                        <td>{!! dateFormat($row->order_date) !!}</td>
                        <td>{!! $row->is_promotion? 'Yes':'No' !!}</td>
                        <td>{!! $row->designation->title or '' !!}</td>
                        <td>{!! $row->oldDepartment->department_name or '' !!}</td>
                        <td>{!! $row->department->department_name or '' !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_transfer'))
                            <a href="#transfer-modal{{$row->id}}" class="btn btn-default btn-xs modal-btn"   data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.transfer')
                            @endif
                            @if(Auth::user()->can('delete_transfer'))
                            <form action="{{ route('employee-transfer.destroy', $row->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure to delete this information')" id="transferSubmit"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>


@include('EmployeeProfile::show.add-new-modal.transfer')
<!-- END FORM-->