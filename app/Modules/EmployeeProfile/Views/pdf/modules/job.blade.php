<p class="title">Promotion Information:</p>
<table>
	<tr>
		<td class="greenLine grayBg w30">Office Order No & Date</td>
		<td class="greenLine grayBg">Joining Date</td>
		<td class="greenLine grayBg w20">Designation</td>
		<td class="greenLine grayBg w15">Office/Zone</td>
		<td class="greenLine grayBg text-center">Grade</td>
		<td class="greenLine grayBg w10">Basic Pay (Taka)</td>
	</tr>
	@foreach($employee->wasaJobExprience as $row)
        <tr>

            <td class="greenLine">{!! $row->office_order_no or '' !!} , {!! date('d/m/y',strtotime($row->order_date)) !!}</td>
            <td class="greenLine">{!! date('d/m/y',strtotime($row->joining_date)) !!}</td>
            
            <td class="greenLine">{!! $row->designation->title or '' !!} 
            
                @if($row->designation_status and $row->designation_status !=='1')
                ({!! getDesignatioStatusTitle($row->designation_status) !!})
                @endif
            
            </td>
            
            <td class="greenLine">{!! $row->department->department_name or '' !!}</td>
            <td class="greenLine text-center">{!! $row->scale->grade or '' !!}</td>
            <td class="greenLine">{!! taka_format($row->basic_pay) !!}</td>

        </tr>
    @endforeach
</table>