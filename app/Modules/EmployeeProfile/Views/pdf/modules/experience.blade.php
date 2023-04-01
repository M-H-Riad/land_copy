<p class="title">Past Public Sector Experience Outside Dhaka WASA:</p>
<table>
    <tr>
        <td class="greenLine grayBg w30">Organization</td>
        <td class="greenLine grayBg w25">Designation</td>
        {{--<td class="greenLine grayBg w30" colspan="2" style="text-align: center;">Duration</td>--}}

        <td class="greenLine grayBg">From Date</td>
        <td class="greenLine grayBg">To Date</td>
        {{--<td class="greenLine grayBg w15">Basic Pay</td>--}}
        <td class="greenLine grayBg text-center">Grade</td>
        <td class="greenLine grayBg w10 text-center">Proper Channel</td>
    </tr>
    {{--<tr>--}}
        {{--<td class="greenLine grayBg w20 noBorderRight"></td>--}}
        {{--<td class="greenLine grayBg w15 noBorderLeft"></td>--}}
        {{--<td class="greenLine grayBg w15">From Date</td>--}}
        {{--<td class="greenLine grayBg w15">To Date</td>--}}
        {{--<td class="greenLine grayBg w15 noBorderRight"></td>--}}
        {{--<td class="greenLine grayBg w10 noBorderRight noBorderLeft"></td>--}}
        {{--<td class="greenLine grayBg w10 noBorderLeft"></td>--}}
    {{--</tr>--}}
    @foreach($employee->serviceExperience as $row)
    <tr>
        <td class="greenLine">{!! $row->organization or '' !!}</td>
        <td class="greenLine">{!! $row->designation or '' !!}</td>
        <td class="greenLine">{!! date('d/m/y',strtotime($row->from_date)) !!}</td>
        <td class="greenLine">{!! date('d/m/y',strtotime($row->to_date))  !!}</td>
{{--        <td class="greenLine">{!! $row->scale->pay_scale or '' !!}</td>--}}
        <td class="greenLine text-center">{!! $row->scale->grade or '' !!}</td>
        <td class="greenLine text-center">{!! $row->channel? 'Yes':'No' !!}</td>
    </tr>
    @endforeach
</table>