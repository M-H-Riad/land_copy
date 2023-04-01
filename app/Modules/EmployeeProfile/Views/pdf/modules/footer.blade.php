<br/><br/>
<table>
	<tr>
		<td colspan="2">
			<p><span>I do hereby solemnly declare that the above statements are true and correct.</span></p>
		</td>
	</tr>
	<tr>
		<td class="w50" style="vertical-align: bottom;"><p style="font-size: 10px;">
				@if($employee->document->where('file_type_id',2)->last())
					<img style="width: 150px;" src="{{public_path().'/'. $employee->document->where('file_type_id',2)->last()->file_path}}" alt="Default Signature">
				@else
					<br/>
					<br/>
					<br/>
					{{--<img style="width: 80px;" src="{{public_path()}}/images/signature-scan.png" width="100" alt="Default Signature">--}}
				@endif
					<br>
					Signature of the employee
				<br/>
				PDF Generated Date: {{date('d/m/Y h:i:s a')}}
			</p>
		</td>
		<td class="w50" style="vertical-align: bottom; text-align: right"><p style="font-size: 10px;">Signature & seal of head of the office</p></td>
	</tr>
</table>