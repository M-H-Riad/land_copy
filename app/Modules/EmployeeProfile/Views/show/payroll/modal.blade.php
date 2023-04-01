<div id="payroll-modal" class="modal fade draggable-modal ui-draggable" role="dialog" aria-hidden="true">
    <div class="modal-dialog lg ">
        <div class="modal-content">
            {!! Form::model($employee->payrollSetting,['url' => 'employee-payroll-setting', 'method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Payroll Setting</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                <input type="hidden" name="pfno" value="{{$employee->pfno}}">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">
                    <thead>
                        <tr>
                            <th colspan="2">Salary Heads</th>
                            <th colspan="2">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                         {{--<tr>--}}
                            {{--<td colspan="6" style="text-align: center"><h4>Allowance</h4></td>--}}
                        {{--</tr>--}}
                        <tr>
                            <td colspan="2">Technical Pay Amount</td>
                            <td colspan="2">
                                {{--{{ Form::text("tech_pay_amount",null,["class" => "form-control",'step'=>'any',]) }}--}}
                                {{ Form::select("tech_pay_amount",[0=>'N/A', 1=>'Single', 2=>'Double'],null,["class" => "form-control",'step'=>'any',]) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Special Payment</td>
                            <td colspan="2">
                                <div class="row">
                                <div class="col-md-1">{{ Form::checkbox("spl_pay",1,null,["id" => "spl_pay","onchange" => "splPayChanged()"]) }}</div>
                                <div class="col-md-11 spl_pay_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->spl_pay == 1)  @else style="display: none" @endif>

                                        @if(isset($employee->payrollSetting))
                                            @php $spl_pay_end =  dateFormat( $employee->payrollSetting->spl_pay_end)@endphp
                                        @else
                                           @php $spl_pay_end = null @endphp
                                        @endif

                                    {{ Form::text('spl_pay_end',$spl_pay_end, ['class' => 'form-control mask_date', 'id' => 'spl_pay_end','placeholder'=>'End Date']) }}
                                    {{ Form::text("spl_pay_amount",null,["class" => "form-control", 'id'=>'spl_pay_amount','step'=>'any','placeholder'=>'00']) }}
                                </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Personal Pay</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("personal_pay",1,null,["id" => "personal_pay","onchange" => "perPayChanged()"]) }}</div>
                                    <div class="col-md-11 per_pay_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->personal_pay == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $per_pay_end =  dateFormat( $employee->payrollSetting->per_pay_end)@endphp
                                        @else
                                            @php $per_pay_end = null @endphp
                                        @endif
                                        {{ Form::text('per_pay_end',$per_pay_end, ['class' => 'form-control mask_date', 'id' => 'per_pay_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("per_pay",null,["class" => "form-control ",'id'=>'per_pay','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Salary Arrears</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("salary_arrears",1,null,["id" => "salary_arrears","onchange" => "salaryArrChanged()"]) }}</div>
                                    <div class="col-md-11 salary_arr_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->salary_arrears == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $salary_arr_end =  dateFormat( $employee->payrollSetting->salary_arr_end)@endphp
                                        @else
                                            @php $salary_arr_end = null @endphp
                                        @endif
                                        {{ Form::text('salary_arr_end', $salary_arr_end, ['class' => 'form-control mask_date', 'id' => 'salary_arr_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("salary_arr",null,["class" => "form-control ",'id'=>'salary_arr','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">Provident Fund Refund</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("pf_fund_refund",1,null,["id" => "pf_fund_refund","onchange" => "pfFoundRefundChanged()"]) }}</div>
                                    <div class="col-md-11 pf_refund_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->pf_fund_refund == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $pf_refund_end =  dateFormat( $employee->payrollSetting->pf_refund_end)@endphp
                                        @else
                                            @php $pf_refund_end = null @endphp
                                        @endif
                                        {{ Form::text('pf_refund_end',$pf_refund_end, ['class' => 'form-control mask_date', 'id' => 'pf_refund_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("pf_refund",null,["class" => "form-control ",'id' =>'pf_refund','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">HBL Refund</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("hb_lone_refund",1,null,["id" => "hb_lone_refund","onchange" => "hbLoanRefundChanged()"]) }}</div>
                                    <div class="col-md-11 hb_refund_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->hb_lone_refund == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $hb_refund_end =  dateFormat( $employee->payrollSetting->hb_refund_end)@endphp
                                        @else
                                            @php $hb_refund_end = null @endphp
                                        @endif
                                        {{ Form::text('hb_refund_end',$hb_refund_end, ['class' => 'form-control mask_date', 'id' => 'hb_refund_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("hb_refund",null,["class" => "form-control ",'id' =>'hb_refund','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                         <tr>
                             <td colspan="2">Vehicle Allowance</td>
                             <td colspan="2">
                                 <div class="row">
                                     <div class="col-md-1">{{ Form::checkbox("vehicle_allowance",1,null,["id" => "vehicle_allowance","onchange" => "vhlAllowanceChanged()"]) }}</div>
                                     <div class="col-md-11 vhl_alw_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->vehicle_allowance == 1)  @else style="display: none" @endif>
                                         @if(isset($employee->payrollSetting))
                                             @php $vhl_alw_end =  dateFormat( $employee->payrollSetting->vhl_alw_end)@endphp
                                         @else
                                             @php $vhl_alw_end = null @endphp
                                         @endif
                                         {{ Form::text('vhl_alw_end',$vhl_alw_end, ['class' => 'form-control mask_date', 'id' => 'vhl_alw_end','placeholder'=>'End Date']) }}
                                         {{ Form::text("vhl_alw",null,["class" => "form-control ",'id' =>'vhl_alw','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                     </div>
                                 </div>

                             </td>
                         </tr>
                        <tr>
                            <td colspan="2">Vehicle Refund</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("vehicle_refund",1,null,["id" => "vehicle_refund","onchange" => "vhlRefundChanged()"]) }}</div>
                                    <div class="col-md-11 vhl_refund_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->vehicle_refund == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $vhl_refund_end =  dateFormat( $employee->payrollSetting->vhl_refund_end)@endphp
                                        @else
                                            @php $vhl_refund_end = null @endphp
                                        @endif
                                        {{ Form::text('vhl_refund_end',$vhl_refund_end , ['class' => 'form-control mask_date', 'id' => 'vhl_refund_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("vhl_refund",null,["class" => "form-control ",'id' =>'vhl_refund','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">House Rent Arrears</td>
                            <td colspan="2">
                                <div class="row">
                                <div class="col-md-1">{{ Form::checkbox("house_rent_arr",1,null,["id" => "house_rent_arr","onchange" => "hrArrearsChanged()"]) }}</div>
                                <div class="col-md-11 hr_arr_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->house_rent_arr == 1)  @else style="display: none" @endif>
                                    @if(isset($employee->payrollSetting))
                                        @php $hr_arr_end=  dateFormat( $employee->payrollSetting->hr_arr_end)@endphp
                                    @else
                                        @php $hr_arr_end = null @endphp
                                    @endif
                                    {{ Form::text('hr_arr_end',$hr_arr_end, ['class' => 'form-control mask_date', 'id' => 'hr_arr_end','placeholder'=>'End Date']) }}
                                    {{ Form::text("hr_arr",null,["class" => "form-control ",'id' =>'hr_arr','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">Other Allowance</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("other_allowance",1,null,["id" => "other_allowance","onchange" => "otherAllowanceChanged()"]) }}</div>
                                    <div class="col-md-11 other_alw_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->other_allowance == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $other_alw_end =  dateFormat( $employee->payrollSetting->other_alw_end)@endphp
                                        @else
                                            @php $other_alw_end = null @endphp
                                        @endif
                                        {{ Form::text('other_alw_end',$other_alw_end , ['class' => 'form-control mask_date', 'id' => 'other_alw_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("other_alw",null,["class" => "form-control ",'id' =>'other_alw','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>

                            </td>
                        </tr>
                         <tr>
                             <td colspan="2">Gas Allowance</td>
                             <td colspan="2">
                                 {{ Form::checkbox("gas_alw",1,null,["class" => ""]) }}
                             </td>
                         </tr>
                    </tbody>
                    <tfoot>
                        
                        
                        <tr>
                            <td colspan="6" style="text-align: center"><h4>Deduction</h4></td>
                        </tr>
                        
                        

                        <tr>
                            <td colspan="2">Provident Fund</td>
                            <td colspan="2">
                                <?php
                                $providentFund = isset($employee->payrollSetting->prv_fund)?$employee->payrollSetting->prv_fund:12.5;
                                ?>
                                {{ Form::text("prv_fund",old('prv_fund',$providentFund),["class" => "form-control",'step'=>'any',]) }}
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">Provident Fund Type</td>
                            <td colspan="2">
                                {{ Form::select("prv_fund_type",[1=>'Percent (%)',0=>'Fixed Amount (TK)'],null,["class" => "form-control"]) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Income Tax Deduct</td>
                            <td colspan="2">
                                {{ Form::text("it_ded",null,["class" => "form-control ",'id' =>'it_arrear_ded','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">Income Tax Arrears Deduct</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("it_arr_ded",1,null,["id" => "it_arr_ded","onchange" => "itArrDedChanged()"]) }}</div>
                                    <div class="col-md-11 it_arrear_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->it_arr_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $it_arrear_ded_end =  dateFormat( $employee->payrollSetting->it_arrear_ded_end)@endphp
                                        @else
                                            @php $it_arrear_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('it_arrear_ded_end',$it_arrear_ded_end, ['class' => 'form-control mask_date', 'id' => 'it_arrear_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("it_arrear_ded",null,["class" => "form-control ",'id' =>'it_arrear_ded','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Transport</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("transport_ded",1,null,["id" => "transport_ded","onchange" => "transportDedChanged()"]) }}</div>
                                    <div class="col-md-11 transport_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->transport_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $transport_end =  dateFormat( $employee->payrollSetting->transport_end)@endphp
                                        @else
                                            @php $transport_end = null @endphp
                                        @endif
                                        {{ Form::text('transport_end',$transport_end, ['class' => 'form-control mask_date', 'id' => 'transport_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("transport",null,["class" => "form-control ",'id' =>'transport','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Salary Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("salary_ded",1,null,["id" => "salary_ded","onchange" => "salaryDedChanged()"]) }}</div>
                                    <div class="col-md-11 sal_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->salary_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $sal_ded_end =  dateFormat( $employee->payrollSetting->sal_ded_end)@endphp
                                        @else
                                            @php $sal_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('sal_ded_end',$sal_ded_end, ['class' => 'form-control mask_date', 'id' => 'sal_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("sal_ded",null,["class" => "form-control ",'id' =>'sal_ded','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">Other Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("other_deduction",1,null,["id" => "other_deduction","onchange" => "otherDedChanged()"]) }}</div>
                                    <div class="col-md-11 other_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->other_deduction == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $other_ded_end =  dateFormat( $employee->payrollSetting->other_ded_end)@endphp
                                        @else
                                            @php $other_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('other_ded_end',$other_ded_end, ['class' => 'form-control mask_date', 'id' => 'other_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("other_ded",null,["class" => "form-control ",'id' =>'other_ded','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" title="House Building  Loan Deduction">HB Loan Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("hb_loan_ded",1,null,["id" => "hb_loan_ded","onchange" => "hbLoanDedChanged()"]) }}</div>
                                    <div class="col-md-11 hb_loan_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->hb_loan_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $hb_loan_ded_end =  dateFormat( $employee->payrollSetting->hb_loan_ded_end)@endphp
                                        @else
                                            @php $hb_loan_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('hb_loan_ded_end', $hb_loan_ded_end, ['class' => 'form-control mask_date', 'id' => 'hb_loan_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("hb_loan",null,["class" => "form-control ",'id' =>'hb_loan','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr> <tr>
                            <td colspan="2" title="House Building Interest Deduction">HB Interest Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("hb_interest_ded",1,null,["id" => "hb_interest_ded","onchange" => "hbInterestDedChanged()"]) }}</div>
                                    <div class="col-md-11 hb_inttr_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->hb_interest_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $hb_inttr_ded_end =  dateFormat( $employee->payrollSetting->hb_inttr_ded_end)@endphp
                                        @else
                                            @php $hb_inttr_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('hb_inttr_ded_end',$hb_inttr_ded_end, ['class' => 'form-control mask_date', 'id' => 'hb_inttr_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("hb_inttr",null,["class" => "form-control ",'id' =>'hb_inttr','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" title="Personal Computer Lone Deduction">PC Lone Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("pc_loan_ded",1,null,["id" => "pc_loan_ded","onchange" => "pcLoneDedChanged()"]) }}</div>
                                    <div class="col-md-11 pc_loan_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->pc_loan_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $pc_loan_ded_end =  dateFormat( $employee->payrollSetting->pc_loan_ded_end)@endphp
                                        @else
                                            @php $pc_loan_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('pc_loan_ded_end',$pc_loan_ded_end, ['class' => 'form-control mask_date', 'id' => 'pc_loan_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("pc_loan",null,["class" => "form-control ",'id' =>'pc_loan','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" title="Computer Lone Interest Deduction">PC Lone Interest Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("pc_interest_ded",1,null,["id" => "pc_interest_ded","onchange" => "pcInterestDedChanged()"]) }}</div>
                                    <div class="col-md-11 pc_inttr_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->pc_interest_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $pc_inttr_ded_end =  dateFormat( $employee->payrollSetting->pc_inttr_ded_end)@endphp
                                        @else
                                            @php $pc_inttr_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('pc_inttr_ded_end',$pc_inttr_ded_end, ['class' => 'form-control mask_date', 'id' => 'pc_inttr_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("pc_inttr",null,["class" => "form-control ",'id' =>'pc_inttr','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>

                            </td>
                        </tr> <tr>
                            <td colspan="2" title="Vehicle Lone Deduction">Vehicle Lone Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("vhcl_loan_ded",1,null,["id" => "vhcl_loan_ded","onchange" => "vhclLoneDedChanged()"]) }}</div>
                                    <div class="col-md-11 vhcl_loan_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->vhcl_loan_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $vhcl_loan_ded_end =  dateFormat( $employee->payrollSetting->vhcl_loan_ded_end)@endphp
                                        @else
                                            @php $vhcl_loan_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('vhcl_loan_ded_end',$vhcl_loan_ded_end, ['class' => 'form-control mask_date', 'id' => 'vhcl_loan_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("vhcl_loan",null,["class" => "form-control ",'id' =>'vhcl_loan','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr> <tr>
                            <td colspan="2" title="Vehicle Lone Interest Deduction">VL Interest Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("vhcl_interest_ded",1,null,["id" => "vhcl_interest_ded","onchange" => "vhclInterestDedChanged()"]) }}</div>
                                    <div class="col-md-11 vhcl_inttr_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->vhcl_interest_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $vhcl_inttr_ded_end =  dateFormat( $employee->payrollSetting->vhcl_inttr_ded_end)@endphp
                                        @else
                                            @php $vhcl_inttr_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('vhcl_inttr_ded_end',$vhcl_inttr_ded_end, ['class' => 'form-control mask_date', 'id' => 'vhcl_inttr_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("vhcl_inttr",null,["class" => "form-control ",'id' =>'vhcl_inttr','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" title="Provident Fund Lone Deduction">PF Lone Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("pf_loan_ded",1,null,["id" => "pf_loan_ded","onchange" => "pfLoneDedChanged()"]) }}</div>
                                    <div class="col-md-11 pf_loan_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->pf_loan_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $pf_loan_ded_end =  dateFormat( $employee->payrollSetting->pf_loan_ded_end)@endphp
                                        @else
                                            @php $pf_loan_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('pf_loan_ded_end',$pf_loan_ded_end, ['class' => 'form-control mask_date', 'id' => 'pf_loan_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("pf_loan",null,["class" => "form-control ",'id' =>'pf_loan','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" title="Provident Fund Lone Interest Deduction">PF Lone Interest Deduction</td>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-1">{{ Form::checkbox("pf_interest_ded",1,null,["id" => "pf_interest_ded","onchange" => "pfInterestDedChanged()"]) }}</div>
                                    <div class="col-md-11 pf_inttr_ded_amount" @if(isset($employee->payrollSetting) && $employee->payrollSetting->pf_interest_ded == 1)  @else style="display: none" @endif>
                                        @if(isset($employee->payrollSetting))
                                            @php $pf_inttr_ded_end =  dateFormat( $employee->payrollSetting->pf_inttr_ded_end)@endphp
                                        @else
                                            @php $pf_inttr_ded_end = null @endphp
                                        @endif
                                        {{ Form::text('pf_inttr_ded_end',$pf_inttr_ded_end, ['class' => 'form-control mask_date', 'id' => 'pf_inttr_ded_end','placeholder'=>'End Date']) }}
                                        {{ Form::text("pf_inttr",null,["class" => "form-control ",'id' =>'pf_inttr','maxlength'=>10,'step'=>'any','placeholder'=>'00']) }}
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">WASA Quarter </td>
                            <td colspan="2">
                                {{ Form::checkbox("h_rent",1, null ,["id" => "h_rent","onchange" => "hRentChanged()"]) }}
                                <div class="pull-right rent_type" @if(isset($employee->payrollSetting) && $employee->payrollSetting->h_rent == 1)  @else style="display: none" @endif>
                                    <label>{{ Form::radio("h_rent_type",1,true,["class" => "form-control1 h_rent_type"]) }} Building </label>
                                    <label>{{ Form::radio("h_rent_type",2,false,["class" => "form-control1 h_rent_type"]) }} Tin Shed </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Titas Gas</td>
                            <td colspan="2">
                                {{ Form::checkbox("titas_gas",1,null,["id" => "titas_gas","onchange" => "titasGasChanged()"]) }}

                                <div class="pull-right stove" @if(isset($employee->payrollSetting) && $employee->payrollSetting->titas_gas == 1)  @else style="display: none" @endif>
                                    <label>{{ Form::radio("stove",1,false,["class" => "form-control1 stoves"]) }} One Burner </label>
                                    <label>{{ Form::radio("stove",2,true,["class" => "form-control1 stoves"]) }} Two Burner </label>
                                </div>
                            </td>
                        </tr>

                    </tfoot>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary">Save & Close</button>
            </div>
            {!! Form::close()  !!}
        </div>
    </div>
</div>
@include('EmployeeProfile::show.payroll._script')