
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="pension-relative">
    <div class="portlet-title">
        <div class="caption">
            <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Pension Relatives</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_pension_relatives'))
            <a href="#pension-relative-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>

            @include('EmployeeProfile::show.add-new-modal.pension-relative')
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">

                <thead>
                    <tr>
                        <th>Name </th>
                        <th>Relation</th>
                        <th>Phone No.</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->relatives as $row)
                    <tr>
                        <td>{!! $row->name or '' !!}</td>
                        <td>{!! ucfirst($row->relation)!!}</td>
                        <td>{!! $row->phone_no or '' !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_pension_relatives'))
                            <a href="#pension-relative-modal{{$row->id}}" class="btn btn-info btn-xs modal-btn" style="float: left"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @if(Auth::user()->can('delete_pension_relatives'))
                            <form action="{{ url('employee/pension-relative/'.$row->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                            @endif
                            @include('EmployeeProfile::show.edit-modal.pension-relative')
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

<!-- END FORM-->