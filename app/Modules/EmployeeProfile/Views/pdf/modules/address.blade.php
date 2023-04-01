<p class="title">Addresses:</p>
<table>
	<tr>
		<th class="greenLine grayBg" colspan="2">Present Address</th>

		<th class="greenLine grayBg " colspan="2">Permanent Address</th>
	</tr>
	<tr>
		<td class="greenLine grayBg " width="20%">Name of District</td>
		<td class="greenLine">{!! $present_address->district->name or '' !!}</td>

		<td class="greenLine grayBg " width="20%">Name of District</td>
		<td class="greenLine">{!! $permanent_address->district->name or '' !!}</td>
	</tr>
	<tr>
		<td class="greenLine grayBg ">Thana/Upazila</td>
		<td class="greenLine">{!! $present_address->thana->name or '' !!}</td>

		<td class="greenLine grayBg ">Thana/Upazila</td>
		<td class="greenLine">{!! $permanent_address->thana->name or '' !!}</td>
	</tr>
	<tr>
		<td class="greenLine grayBg ">Post Office</td>
		<td class="greenLine">{!! $present_address->postOffice->name or '' !!}</td>

		<td class="greenLine grayBg ">Post Office</td>
		<td class="greenLine">{!! $permanent_address->postOffice->name or '' !!}</td>
	</tr>
        <tr>
		<td class="greenLine grayBg ">Post Code</td>
		<td class="greenLine">{!! $present_address->postOffice->zip_code or '' !!}</td>

		<td class="greenLine grayBg ">Post Code</td>
		<td class="greenLine">{!! $permanent_address->postOffice->zip_code or '' !!}</td>
	</tr>
	<tr>
		<td class="greenLine grayBg ">Village/Road etc.</td>
		<td class="greenLine">{!! $present_address->village_road or '' !!}</td>

		<td class="greenLine grayBg ">Village/Road etc.</td>
		<td class="greenLine">{!! $permanent_address->village_road or '' !!}</td>
	</tr>
	
	<tr>
		<td class="greenLine grayBg ">Phone & Mobile No.</td>
		<td class="greenLine">{!! $present_address->mobile or '' !!}</td>

		<td class="greenLine grayBg ">Phone & Mobile No.</td>
		<td class="greenLine">{!! $permanent_address->mobile or '' !!}</td>
	</tr>

</table>
