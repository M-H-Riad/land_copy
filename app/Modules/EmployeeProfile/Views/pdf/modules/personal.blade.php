<p class="title">Personal Data:</p>
<table>
    <tr>
        <td class="greenLine grayBg w20">Full Name </td>

        <td class="greenLine">{!! $employee->first_name or '' !!} {!! $employee->middle_name or '' !!} {!! $employee->last_name or '' !!}</td>
        <td class="greenLine grayBg w20">Quota</td>
        <?php
        if ($employee->freedom_fighter == 'Yes') {
            $q = 'Freedom Fighter';
        } else {
            $q = $employee->quota->name;
        }
        ?>
        <td class="greenLine">{{$q}}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg w20">Date of Birth</td>
        <td class="greenLine">{!! date('d/m/Y',strtotime($employee->date_of_birth)) !!}</td>
        <td class="greenLine grayBg w20">Place of Birth</td>
        <td class="greenLine">{!! $employee->place_of_birth or '' !!}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg">Father’s Name</td>

        <td class="greenLine">{!! $employee->father_name or '' !!}</td>
        <td class="greenLine grayBg">Mother’s Name</td>
        <td class="greenLine">{!! $employee->mother_name or '' !!}</td>
    </tr>


    <tr>
        <td class="greenLine grayBg w20">Religion</td>
        <td class="greenLine">{!! $employee->religion or '' !!}</td>
        <td class="greenLine grayBg w20">Blood Group</td>
        <td class="greenLine">{!! $employee->blood_group or '' !!}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg w20">Marital Status</td>
        <td class="greenLine">{!! $employee->marital_status or '' !!}</td>
        <td class="greenLine grayBg w20">Sex</td>
        <td class="greenLine">{!! $employee->gender or '' !!}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg">Spouse Name</td>
        <td class="greenLine" colspan="3">{!! $employee->spouse_name or '' !!}</td>
    </tr>
    <tr>

        <td class="greenLine grayBg w20">Spouse Profession</td>
        <td class="greenLine">{!! $employee->spouse_profession or '' !!}</td>

        <td class="greenLine grayBg w20">Personnel File No.</td>
        <td class="greenLine">{!! $employee->personnel_file_no or '' !!}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg w20">Spouse Qualification</td>
        <td class="greenLine">{!! $employee->spouse_qualification or '' !!}</td>
        <td class="greenLine grayBg w20">Passport No.</td>
        <td class="greenLine">{!! $employee->passport_no or '' !!}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg w20">Joining Date</td>
        <td class="greenLine">{!! dateFormat($employee->first_joining_date)!!}</td>
        <td class="greenLine grayBg">Current Basic Pay</td>
        <td class="greenLine">{!! taka_format($employee->current_basic_pay) !!}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg w20">Bank & Branch Name</td>
        <td class="greenLine">{!! $employee->bankName->bank_name or '' !!},{!! $employee->bankbranch->branch_name or '' !!}</td>
        <td class="greenLine grayBg w20">Bank Account No.</td>
        <td class="greenLine">{!! $employee->bank_account_no or '' !!}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg w20">Provident Fund No.</td>
        <td class="greenLine">{!! $employee->provident_fund_no or '' !!}</td>
        <td class="greenLine grayBg w20">Tax Identification No.</td>
        <td class="greenLine">{!! $employee->tin or '' !!}</td>
    </tr>
    <tr>
        <td class="greenLine grayBg w20">Email Address</td>
        <td class="greenLine">{!! $employee->email or '' !!}</td>
        <td class="greenLine grayBg w20">Mobile No.</td>
        <td class="greenLine">{!! $employee->mobile or '' !!}</td>
    </tr>
</table>