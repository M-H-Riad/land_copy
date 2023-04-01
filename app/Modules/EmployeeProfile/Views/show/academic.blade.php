
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="academic">
    <div class="portlet-title">
        <div class="caption">
          <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Academic Carrier</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_academic'))
            <a href="#academic-modal" class="btn btn-circle btn-default btn-sm modal-btn" data-toggle="modal">
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
                        <th class=" text-center" with="15%">Qualification</th>
                        <th class=" text-center" with="13%">Discipline</th>
                        <th class=" text-center" with="15%">Board/University</th>
                        <th class=" text-center" with="20%">Institution</th>
                        <th class=" text-center" with="13%">Major In</th>
                        <th class=" text-center" with="8%">Passing Year</th>
                        <th class=" text-center" with="8%">Class/Div/ Grade</th>
                        <th class=" text-center" with="8%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->education as $row)
                    <tr>
                        <td>{!! $row->qualification->title or '' !!}</td>
                        <td>{!! $row->discipline or '' !!}</td>
                        <td>{!! $row->board or '' !!}</td>
                        <td>{!! $row->institute or '' !!}</td>
                        <td>{!! $row->major or '' !!}</td>
                        <td>{!! $row->passing_year or '' !!}</td>
                        <td>{!! $row->grade or '' !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_academic'))
                            <a href="#academic-modal{{$row->id}}" class="btn btn-default btn-xs modal-btn"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.academic')
                            @endif

                            @if(Auth::user()->can('delete_academic'))
                            <form action="{{ route('employee-education.destroy', $row->id) }}" method="POST">
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


@include('EmployeeProfile::show.add-new-modal.academic')
<!-- END FORM-->