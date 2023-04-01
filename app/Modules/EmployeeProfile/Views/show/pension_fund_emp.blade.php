
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="pension_fund_emp">
    <div class="portlet-title">
        <div class="caption">
            <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Pension Fund</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_pension_fund_emp'))
            <a href="#pension-fund-emp-modal-add" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">

                <thead>
                    <tr>
                        <th>PPO No.</th>
                        <th>Pension Type</th>
                        <th>Pension Holder Name</th>
                        <th>Mobile No</th>
                        <th>Address</th>
                        <th>Pension Holder type</th>
                        <th>Opening net Pension</th>
                        <th>Current net Pension</th>
                        <th>Previous Pension Date</th>
                        <th>Pension Expire date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($employee->pensionFund) > 0)
                    @foreach($employee->pensionFund as $pension_fund)
                    <tr>
                        <td>{!! $pension_fund->ppo_no !!}</td>
                        <td>{!! $pension_fund->pensio_type->type or '' !!}</td>
                        <td>{!! $pension_fund->pension_holder_name!!}</td>
                        <td>{!! $pension_fund->mobile_no!!}</td>
                        <td>
                            <b>Present:</b><br/>
                            {!! $pension_fund->present_address!!} <br/>
                            <b>Permanent:</b><br/>
                            {!! $pension_fund->permanent_address!!}
                        </td>
                        <td>{!! $pension_fund->pension_holder_type!!}</td>
                        <td>{!! $pension_fund->opening_net_pension!!}</td>
                        <td>{!! $pension_fund->current_net_pension!!}</td>
                        <td>{!! $pension_fund->previous_date!!}</td>
                        <td>{!! $pension_fund->expire_date!!}</td>
                        <td>
                            @if(Auth::user()->can('manage_pension_fund_emp'))
                            <a href="#pension-fund-emp-edit-modal_{{$pension_fund->id}}" class="btn btn-info btn-xs modal-btn" style="float: left"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @if(Auth::user()->can('delete_pension_fund'))
                            <form action="{{ route('pension-fund-emp.destroy', $pension_fund->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                            @endif
                            @include('EmployeeProfile::show.edit-modal.pension_fund_emp')
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>

            </table>

        </div>
    </div>

</div>


@include('EmployeeProfile::show.add-new-modal.pension_fund_emp')
<!-- END FORM-->