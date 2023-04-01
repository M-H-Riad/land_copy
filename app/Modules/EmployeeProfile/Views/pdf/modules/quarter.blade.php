<p class="title">Quarter Information:</p>
<table>
    <tr>
        <td class="greenLine grayBg w25">Allotment Reference</td>
        <td class="greenLine grayBg w10">Ref. Date</td>
        <td class="greenLine grayBg w10">Positioning Date</td>
        <td class="greenLine grayBg w20">Location</td>
        <td class="greenLine grayBg w10">Road #</td>
        {{--<td class="greenLine grayBg w25">--}}
            {{--<table>--}}
                {{--<tr>--}}
                    {{--<td class="greenLine grayBg noBorderTopBottom  borderBottom" colspan="4" style="text-align: center;">Flat Specification</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    <td class="greenLine grayBg   ">Building</td>
                    <td class="greenLine grayBg  ">Flat</td>
                    <td class="greenLine grayBg  ">Flat Type</td>
                    <td class="greenLine grayBg   " >Size (SFT)</td>
                {{--</tr>--}}
            {{--</table>--}}
        {{--</td>--}}
    </tr>
    @foreach($employee->quarter as $row)
    <tr>

        <td class="greenLine">{!! $row->allotment_reference or '' !!}</td>
        <td class="greenLine">{!! date('d/m/y',strtotime($row->reference_date)) !!}</td>
        <td class="greenLine">{!! date('d/m/y',strtotime($row->posting_date)) !!}</td>
        <td class="greenLine">{!! $row->location or '' !!}</td>
        <td class="greenLine">{!! $row->road or '' !!}</td>

        {{--<td class="greenLine">--}}
            {{--<table>--}}
                {{--<tr>--}}
                    <td class="greenLine  ">{!! $row->flat or '' !!}</td>
                    <td class="greenLine  ">{!! $row->building or '' !!}</td>
                    <td class="greenLine  ">{!! $row->flat_type or '' !!}</td>
                    <td class="greenLine   " >{!! $row->size_sft or '' !!}</td>
                {{--</tr>--}}
            {{--</table>--}}
        {{--</td>--}}
    </tr>
    @endforeach
</table>