<html>
<head>
    <title>Salary Report/Certificate </title>
    <link rel="stylesheet" href="{{asset('/custom/css/pdf-common.css')}}">

    <style type="text/css" href="">

    </style>
</head>
<body>
@if(isset($employee))

    <table style="margin-bottom: 10px">
        <thead>
        <tr>
            <th style="border: none!important; text-align: left;width: 30%"><b>Name : {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</b></th>
            <th style="border: none!important; text-align: left;width: 16%"><b>Employee ID : {{ $employee->employee_id }} </b></th>
            <th style="border: none!important; text-align: left;width: 16%"><b>TIN No : {{ $employee->tin }} </b></th>
            <th style="border: none!important; text-align: left;width: 15%"><b>PFNO : {{ $employee->pfno }} </b></th>
            <th style="border: none!important; text-align: left;width: 23%"><b>Designation : {{ $employee->designation->title }}</b></th>
        </tr>
    </table>

@endif
@if(isset($salaryReports))
    <table style="margin-bottom: 5px">
        <thead>
        <tr>
            <th><b> Monthly Salary</b></th>
            <th colspan="9"><b>SALARY & ALLOWANCES</b></th>
            <th colspan="10"><b>DEDUCTION</b></th>
            <th><b> Payment</b></th>
        </tr>
        <tr>

            <th width="10%" style="text-align: left">
                Salary Month<br/>
                Bank A/C No., Grade<br/>
                Designation <br>
                Department
            </th>
            <th width="4.5%">
                Basic Pay <br/>
                Tech Pay <br/>
                Spl. Pay
            </th>
            <th width="5.65%">
                House Allw <br/>
                Med.Allw <br/>
                NY/P/F.Bonus
            </th>
            <th width="4.5%">
                Conv. Allw <br/>
                Wash Allw <br/>
                Chrg. Allw
            </th>
            <th width="4.2%">
                Gas Allw <br/>
                W/S Allw <br/>
                Per Pay
            </th>
            <th width="4.2%">
                Dearness<br/>
                Tiffin Allw<br/>
                Edu. Allw
            </th>
            <th width="4.5%">
                PF Refund <br/>
                HB Refund <br/>
                Vhl Refund
            </th>
            <th width="4.65%">
                Salary Arr<br/>
                HR Arr<br/>
                Vhl Allw
                {{--                Depu Allw--}}
            </th>
            <th>
                {{--                Vhl Allw<br/>--}}
                Other Allw<br/>
                <b>Gross Pay</b>
            </th>

        <!--            {{--deduction--}}-->
            <th width="4.2%">
                Prv. Fund <br/>
                H.Rent<br/>
                HR Main.
            </th>
            <th width="4.2%">
                Welfare <br/>
                Trusty F. <br/>
                Ben. Fund

            </th>
            <th width="4%">
                Gr.Insu<br/>
                Elec Bill<br/>
                W&S Ded
            </th>
            <th width="4.2%">
                Titas Gas<br/>
                W.Gov<br/>
                Transport
            </th>
            <th width="4%">
                DPSFee<br/>
                UnionSub<br/>
                DEASFee
            </th>

            <th width="4%">
                DWKKS<br/>
                Sal. Ded<br/>
                PF Loan
            </th>
            <th width="4.2%">
                PF Intt.<br/>
                HB Loan <br/>
                HB Intt.
            </th>
            <th width="3.8%">
                PC Loan<br/>
                PC Intt.<br/>
                Vhl Loan
            </th>
            <th width="4.5%">
                Vhl Intt.<br/>
                PF Refund <br/>
                Rev.Stamp<br/>
            </th>
            <th width="4.5%">
                Oth.Ded<br/>
                IT Ded.<br/>
                IT Arr Ded<br/>
            </th>
            <th>
                1-Day-Sal.<br/>
                <b>Total Ded.</b><br/>
            </th>
            <th>
                <b>Net Payable</b>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = [
            'basic_pay'             => 0,
            'tech_pay'              => 0, // $row['tech_pay'] + $total['tech_pay'],
            'spl_pay'               => 0, // $row['spl_pay'] + $total['spl_pay'],
            'house_alw'             => 0, // $row['house_alw'] + $total['house_alw'],
            'med_alw'               => 0, // $row['med_alw'] + $total['med_alw'],
            'f_bonus'               => 0, // $row['f_bonus'] + $total['f_bonus'],
            'conv_alw'              => 0, // $row['conv_alw'] + $total['conv_alw'],
            'wash_alw'              => 0, // $row['wash_alw'] + $total['wash_alw'],
            'chrg_alw'              => 0, // $row['chrg_alw'] + $total['chrg_alw'],
            'gas_alw'               => 0, // $row['gas_alw'] + $total['gas_alw'],
            'ws_alw'                => 0, // $row['ws_alw'] + $total['ws_alw'],
            'per_pay'               => 0, // $row['per_pay'] + $total['per_pay'],
            'dearness'              => 0, // $row['dearness'] + $total['dearness'],
            'tiffin_alw'            => 0, // $row['tiffin_alw'] + $total['tiffin_alw'],
            'edu_alw'               => 0, // $row['edu_alw'] + $total['edu_alw'],
            'pf_refund'             => 0, // $row['pf_refund'] + $total['pf_refund'],
            'hb_refund'             => 0, // $row['hb_refund'] + $total['hb_refund'],
            'vhl_refund'            => 0, // $row['vhl_refund'] + $total['vhl_refund'],
            'salary_arr'            => 0, // $row['salary_arr'] + $total['salary_arr'],
            'hr_arr'                => 0, // $row['hr_arr'] + $total['hr_arr'],
            'depu_arr'              => 0, // $row['depu_arr'] + $total['depu_arr'],
            'vhl_alw'               => 0, // $row['other_alw'] + $total['other_alw'],
            'other_alw'             => 0, // $row['other_alw'] + $total['other_alw'],
            'gross_pay'             => 0, // $row['gross_pay'] + $total['gross_pay'],


            'prv_fund'              => 0, // $row['prv_fund'] + $total['prv_fund'],
            'pf_loan'                => 0, // $row['pf_loan'] + $total['pf_loan'],
            'pf_inttr'              => 0, // $row['pf_inttr'] + $total['pf_inttr'],
            'hr_main'               => 0, // $row['hr_main'] + $total['hr_main'],
            'hb_loan'               => 0, // $row['hb_loan'] + $total['hb_loan'],
            'h_rent'                => 0, // $row['h_rent'] + $total['h_rent'],
            'welfare'               => 0, // $row['welfare'] + $total['welfare'],
            'trusty_fund'           => 0, // $row['trusty_fund'] + $total['trusty_fund'],
            'ben_fund'              => 0, // $row['ben_fund'] + $total['ben_fund'],
            'gr_insu'               => 0, // $row['gr_insu'] + $total['gr_insu'],
            'elec_bill'             => 0, // $row['elec_bill'] + $total['elec_bill'],
            'pc_inttr'              => 0, // $row['pc_inttr'] + $total['pc_inttr'],
            'ws_ded'                => 0, // $row['ws_ded'] + $total['ws_ded'],
            'titas_gas'             => 0, // $row['titas_gas'] + $total['titas_gas'],
            'water_gov'             => 0, // $row['water_gov'] + $total['water_gov'],
            'transport'             => 0, // $row['transport'] + $total['transport'],
            'pf_refund_ded'         => 0, // $row['pf_refund_ded'] + $total['pf_refund_ded'],
            'vhcl_inttr'            => 0, // $row['vhcl_inttr'] + $total['vhcl_inttr'],
            'hb_inttr'              => 0, // $row['hb_inttr'] + $total['hb_inttr'],
            'it_ded'                => 0, // $row['it_ded'] + $total['it_ded'],
            'it_arrear_ded'         => 0, // $row['it_ded'] + $total['it_ded'],
            'dps_fee'               => 0, // $row['dps_fee'] + $total['dps_fee'],
            'union_sub'             => 0, // $row['union_sub'] + $total['union_sub'],
            'deas_fee'              => 0, // $row['deas_fee'] + $total['deas_fee'],
            'dhak_usf'              => 0, // $row['dhak_usf'] + $total['dhak_usf'],
            'sal_ded'               => 0, // $row['sal_ded'] + $total['sal_ded'],
            'pc_loan'               => 0, // $row['pc_loan'] + $total['pc_loan'],
            'other_ded'             => 0, // $row['other_ded'] + $total['other_ded'],
            'day_sal'               => 0, // $row['day_sal'] + $total['day_sal'],
            'total_ded'             => 0, // $row['total_ded'] + $total['total_ded'],
            'rev_stamp'             => 0, // $row['rev_stamp'] + $total['rev_stamp'],
            'net_payable'           => 0, // $row['net_payable'] + $total['net_payable'],
        ];
        ?>
        @foreach($salaryReports as $key=>$value)
         @if( $value->payrollEmployee != null )
            @php $row = $value->payrollEmployee @endphp
            {{--            {{dd($row)}}--}}
            <tr>
                <td>
                    <?php $empData = json_decode($row->employee_data); ?>
                    @if(isset($empData->name))
                        <b>{{$value->title}}</b> <br/>
                        <span class="light">{{$empData->bank_acc}}, {{$empData->grade}}</span>
                        <br/>
                        <span class="light">
                            {{$empData->designation}}
                        </span>
                       <br/>
                        <span class="light">
                            {{$empData->department}}
                        </span>
                    @endif
                </td>
                <td class="right">
                    {{number($row->basic_pay)}} <br/>
                    {{number($row->tech_pay)}} <br/>
                    {{number($row->spl_pay)}}
                </td>
                <td class="right">
                    {{number($row->house_alw)}}
                    <br/> {{number($row->med_alw)}}
                    <br/> {{number($row->f_bonus)}}
                </td>
                <td class="right">
                    {{number($row->conv_alw )}}
                    <br/> {{number($row->wash_alw)}}
                    <br/> {{number($row->chrg_alw)}}
                </td>
                <td class="right">
                    {{number($row->gas_alw)}}
                    <br/> {{number($row->ws_alw)}}
                    <br/> {{number($row->per_pay)}}
                </td>
                <td class="right">
                    {{number($row->dearness)}}
                    <br/> {{number($row->tiffin_alw)}}
                    <br/> {{number($row->edu_alw)}}
                </td>
                <td class="right">
                    {{number($row->pf_refund)}}
                    <br/> {{number($row->hb_refund)}}
                    <br/> {{number($row->vhl_refund)}}
                </td>
                <td class="right">
                    {{number($row->salary_arr)}}
                    <br/> {{number($row->hr_arr)}}
                    <br/> {{number($row->vhl_alw)}}
                    {{--                    <br/> {{number($row->depu_arr)}}--}}
                </td>
                <td class="right">

                    {{number($row->other_alw)}}
                    <br/><b> {{number($row->gross_pay)}}</b>
                </td>

                {{--Deduction--}}
                <td class="right">
                    {{number($row->prv_fund)}} <br/>
                    {{number($row->h_rent)}}<br/>
                    {{number($row->hr_main)}}

                </td>
                <td class="right">
                    {{number($row->welfare)}}<br/>
                    {{number($row->trusty_fund)}}<br/>
                    {{number($row->ben_fund)}}

                </td>
                <td class="right">
                    {{number($row->gr_insu )}} <br/>
                    {{number($row->elec_bill)}} <br/>
                    {{number($row->ws_ded)}}
                </td>
                <td class="right">
                    {{number($row->titas_gas)}}<br/>
                    {{number($row->water_gov)}}<br/>
                    {{number($row->transport)}}
                </td>
                <td class="right">
                    {{number($row->dps_fee)}}<br/>
                    {{number($row->union_sub)}} <br/>
                    {{number($row->deas_fee)}}

                </td>
                <td class="right">
                    {{number($row->dhak_usf)}} <br/>
                    {{number($row->sal_ded)}} <br/>
                    {{number($row->pf_loan)}}
                </td>
                <td class="right">
                    {{number($row->pf_inttr)}}<br/>
                    {{number($row->hb_loan)}}<br/>
                    {{number($row->hb_inttr)}}
                </td>
                <td class="right">
                    {{number($row->pc_loan)}}<br/>
                    {{number($row->pc_inttr)}}<br/>
                    {{number($row->vhcl_loan)}}
                </td>
                <td class="right">
                    {{number($row->vhcl_inttr)}}<br/>
                    {{number($row->pf_refund_ded)}}<br/>
                    {{number($row->rev_stamp)}} <br/>
                </td>
                <td class="right">
                    {{number($row->other_ded)}}<br/>
                    {{number($row->it_ded)}}<br/>
                    {{number($row->it_arrear_ded)}}
                </td>
                <td class="right">
                    {{number($row->day_sal)}}<br>
                    <b> {{number($row->total_ded)}}</b> <br>
                </td>
                <td class="right">
                    <br/>
                    <b> {{number($row->net_payable)}}</b>
                </td>
            </tr>
            <?php

            $row = $row->toArray();
            $total = [
                'basic_pay'             => $row['basic_pay'] + $total['basic_pay'],
                'tech_pay'              => $row['tech_pay'] + $total['tech_pay'],
                'spl_pay'               => $row['spl_pay'] + $total['spl_pay'],
                'house_alw'             => $row['house_alw'] + $total['house_alw'],
                'med_alw'               => $row['med_alw'] + $total['med_alw'],
                'f_bonus'               => $row['f_bonus'] + $total['f_bonus'],
                'conv_alw'              => $row['conv_alw'] + $total['conv_alw'],
                'wash_alw'              => $row['wash_alw'] + $total['wash_alw'],
                'chrg_alw'              => $row['chrg_alw'] + $total['chrg_alw'],
                'gas_alw'               => $row['gas_alw'] + $total['gas_alw'],
                'ws_alw'                => $row['ws_alw'] + $total['ws_alw'],
                'per_pay'               => $row['per_pay'] + $total['per_pay'],
                'dearness'              => $row['dearness'] + $total['dearness'],
                'tiffin_alw'            => $row['tiffin_alw'] + $total['tiffin_alw'],
                'edu_alw'               => $row['edu_alw'] + $total['edu_alw'],
                'pf_refund'             => $row['pf_refund'] + $total['pf_refund'],
                'hb_refund'             => $row['hb_refund'] + $total['hb_refund'],
                'vhl_refund'            => $row['vhl_refund'] + $total['vhl_refund'],
                'salary_arr'            => $row['salary_arr'] + $total['salary_arr'],
                'hr_arr'                => $row['hr_arr'] + $total['hr_arr'],
                'depu_arr'              => $row['depu_arr'] + $total['depu_arr'],
                'vhl_alw'               => $row['vhl_alw'] + $total['vhl_alw'],
                'other_alw'             => $row['other_alw'] + $total['other_alw'],
                'gross_pay'             => $row['gross_pay'] + $total['gross_pay'],


                'prv_fund'              => $row['prv_fund'] + $total['prv_fund'],
                'pf_loan'                => $row['pf_loan'] + $total['pf_loan'],
                'pf_inttr'              => $row['pf_inttr'] + $total['pf_inttr'],
                'hr_main'               => $row['hr_main'] + $total['hr_main'],
                'hb_loan'               => $row['hb_loan'] + $total['hb_loan'],
                'h_rent'                => $row['h_rent'] + $total['h_rent'],
                'welfare'               => $row['welfare'] + $total['welfare'],
                'trusty_fund'           => $row['trusty_fund'] + $total['trusty_fund'],
                'ben_fund'              => $row['ben_fund'] + $total['ben_fund'],
                'gr_insu'               => $row['gr_insu'] + $total['gr_insu'],
                'elec_bill'             => $row['elec_bill'] + $total['elec_bill'],
                'pc_inttr'              => $row['pc_inttr'] + $total['pc_inttr'],
                'ws_ded'                => $row['ws_ded'] + $total['ws_ded'],
                'titas_gas'             => $row['titas_gas'] + $total['titas_gas'],
                'water_gov'             => $row['water_gov'] + $total['water_gov'],
                'transport'             => $row['transport'] + $total['transport'],
                'pf_refund_ded'         => $row['pf_refund_ded'] + $total['pf_refund_ded'],
                'vhcl_inttr'            => $row['vhcl_inttr'] + $total['vhcl_inttr'],
                'hb_inttr'              => $row['hb_inttr'] + $total['hb_inttr'],
                'it_ded'                => $row['it_ded'] + $total['it_ded'],
                'it_arrear_ded'         => $row['it_arrear_ded'] + $total['it_arrear_ded'],
                'dps_fee'               => $row['dps_fee'] + $total['dps_fee'],
                'union_sub'             => $row['union_sub'] + $total['union_sub'],
                'deas_fee'              => $row['deas_fee'] + $total['deas_fee'],
                'dhak_usf'              => $row['dhak_usf'] + $total['dhak_usf'],
                'sal_ded'               => $row['sal_ded'] + $total['sal_ded'],
                'pc_loan'               => $row['pc_loan'] + $total['pc_loan'],
                'other_ded'             => $row['other_ded'] + $total['other_ded'],
                'day_sal'               => $row['day_sal'] + $total['day_sal'],
                'total_ded'             => $row['total_ded'] + $total['total_ded'],
                'rev_stamp'             => $row['rev_stamp'] + $total['rev_stamp'],
                'net_payable'           => $row['net_payable'] + $total['net_payable'],
            ];
            ?>
            @endif
        @endforeach
        </tbody>

        <tfoot>
        <tr class="right">
            <td>
                <strong>Total:</strong>
            </td>
            <td class="right">
                {{number($total['basic_pay'])}} <br/>
                {{number($total['tech_pay'])}} <br/>
                {{number($total['spl_pay'])}}
            </td>
            <td class="right">
                {{number($total['house_alw'])}}
                <br/> {{number($total['med_alw'])}}
                <br/> {{number($total['f_bonus'])}}
            </td>
            <td class="right">
                {{number($total['conv_alw'])}}
                <br/> {{number($total['wash_alw'])}}
                <br/> {{number($total['chrg_alw'])}}
            </td>
            <td class="right">
                {{number($total['gas_alw'])}}
                <br/> {{number($total['ws_alw'])}}
                <br/> {{number($total['per_pay'])}}
            </td>
            <td class="right">
                {{number($total['dearness'])}}
                <br/> {{number($total['tiffin_alw'])}}
                <br/> {{number($total['edu_alw'])}}
            </td>
            <td class="right">
                {{number($total['pf_refund'])}}
                <br/> {{number($total['hb_refund'])}}
                <br/> {{number($total['vhl_refund'])}}
            </td>
            <td class="right">
                {{number($total['salary_arr'])}}
                <br/> {{number($total['hr_arr'])}}
                <br/>{{number($total['vhl_alw'])}}
                {{--                <br/> {{number($total['depu_arr'])}}--}}
            </td>
            <td class="right">
                {{number($total['other_alw'])}}
                <br/><b> {{number($total['gross_pay'])}}</b>
            </td>

            {{--Deduction--}}
            <td class="right">
                {{number($total['prv_fund'])}} <br/>
                {{number($total['h_rent'])}}<br/>
                {{number($total['hr_main'])}}

            </td>
            <td class="right">
                {{number($total['welfare'])}}<br/>
                {{number($total['trusty_fund'])}}<br/>
                {{number($total['ben_fund'])}}
                {{number($total['day_sal'])}}

            </td>
            <td class="right">
                {{number($total['gr_insu'])}} <br/>
                {{number($total['elec_bill'])}} <br/>
                {{number($total['ws_ded'])}}
            </td>
            <td class="right">
                {{number($total['titas_gas'])}}<br/>
                {{number($total['water_gov'])}}<br/>
                {{number($total['transport'])}}
            </td>
            <td class="right">
                {{number($total['dps_fee'])}}<br/>
                {{number($total['union_sub'])}} <br/>
                {{number($total['deas_fee'])}}

            </td>
            <td class="right">
                {{number($total['dhak_usf'])}} <br/>
                {{number($total['sal_ded'])}} <br/>
                {{number($total['pf_loan'])}}
            </td>
            <td class="right">
                {{number($total['pf_inttr'])}}<br/>
                {{number($total['hb_loan'])}}<br/>
                {{number($total['hb_inttr'])}}
            </td>
            <td class="right">
                {{number($total['pc_loan'])}}<br/>
                {{number($total['pc_inttr'])}}<br/>

                {{number($total['vhcl_inttr'])}}
            </td>
            <td class="right">
                {{number($total['vhcl_inttr'])}}<br/>
                {{number($total['pf_refund_ded'])}}<br/>
                {{number($total['rev_stamp'])}} <br/>
            </td>
            <td class="right">
                {{number($total['other_ded'])}}<br/>
                {{number($total['it_ded'])}}<br/>
                {{number($total['it_arrear_ded'])}}
            </td>
            <td class="right">
                {{number($total['day_sal'])}}<br/>
                <b>{{number($total['total_ded'])}}</b>  <br/>
            </td>
            <td class="right">
                <br/>
                <b> {{number($total['net_payable'])}}</b>
            </td>
        </tr>
        </tfoot>
    </table>
@endif
@php    $totalBonus = 0;$rStamp = 0 ;$totalNet_payable = 0 ;  @endphp
@if(isset($bonusReports))
    <table  style="margin-bottom: 10px">
        <thead>
        <tr>

            <th colspan="6"><b>Separate Bonus</b></th>
        </tr>
        <tr>
            <th>Bonus</th>
            <th>Basic Pay</th>
            <th>Bonus</th>
            <th>Rev.Stamp</th>
            <th>Net Payable</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bonusReports as $bonus)
            @if($bonus->bonusEmployee !=null)
                <tr>
                    <td style="text-align: center;width: 20%"><b>{{ $bonus->title }}</b> </td>
                    <td style="text-align: center;width: 20%">{{ $bonus->bonusEmployee->basic_pay }} </td>
                    <td style="text-align: center;width: 20%">{{ $bonus->bonusEmployee->bonus ?? 0 }}  </td>
                    <td style="text-align: center;width: 20%">{{ $bonus->bonusEmployee->rev_stamp }}  </td>
                    <td style="text-align: center;width: 20%">{{ $bonus->bonusEmployee->net_payable }}  </td>
                </tr>
                @php
                    $rStamp             += $bonus->bonusEmployee->rev_stamp ;
                    $totalBonus         += $bonus->bonusEmployee->bonus ;
                    $totalNet_payable   += $bonus->bonusEmployee->net_payable ;
                @endphp
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" style="text-align: right">
                <strong>Total:</strong>
            </td>
            <td style="text-align: center">
                <strong> {{ $totalBonus }}</strong>
            </td>
            <td style="text-align: center">
                <strong> {{ $rStamp }}</strong>
            </td>
            <td style="text-align: center">
                <strong> {{ $totalNet_payable }}</strong>
            </td>
        </tr>
        </tfoot>
    </table>
@endif

@php    $totalOvertime = 0;  @endphp
@if(isset($overTimeReports))
<table  style="margin-bottom: 10px">
    <thead>
    <tr>

        <th colspan="6"><b>Overtime Report</b></th>
    </tr>
    <tr>
        <th>Overtime Month</th>
        <th>Basic Pay</th>
        <th>Hours</th>
        <th>Arrear</th>
        <th>R.Stamp  (Deduction)</th>
        <th>Net Payable</th>
    </tr>
    </thead>
    <tbody>
    @php
        $rStamp = 0 ;
        $tHours = 0 ;
        $tAllowance = 0 ;
    @endphp
    @foreach($overTimeReports as $overtime)
       @if($overtime->overTimeEmployee !=null)
        <tr>
            <td style="text-align: center;width: 20%"><b>{{ $overtime->title }}</b> </td>
            <td style="text-align: center;width: 20%">{{ $overtime->overTimeEmployee->basic_pay }} </td>
            <td style="text-align: center;width: 10%">{{  $overtime->overTimeEmployee->hours ?? 0 }}  </td>
            <td style="text-align: center;width: 20%">{{  $overtime->overTimeEmployee->allowance ?? 0 }}  </td>
            <td style="text-align: center;width: 10%"> 10  </td>
            <td style="text-align: center;width: 20%">{{ $overtime->overTimeEmployee->overtime }}  </td>
        </tr>
        @php
            $rStamp         += 10;
            $tHours         += $overtime->overTimeEmployee->hours;
            $tAllowance     += $overtime->overTimeEmployee->allowance;
            $totalOvertime  += $overtime->overTimeEmployee->overtime ;
        @endphp
        @endif
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2" style="text-align: right">
            <strong>Total:</strong>
        </td>
        <td style="text-align: center">
            <strong> {{ $tHours }}</strong>
        </td>
        <td style="text-align: center">
            <strong> {{ $tAllowance }}</strong>
        </td>
        <td style="text-align: center">
            <strong> {{ $rStamp }}</strong>
        </td>
        <td style="text-align: center">
            <strong> {{ $totalOvertime }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
@endif
@php    $totalNightAllowance = 0;  @endphp
@if(isset($nightAllowanceReport))
    <table  style="margin-bottom: 10px">
        <thead>
        <tr>

            <th colspan="6"><b>Night Allowance Report</b></th>
        </tr>
        <tr>
            <th>Night Allowance Month</th>
            <th>Basic Pay</th>
            <th>Nights</th>
            <th>Arrear</th>
            <th>R.Stamp (Deduction)</th>
            <th>Net Payable</th>
        </tr>
        </thead>
        <tbody>
        @php
            $rStamp = 0 ;
            $tNights = 0 ;
            $nAllowance = 0 ;
        @endphp
        @foreach($nightAllowanceReport as $nightAllowance)
            @if($nightAllowance->nightAllowanceEmployee !=null)
                <tr>
                    <td style="text-align: center;width: 20%"><b>{{ $nightAllowance->title }}</b> </td>
                    <td style="text-align: center;width: 20%">{{ $nightAllowance->nightAllowanceEmployee->basic_pay }} </td>
                    <td style="text-align: center;width: 10%">{{ $nightAllowance->nightAllowanceEmployee->nights }} </td>
                    <td style="text-align: center;width: 20%">{{ $nightAllowance->nightAllowanceEmployee->allowance }} </td>
                    <td style="text-align: center;width: 10%"> 10  </td>
                    <td style="text-align: center;width: 20%">{{ $nightAllowance->nightAllowanceEmployee->night_allowance }}  </td>
                </tr>
                @php
                    $rStamp     += 10;
                    $tNights    += $nightAllowance->nightAllowanceEmployee->nights;
                    $nAllowance += $nightAllowance->nightAllowanceEmployee->allowance;
                    $totalNightAllowance += $nightAllowance->nightAllowanceEmployee->night_allowance ;
                @endphp
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" style="text-align: right">
                <strong>Total:</strong>
            </td>
            <td style="text-align: center">
                <strong> {{ $tNights }}</strong>
            </td>
            <td style="text-align: center">
                <strong> {{ $nAllowance }}</strong>
            </td>
            <td style="text-align: center">
                <strong> {{ $rStamp }}</strong>
            </td>
            <td style="text-align: center">
                <strong> {{ $totalNightAllowance }}</strong>
            </td>
        </tr>
        </tfoot>
    </table>
@endif

@php
     $grandTotal =   $total['net_payable'] + $totalNet_payable + $totalNightAllowance + $totalOvertime;
@endphp
<p style="text-align: right;    font-size: 13px;"><strong >Grand Total : {{$grandTotal}}</strong></p>
