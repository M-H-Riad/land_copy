<table>
	<tr>

		<td style="width: 80%;"> <!-- Content  -->
			
			<table>
				<tr>
					<td style="text-align: right;" colspan="2">
						<table>
							<tr>
								<td><img src="{{public_path()}}/PIMS%20Data%20Collection%20Form_files/image002.jpg" alt="WASA-PIMS"></td>
								<td>
									<h2>Dhaka Water Supply &amp; Sewerage Authority</h2>
									<p>Personnel Information Management System (PIMS) Data Form # 01</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td class="greenLine grayBg w50" style="width: 50%;"><b>WASA Employee ID (If Any)</b></td>
					<td class="greenLine">{{ $employee->employee_id }}</td>
				</tr>
				<tr>
					<td class="greenLine grayBg w50" style="width: 50%;"><b>National ID Number</b></td>
					<td class="greenLine">{{ $employee->nid }}</td>
				</tr>
			</table>

		</td>

		<td style="width: 20%;"> <!-- Image  -->
			@if($employee->document->where('file_type_id',1)->last())
                <img style="width: 120px; float: right; border: 1px solid #0000ff;" src="{{public_path()}}/{{$employee->document->where('file_type_id',1)->last()->file_path}}" alt="Default Signature">
            @else
                <img style="width: 120px; float: right; border: 1px solid #0000ff;" src="{{public_path()}}/images/default_avatar_male.jpg" width="150" alt="Default Signature">
            @endif
		</td>

	</tr>
</table>
