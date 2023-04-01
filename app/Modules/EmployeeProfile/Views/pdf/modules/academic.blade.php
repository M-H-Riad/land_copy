<p class="title">Academic Career:</p>
<table>
	<tr>
		<td class="greenLine grayBg">Qualification</td>
		<td class="greenLine grayBg">Discipline</td>
		<td class="greenLine grayBg">Board/University</td>
		<td class="greenLine grayBg">Name of Institution</td>
		<td class="greenLine grayBg">Major Subjects</td>
		<td class="greenLine grayBg">Year of Passing</td>
		<td class="greenLine grayBg">Class/Div/ Grade</td>
	</tr>
	@foreach($employee->education as $row)
        <tr>
            <td class="w10 greenLine">{!! $row->qualification->title or '' !!}</td>
            <td class="w20 greenLine">{!! $row->discipline or '' !!}</td>
            <td class="w20 greenLine">{!! $row->board or '' !!}</td>
            <td class="w20 greenLine">{!! $row->institute or '' !!}</td>
            <td class="w20 greenLine">{!! $row->major or '' !!}</td>
            <td class="w5 greenLine">{!! $row->passing_year or '' !!}</td>
            <td class="w5 greenLine">{!! $row->grade or '' !!}</td>
        </tr>
    @endforeach
</table>