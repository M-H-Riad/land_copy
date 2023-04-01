<p class="title">Membership:</p>
<table>
	<tr>
        <td class="w50">
        	<table>
        		<tr>
        			<td class="greenLine grayBg ">Professional Body</td>
					<td class="greenLine grayBg w20">Membership No</td>
        		</tr>
        		<?php $is_not_fee_paid = 0; ?>
        		@foreach($employee->membership as $row)

					@if($row->organization->org_type == 0)

						<tr>
							<td class="greenLine">{!! $row->organization->title or '' !!}</td>
							<td class="greenLine">{!! $row->membership_no or '' !!}</td>
						</tr>

						<?php $is_not_fee_paid++; ?>

					@endIf

			    @endforeach

        	</table>
        </td>
        <td class="w50">
        	<table>
        		<tr>
        			<td class="greenLine grayBg">Dhaka WASA Association <br>(Fee Paid Group)</td>
        		</tr>
        		<?php $org_type = 0; ?>
        		@foreach($employee->membership as $row)

					@if($row->organization->org_type == 1)

						<tr>
							<td class="greenLine">{!! $row->organization->title or '' !!}</td>
						</tr>

						<?php $org_type++; ?>

					@endIf

			    @endforeach

        	</table>
        </td>
    </tr>
</table>