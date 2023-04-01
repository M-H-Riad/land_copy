<p class="title">Leave:</p>
<table>
	<tr>
		<td class="greenLine grayBg w25">Ref. No.</td>
		<td class="greenLine grayBg">Ref Date</td>
		<td class="greenLine grayBg">Leave Type</td>
		<td class="greenLine grayBg">Date From</td>
		<td class="greenLine grayBg">Date To</td>
		<td class="greenLine grayBg">Approval</td>
		<td class="greenLine grayBg">Details</td>
	</tr>
	@foreach($employee->leave as $row)
        <tr>
            <td class="greenLine">{!! $row->ref_no or '' !!}</td>
            <td class="greenLine">{!! dateFormat($row->ref_date) !!}</td>
			<td class="greenLine">{!! $row->type->title or '' !!}</td>
           	<td class="greenLine">{!! dateFormat($row->from_date) !!}</td>
			<td class="greenLine">{!! dateFormat($row->to_date) !!}</td>
            <td class="greenLine">{!! $row->approval or '' !!}</td>
            <td class="greenLine">{!! $row->details or '' !!}</td>
        </tr>
    @endforeach
</table>