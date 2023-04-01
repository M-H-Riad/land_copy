
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet grey-cascade box" id="leave">
    <div class="portlet-title">
        <div class="caption">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Leave Information</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_job'))
            <a href="#leave-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive nopagination text-center" width="100%">
                {{--{ leave title,ref no. , ref date , from date . to date , Recreation leave , status ( 0,1,2 ) }--}}
                <thead>
                    <tr>
                        <th class=" text-center" with="15%">Leave Type</th>
                        <th class=" text-center" with="15%">Ref No</th>
                        <th class=" text-center" with="10%">Ref Date</th>
                        <th class=" text-center" with="10%">Date From</th>
                        <th class=" text-center" with="10%">Date To</th>
                        <th class=" text-center" with="10%">Approval</th>
                        <th class=" text-center" with="20%">Details</th>
                       <th class=" text-center" with="10%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->leave as $row)
                    <tr>
                        <td>{!! $row->type->title or '' !!}</td>
                        <td>{!! $row->ref_no or '' !!}</td>
                        <td>{!! dateFormat($row->ref_date) !!}</td>
                        <td>{!! dateFormat($row->from_date) !!}</td>
                        <td>{!! dateFormat($row->to_date) !!}</td>
                        <td>{!! $row->approval or '' !!}
                        {{--</td>--}}
                        <td>{!! $row->details or '' !!}</td>


                        <td>
                            @if(Auth::user()->can('manage_leave'))
                            <a href="#leave-modal{{$row->id}}" class="btn btn-default btn-xs modal-btn"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.leave')
                            @endif
                            @if(Auth::user()->can('delete_job'))
                            <form action="{{ route('employee-leave.destroy', $row->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button onclick="return confirm('Are you sure to Delete?')" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i> Delete</button>
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


@include('EmployeeProfile::show.add-new-modal.leave')


<!-- END FORM-->