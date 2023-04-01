
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="training">
    <div class="portlet-title">
        <div class="caption ">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Training</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_training'))
            <a href="#training-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
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
                        <th class="min-phone-l text-center">Training Course Title</th>
                        <th class="min-phone-l text-center">Training Type</th>
                        <th class="min-phone-l text-center">Country</th>
                        <th class="min-phone-l text-center">Place/City</th>
                        <th class="min-phone-l text-center">Institution</th>
                        <th class="min-phone-l text-center">Financed By</th>
                        <th class="min-phone-l text-center">Amount</th>
                        <th class="min-phone-l text-center">Year</th>
                        <th class="min-phone-l text-center">Duration (Month)</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->training as $row)
                    <tr>
                        <td>{!! $row->course_title or '' !!}</td>
                        <td>{!! $row->training_type or '' !!}</td>
                        <td>{!! $row->country or '' !!}</td>
                        <td>{!! $row->place or '' !!}</td>
                        <td>{!! $row->institution or '' !!}</td>
                        <td>{!! $row->finance_by or '' !!}</td>
                        <td>{!! taka_format($row->amount) !!}</td>
                        <td>{!! $row->year or '' !!}</td>
                        <td>{!! $row->duration or '' !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_training'))
                            <a href="#training-modal{{$row->id}}" class="btn btn-default btn-xs modal-btn" data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.training')
                            @endif
                            @if(Auth::user()->can('delete_training'))
                            <form action="{{ route('employee-training.destroy', $row->id) }}" method="POST">
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


@include('EmployeeProfile::show.add-new-modal.training')
<!-- END FORM-->