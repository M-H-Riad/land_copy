
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="suspension">
    <div class="portlet-title">
        <div class="caption">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Disciplinary Records</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_disciplinary_records'))
            <a href="#suspension-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div class="col-md-12">
            <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive nopagination text-center" width="100%">

                <thead>
                    <tr>
                        <th colspan="4" style="text-align: center">Departmental Case</th>
                        <th colspan="3" style="text-align: center">Result of Departmental Case</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th class=" text-center" with="13%">Reference No</th>
                        <th class=" text-center" with="10%">Reference Date</th>
                        <th class=" text-center" with="10%">Case No.</th>
                        <th class=" text-center" with="15%">Allegation/Grievance as per <br> DWASA Regulations</th>
                        <th class=" text-center" with="13%">Reference No</th>
                        <th class=" text-center" with="13%">Reference Date</th>
                        <th class=" text-center" with="16%">Result</th>
                        <th class=" text-center" with="10%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->disciplinary_record as $row)
                    <tr>
                        <td>{!! $row->ref_no or '' !!}</td>
                        <td>{!! dateFormat($row->ref_date) !!}</td>
                        <td>{!! $row->case_no or '' !!}</td>
                        <td>{!! $row->allegation or '' !!}</td>
                        <td>{!! $row->result_ref_no or '' !!}</td>
                        <td>{!! dateFormat($row->result_ref_date) !!}</td>
                        <td>{!! $row->result or '' !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_disciplinary_records'))
                            <a href="#suspension-modal{{$row->id}}" class="btn  btn-default btn-xs modal-btn"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.disciplinary_records')
                            @endif
                            @if(Auth::user()->can('delete_disciplinary_records'))
                            <form action="{{ route('employee-disciplinary-records.destroy', $row->id) }}" method="POST">
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

</div>

@include('EmployeeProfile::show.add-new-modal.disciplinary_records')
<!-- END FORM-->