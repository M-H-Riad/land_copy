
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet grey-cascade box" id="job">
    <div class="portlet-title">
        <div class="caption">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Job & Promotion Information </span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_job'))
            <a href="#job-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
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
                        <th class="min-phone-l" width="10%" style="text-align: center">Office Order No</th>
                        <th class="min-phone-l" width="10%" style="text-align: center">Order Date</th>
                        <th class="min-phone-l" width="10%" style="text-align: center">Joining Date</th>
                        <th class="min-phone-l" width="8%" style="text-align: center">Switched from Transfer Table</th>
                        <th class="min-phone-l" width="12%" style="text-align: center">Designation</th>
                        <th class="min-phone-l" width="12%" style="text-align: center">Office/Zone</th>
                        <th class="min-phone-l" width="5%" style="text-align: center">Grade</th>
                        <th class="min-phone-l" width="5%" style="text-align: center">Class</th>
                        <th class="min-phone-l" width="10%" style="text-align: center">Basic Pay (Taka)</th>
                        <th width="8%" style="text-align: center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->wasaJobExprience as $key => $row)

                    <tr @if($row->current_job == 1) style="background-color: lightgreen" @endif>
                        <td>{!! $row->office_order_no or '' !!}</td>
                        <td>{!! dateFormat($row->order_date) !!}</td>
                        <td>{!! dateFormat($row->joining_date) !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_transfer') && $row->transfer_id != null)
                                <a href="#show-transfer-modal{{$row->transfer_id}}" class="btn btn-info btn-xs modal-btn" data-toggle="modal">
                                    Yes
                                </a>
                            @else
                                No
                            @endif

                        </td>
                        <td>{!! $row->designation->title or '' !!}
{{--                            @if($row->designation_status and $row->designation_status !=='1')--}}
{{--                           --}}
{{--                            ({!! getDesignatioStatusTitle($row->designation_status) !!})--}}
{{--                            @endif--}}
                        </td>
                        <td>{!! $row->department->department_name or '' !!}</td>

                        <td>{!! $row->grade or '' !!}</td>
                        <td>{!! $row->class or '' !!}</td>


                        <td>{!! taka_format($row->basic_pay) !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_job'))
                            <a href="#job-modal{{$row->id}}" class="btn btn-default btn-xs modal-btn" data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.job')
                            @endif
                            @if(Auth::user()->can('delete_job'))
                                @if($row->current_job != 1)
                                        <form action="{{ route('employee-job-experience.destroy', $row->id) }}" method="POST">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this information')"><i class="fa fa-trash-o"></i> Delete</button>
                                        </form>
                                @endif
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


@include('EmployeeProfile::show.add-new-modal.job')

<script>
    $(function () {
        $(".scale-year").trigger('change');

    });

</script>
<!-- END FORM-->