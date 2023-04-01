
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet grey-cascade box" id="job">
    <div class="portlet-title">
        <div class="caption">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Pension Order Information</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_pension_job'))
            <a href="#pension-job-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive nopagination" width="100%">

                <thead>
                    <tr>
                        <th class="min-phone-l">Office Order No</th>
                        <th class="min-phone-l">Order Date</th>
                        <th class="min-phone-l">Retirement Date</th>
                        <th class="min-phone-l">Designation</th>
                        <th class="min-phone-l">Office/Zone</th>
                        <th class="min-phone-l">Grade</th>
                        <th class="min-phone-l">Basic Pay (Taka)</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->pensionJob as $row)
                    <tr>
                        <td>{!! $row->office_order_no or '' !!}</td>
                        <td>{!! dateFormat($row->order_date) !!}</td>
                        <td>{!! dateFormat($row->retirement_date) !!}</td>
                        <td>{!! $row->designation->title or '' !!}
                            @if($row->designation_status and $row->designation_status !=='Normal')
                            ({!! $row->designation_status or '' !!})
                            @endif
                        </td>
                        <td>{!! $row->department->department_name or '' !!}</td>

                        <td>{!! $row->grade or '' !!}</td>

                        <td>{!! taka_format($row->basic_pay) !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_pension_job'))
                            <a href="#pension-job-modal{{$row->id}}" class="btn btn-info btn-xs modal-btn" style="float: left"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <!--            <a href="{{url('pension-job-experience/delete/'.$row->id)}}" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>-->

                            @if(Auth::user()->can('delete_pension_job'))
                            <form action="{{ route('pension-job-experience.destroy', $row->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                            @endif
                            @include('EmployeeProfile::show.edit-modal.pension_job')
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


@include('EmployeeProfile::show.add-new-modal.pension_job')
<!-- END FORM-->
<script>
    $(function () {
        $(".scale-year").trigger('change');

    });

</script>