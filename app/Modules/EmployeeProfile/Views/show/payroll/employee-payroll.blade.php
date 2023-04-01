<?php
$payrollSetting = $employee->payrollSetting;
?>
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="emp-payroll-settings">
    <div class="portlet-title">
        <div class="caption">
            <!-- <i class="icon-settings font-green"></i> -->
            <span class="caption-subject bold uppercase">Payroll Setting</span>
        </div>
        <div class="actions">
            @if(Auth::user()->can('manage_employee_payroll'))
                <a href="#payroll-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
                    @if( null !== $payrollSetting &&  count($payrollSetting)>0)
                        <i class="fa fa-edit"></i> Edit
                    @else
                        <i class="fa fa-plus"></i> Add
                    @endif
                </a>

                @include('EmployeeProfile::show.payroll.modal')
            @endif
        </div>
    </div>
    <div class="portlet-body">
        @if($payrollSetting)

            <table class="table table-striped table-bordered">
                <tr>
                    <th>Salary Heads</th>
                    <th>Value</th>
                </tr>
                {{--<tr>--}}
                {{--<td colspan="2"><h5>Allowance</h5></td>--}}
                {{--</tr>--}}
                <tbody>
                <tr>
                    <td>Technical Pay Amount</td>
                    <td style="color:red">
                        @if($payrollSetting->tech_pay_amount == 2)
                            Double
                        @elseif($payrollSetting->tech_pay_amount == 1)
                            Single
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Special Payment</td>
                    <td style="color:red">{{ $payrollSetting->spl_pay ? $payrollSetting->spl_pay_amount:'No'}}  </td>
                </tr>
                <tr>
                    <td>Personal Pay</td>
                    <td style="color:red">{{  $payrollSetting->personal_pay ? $payrollSetting->per_pay : 'No'}}</td>
                </tr>

                <tr>
                    <td>Salary Arrears</td>
                    <td style="color:red">{{ $payrollSetting->salary_arrears ? $payrollSetting->salary_arr: 'No'}}</td>
                </tr>
                <tr>
                    <td>Provident Fund Refund</td>
                    <td style="color:red">{{$payrollSetting->pf_fund_refund ?  $payrollSetting->pf_refund: 'No'}}</td>
                </tr>
                <tr>
                    <td>HBL Refund</td>
                    <td style="color:red">{{$payrollSetting->hb_lone_refund ?  $payrollSetting->hb_refund: 'No'}}</td>
                </tr>
                <tr>
                    <td>Vehicle Allowance</td>
                    <td style="color:red">{{$payrollSetting->vehicle_allowance ?  $payrollSetting->vhl_alw: 'No'}}</td>
                </tr>
                <tr>
                    <td>Vehicle Refund</td>
                    <td style="color:red">{{$payrollSetting->vehicle_refund ?  $payrollSetting->vhl_refund: 'No'}}</td>
                </tr>
                <tr>
                    <td>House Rent Arrears</td>
                    <td style="color:red">{{$payrollSetting->house_rent_arr ?  $payrollSetting->hr_arr: 'No'}}</td>
                </tr>
                <tr>
                    <td>Gas Allowance</td>
                    <td style="color:red">{{($payrollSetting->gas_alw ? 'Yes':'No')}}</td>
                </tr>
                <tr>
                    <td>Other Allowance</td>
                    <td style="color:red">{{$payrollSetting->other_allowance ?  $payrollSetting->other_alw: 'No'}}</td>
                </tr>

                </tbody>

                <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center">Deduction</td>
                </tr>
                <tr>
                    <td>Provident Fund</td>
                    <td style="color:red">{{$payrollSetting->prv_fund}} {{($payrollSetting->prv_fund_type)?'%':'tk'}}</td>
                </tr>
                <tr>
                    <td>Transport</td>
                    <td style="color:red">{{$payrollSetting->transport_ded ?  $payrollSetting->transport : 'No'}}</td>
                </tr>
                <tr>
                    <td>Salary Deduction</td>
                    <td style="color:red">{{$payrollSetting->salary_ded ?  $payrollSetting->sal_ded: 'No'}}</td>
                </tr>
                <tr>
                    <td>WASA Quarter</td>
                    <td style="color:red">
                        @if($payrollSetting->h_rent && $payrollSetting->h_rent_type == 1)
                            Yes (Building)
                        @elseif($payrollSetting->h_rent && $payrollSetting->h_rent_type == 2)
                            Yes (Tin Shed)
                        @else
                            No
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Titas Gas</td>
                    <td style="color:red">{{($payrollSetting->titas_gas) ? 'Yes ('.$payrollSetting->stove.' Stove)':'No'}} </td>
                </tr>
                <tr>
                    <td>Income Tax Deduct</td>
                    <td style="color:red">{{$payrollSetting->it_ded}}</td>
                </tr>
                <tr>
                    <td>Income Tax Arrears Deduct</td>
                    <td style="color:red">{{$payrollSetting->it_arr_ded ?  $payrollSetting->it_arrear_ded:'No'}}</td>
                </tr>
                <tr>
                    <td>Other Deduction</td>
                    <td style="color:red">{{$payrollSetting->other_deduction ? $payrollSetting->other_ded:'No'}}</td>
                </tr>
                <tr>
                    <td>Vehicle Lone Deduction Deduction</td>
                    <td style="color:red">{{ $payrollSetting->vhcl_loan_ded ? $payrollSetting->vhcl_loan :'No'}}</td>
                </tr>
                <tr>
                    <td>Vehicle Lone Deduction Interest Deduction</td>
                    <td style="color:red">{{ $payrollSetting->vhcl_interest_ded ? $payrollSetting->vhcl_inttr :'No'}}</td>
                </tr>
                <tr>
                    <td>House Building  Loan Deduction</td>
                    <td style="color:red">{{$payrollSetting->hb_loan_ded ? $payrollSetting->hb_loan :'No'}}</td>
                </tr>
                <tr>
                    <td>House Building Interest Deduction</td>
                    <td style="color:red">{{$payrollSetting->hb_interest_ded ? $payrollSetting->hb_inttr:'No'}}</td>
                </tr>
                <tr>
                    <td>Personal Computer Lone Deduction</td>
                    <td style="color:red">{{ $payrollSetting->pc_loan_ded ? $payrollSetting->pc_loan:'No'}}</td>
                </tr>
                <tr>
                    <td>Personal Computer Lone Interest Deduction</td>
                    <td style="color:red">{{ $payrollSetting->pc_interest_ded ? $payrollSetting->pc_inttr:'No'}}</td>
                </tr>
                <tr>
                    <td>Provident Fund Lone Deduction</td>
                    <td style="color:red">{{ $payrollSetting->pf_loan_ded ? $payrollSetting->pf_loan:'No'}}</td>
                </tr>
                <tr>
                    <td>Provident Fund Lone Interest Deduction</td>
                    <td style="color:red">{{$payrollSetting->pf_interest_ded ? $payrollSetting->pf_inttr :'No'}}</td>
                </tr>

                </tfoot>

            </table>

        @endif
    </div>

</div>


<!-- END FORM-->