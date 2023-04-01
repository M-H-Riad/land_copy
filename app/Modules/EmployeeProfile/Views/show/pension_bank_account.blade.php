
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="pension_bank_account">
    <div class="portlet-title">
        <div class="caption">
            <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Pension Bank Account Information</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_pension_bank_account'))
            @if(!count($employee->pensionBankAccount) > 0)
            <a href="#pension-bank-account-modal-add" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                <i class="fa fa-plus"></i> Add
            </a>
            @endif
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div style="overflow:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">

                <thead>
                    <tr>
                        <th>Account Holder Name</th>
                        <th>Bank</th>
                        <th>Branch</th>
                        <th>Account No (T24)</th>
                        <th>Account No Old</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($employee->pensionBankAccount) > 0)
                    @foreach($employee->pensionBankAccount as $pensionBankAccount)
                    <tr>
                        <td>{{ $pensionBankAccount->account_holder_name or '' }}</td>
                        <td>{!! $pensionBankAccount->bank->bank_name or '' !!}</td>
                        <td>{!! $pensionBankAccount->branch->branch_name or '' !!}</td>
                        <td>{!! $pensionBankAccount->account_no!!}</td>
                        <td>{{ $pensionBankAccount->account_no_old }}</td>
                        <td>
                            @if(Auth::user()->can('manage_pension_bank_account'))
                            <a href="#pension-bank-account-edit-modal_{{$pensionBankAccount->id}}" class="btn btn-info btn-xs modal-btn" style="float: left"  data-toggle="modal">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @if(Auth::user()->can('delete_pension_bank_account'))
                            <form action="{{ route('pension-bank-account.destroy', $pensionBankAccount->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                            @endif
                            @include('EmployeeProfile::show.edit-modal.pension_bank_account')
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


@include('EmployeeProfile::show.add-new-modal.pension_bank_account')
<!-- END FORM-->

@push('scripts')

<script>
    $("#bank_name").change(function (e) {
        var bankId = $("#bank_name").val();
        $("#branch_name").html('<option value="">Loading...</option>');
        var url = "{{url('employee-profile/create/get-bank-branch')}}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {bank_id: bankId}
        })
        .done(function (data) {
            var option = '<option value="">Select Branch</option>';
            if (data.branchList == null)
            {
                console.log("Branch not found");
            } else
            {
                $.each(data.branchList, function (index, value) {
                    option += "<option value='" + value.id + "'>" + value.branch_name + "</option>";
                });
            }
            $("#branch_name").html(option);
        });
    });
    $("#bank_name2").change(function (e) {
        var bankId = $("#bank_name2").val();
        $("#branch_name2").html('<option value="">Loading...</option>');
        var url = "{{url('employee-profile/create/get-bank-branch')}}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {bank_id: bankId}
        })
        .done(function (data) {
            var option = '<option value="">Select Branch</option>';
            if (data.branchList == null)
            {
                console.log("Branch not found");
            } else
            {
                $.each(data.branchList, function (index, value) {
                    option += "<option value='" + value.id + "'>" + value.branch_name + "</option>";
                });
            }
            $("#branch_name2").html(option);
        });
    });
</script>
@endpush