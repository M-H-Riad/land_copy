<p class="title">Transfer Records:</p>
<table>
    <tr>
        <td class="greenLine grayBg w30">Office Order No</td>
        <td class="greenLine grayBg w10">Date</td>
        <td class="greenLine grayBg w10">With Promotion</td>
        <td class="greenLine grayBg w20">Designation</td>
        <td class="greenLine grayBg w25">Division/Zone/Office</td>
    </tr>
    @foreach($employee->transfer as $row)
    <tr>
        <td class="greenLine">{!! $row->office_order_no or '' !!}</td>
        <td class="greenLine">{!! date('d/m/y',strtotime($row->order_date)) !!}</td>
        <td class="greenLine">{!! $row->is_promotion? 'Yes':'No' !!}</td>
        <td class="greenLine">{!! $row->designation->title or '' !!}</td>
        <td class="greenLine">{!! $row->department->department_name or '' !!}</td>
    </tr>
    @endforeach
</table>