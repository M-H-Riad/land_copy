
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="children">
    <div class="portlet-title">
        <div class="caption">
            <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Children Information</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_children'))
            <a href="#children-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive text-center" width="100%">

                <thead>
                    <tr>
                        <th class=" text-center" with="30%">Name of Children</th>
                        <th class=" text-center" with="15%">Sex</th>
                        <th class=" text-center" with="20%">Date of Birth</th>
                        <th class=" text-center" with="15%">Profession</th>
                        <th class=" text-center" with="10%">Education Allowance</th>
                        <th class=" text-center" with="10%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employee->children as $children)
                    <tr>
                        <td>{!! $children->children_name or '' !!}</td>
                        <td>{!! ucfirst($children->sex)!!}</td>
                        <td>{!! dateFormat($children->date_of_birth) !!}</td>
                        <td>{!! $children->profession or '' !!}</td>
                        <td>{!! $children->edu_alw == 1 ? 'Yes':'No' !!}</td>
                        <td>
                            @if(Auth::user()->can('manage_children'))
                            <a href="#children-modal{{$children->id}}"  class="btn btn-default btn-xs modal-btn"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @include('EmployeeProfile::show.edit-modal.children')
                            @endif
                            @if(Auth::user()->can('delete_children'))
                            <form action="{{ route('employee-children.destroy', $children->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure to delete this information')"><i class="fa fa-trash-o"></i> Delete</button>
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


@include('EmployeeProfile::show.add-new-modal.children')
<!-- END FORM-->