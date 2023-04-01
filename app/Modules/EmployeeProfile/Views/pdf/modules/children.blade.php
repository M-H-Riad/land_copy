<p class="title">Children Information:</p>
<table>
	<tr>
		<td class="greenLine grayBg" colspan="2">Name of Children</td>
		<td class="greenLine grayBg text-center">Sex</td>
		<td class="greenLine grayBg text-center">Date of Birth</td>
		<td class="greenLine grayBg text-center">Profession</td>
	</tr>
	<?php $c = 1; ?>
	@foreach($employee->children as $children)
        <tr>
            <td class="w5 greenLine">{!! $c !!}</td>
            <td class="w35 greenLine">{!! $children->children_name or '' !!}</td>
            <td class="w20 greenLine text-center">{!! ucfirst($children->sex) !!}</td>
            <td class="w20 greenLine text-center">{!! date('d/m/y',strtotime($children->date_of_birth)) !!}</td>
            <td class="w20 greenLine text-center">{!! $children->profession or '' !!}</td>
        </tr>
        <?php $c++; ?>
    @endforeach
</table>