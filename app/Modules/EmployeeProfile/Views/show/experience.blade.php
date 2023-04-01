
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="experience">
    <div class="portlet-title">
        <div class="caption ">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Past Public Sector Experience Outside Dhaka WASA</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_experience'))
            <a href="#experience-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
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
                        <th class="min-phone-l text-center">Organization</th>
                        <th class="min-phone-l text-center">Designation</th>
                        <th class="min-phone-l text-center">From Date</th>
                        <th class="min-phone-l text-center">To Date</th>
                        <th class="min-phone-l text-center">Grade</th>
                        <th class="min-phone-l text-center">Channel</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->serviceExperience as $row)
                    <tr>
                        <td>{!! $row->organization or '' !!}</td>
                        <td>{!! $row->designation or '' !!}</td>
                        <td>{!! dateFormat($row->from_date) !!}</td>
                        <td>{!! dateFormat($row->to_date)!!}</td>

                        <td>{!! $row->grade or '' !!} </td>



          <!--<td>{!! $row->grade or '' !!}</td>-->
                        <td>{!! $row->channel? 'Yes':'No' !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_experience'))
                            <a href="#experience-modal{{$row->id}}" class="btn  btn-default btn-xs modal-btn"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.experience')
                            @endif
                            @if(Auth::user()->can('delete_experience'))
                            <form action="{{ route('employee-service-experience.destroy', $row->id) }}" method="POST">
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


@include('EmployeeProfile::show.add-new-modal.experience')
<!-- END FORM-->

<script>
    $(function () {
        $(".scale-year-e").trigger('change');

    });

</script>