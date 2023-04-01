
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="quarter">
    <div class="portlet-title">
        <div class="caption ">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Quarter Information </span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_quarter'))
            <a href="#quarter-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive nopagination text-center" width="100%">

                <thead>
                    <tr>
                        <th class="min-phone-l text-center" width="20%">Allotment Reference</th>
                        <th class="min-phone-l text-center" width="10%">Ref. Date</th>
                        <th class="min-phone-l text-center" width="10%">Positioning Date</th>
                        <th class="min-phone-l text-center" width="15%">Location (e.g. Mirpur)</th>
                        <th class="min-phone-l text-center" width="15%">Road #</th>
                        <th class="min-phone-l text-center" width="22%">Flat Specification</th>
                        <th class="text-center" width="8%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->quarter as $row)
                    <tr>
                        <td>{!! $row->allotment_reference or '' !!}</td>
                        <td>{!! dateFormat($row->reference_date)!!}</td>
                        <td>{!! dateFormat($row->posting_date)!!}</td>
                        <td>{!! $row->location or '' !!}</td>
                        <td>{!! $row->road or '' !!}</td>
                        <td>{!! $row->flat or '' !!}, {!! $row->building or '' !!}, {!! $row->flat_type or '' !!}, ({!! $row->size_sft or '' !!}sft.) </td>
                        <td>
                            @if(Auth::user()->can('manage_quarter'))
                            <a href="#quarter-modal{{$row->id}}" class="btn  btn-default btn-xs modal-btn"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.quarter')
                            @endif

                            @if(Auth::user()->can('delete_quarter'))
                            <form action="{{ route('employee-quarter.destroy', $row->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i> Delete</button>
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



@include('EmployeeProfile::show.add-new-modal.quarter')
<!-- END FORM-->