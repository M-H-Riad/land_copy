<p class="title">Training:</p>
<table>
	<tr>
		<td class="greenLine grayBg w25">Training Course Title</td>
		<td class="greenLine grayBg">Place/City</td>
		<td class="greenLine grayBg">Institution</td>
		<td class="greenLine grayBg">Country</td>
		<td class="greenLine grayBg">Financed By</td>
		<td class="greenLine grayBg">Amount</td>
		<td class="greenLine grayBg">Year</td>
		<td class="greenLine grayBg">Duration</td>
	</tr>
	@foreach($employee->training as $row)
        <tr>
            <td class="greenLine">{!! $row->course_title or '' !!}</td>
            <td class="greenLine">{!! $row->place or '' !!}</td>
            <td class="greenLine">{!! $row->institution or '' !!}</td>
           	<td class="greenLine">{!! $row->country or '' !!}</td>
			<td class="greenLine">{!! $row->finance_by or '' !!}</td>
            <td class="greenLine">{!! taka_format($row->amount)!!}</td>
            <td class="greenLine">{!! $row->year or '' !!}</td>
            <td class="greenLine">{!! $row->duration or '' !!}</td>
        </tr>
    @endforeach
</table>