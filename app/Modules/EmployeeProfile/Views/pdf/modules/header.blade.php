<table>
    <tr>

        <td style="width: 80%;"> <!-- Content  -->

            <table class="engOnly">
                <tr>
                    <td style="text-align: center;" colspan="2">
                        <table>
                            <tr>
                                <td><img src="{{public_path()}}/PIMS%20Data%20Collection%20Form_files/image002.jpg" alt="WASA-PIMS"></td>
                                <td>
                                    <h2 class="page-title">Dhaka Water Supply &amp; Sewerage Authority</h2>
                                    <p style="text-align: center">Personnel Information Management System (PIMS)</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table class="engOnly">
                            <tr>
                                <td class="greenLine grayBg">WASA Employee ID</td>
                                <td class="greenLine">{{ $employee->employee_id or '' }}</td>
                            </tr>
                            <tr>
                                <td class="greenLine grayBg">WASA ID</td>
                                <td class="greenLine">{{ $employee->wasa_id or '' }}</td>
                            </tr>
                            <tr>
                                <td class="greenLine grayBg">National ID Number</td>
                                <td class="greenLine">{{ $employee->nid or '' }}</td>
                            </tr>
                            
                        </table>
                    </td>
                    <td>
                        <table class="engOnly">
                            <tr>
                                <td class="" style="text-align: right; font-family: Arial">
                                    <strong>{!! $employee->first_name or '' !!} {!! $employee->middle_name or '' !!} {!! $employee->last_name or '' !!}</strong>
                                    <br/>{!! $employee->designation->title or '' !!}
                                    <br/>{!! $employee->department->department_name or '' !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </td>

        <td style="width: 20%;"> <!-- Image  -->
            @if($employee->document->where('file_type_id',1)->last())
                <img style="width: 111px; float: right; border: 1px solid gray;" src="{{public_path().'/'. $employee->document->where('file_type_id',1)->last()->file_path}}" alt="Picture">
            @else
                <img style="width: 111px; float: right; border: 1px solid gray;" src="{{public_path()}}/images/default_avatar_male.jpg" alt="Default Picture">
            @endif
        </td>

    </tr>
</table>