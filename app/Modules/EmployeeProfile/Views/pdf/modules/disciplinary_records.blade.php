<p class="title">Disciplinary Records:</p>
<table>
        
        <thead>
          <tr>
            <th class="greenLine grayBg" colspan="4" style="text-align: center;font-size: 10px;">Departmental Case</th>
            <th class="greenLine grayBg" colspan="3" style="text-align: center;font-size: 10px;">Result of Departmental Case</th>
          </tr>
          <tr>
            <th class="greenLine grayBg" style="font-size: 10px;">Reference No.</th>
            <th class="greenLine grayBg" style="font-size: 10px;">Reference Date</th>
            <th class="greenLine grayBg" style="font-size: 10px;">Case No.</th>
            <th class="greenLine grayBg" style="font-size: 10px;">Allegation/Grievance as per <br> DWASA Regulations</th>
            <th class="greenLine grayBg" style="font-size: 10px;">Reference No</th>
            <th class="greenLine grayBg" style="font-size: 10px;">Reference Date</th>
            <th class="greenLine grayBg" style="font-size: 10px;">Result</th>
          </tr>
        </thead>

        <tbody>
          @foreach($employee->disciplinary_record as $row)
          <tr>
            <td class="greenLine">{!! $row->ref_no or '' !!}</td>
            <td class="greenLine">{!! dateFormat($row->ref_date) !!}</td>
            <td class="greenLine">{!! $row->case_no or '' !!}</td>
            <td class="greenLine">{!! $row->allegation or '' !!}</td>
            <td class="greenLine">{!! $row->result_ref_no or '' !!}</td>
            <td class="greenLine">{!! dateFormat($row->result_ref_date) !!}</td>
            <td class="greenLine">{!! $row->result or '' !!}</td>
          </tr>
          @endforeach
        </tbody>

      </table>
<!--<table>
    <tr>
        <td class="w50">
            <table>
                <tr>
                    <td class="greenLine grayBg" colspan="3" style="text-align: center;">Suspension Information</td>
                </tr>
                <tr>
                    <td class="greenLine grayBg w50" style="font-size: 10px;">Office Order No.</td>
                    <td class="greenLine grayBg" style="font-size: 10px;">Date</td>
                    <td class="greenLine grayBg " style="font-size: 10px;">Clause as per DWASA Regulations</td>
                </tr>
                @foreach($employee->suspension->where('type','suspension') as $row)
                <tr>
                    <td class="greenLine">{!! $row->office_order_no or '' !!}</td>
                    <td class="greenLine">{!! date('d/m/y',strtotime($row->order_date)) !!}</td>
                    <td class="greenLine">{!! $row->clause or '' !!}</td>
                </tr>
                @endforeach
            </table>
        </td>
        <td class="w50">
            <table>
                <tr>
                    <td class="greenLine grayBg" colspan="3" style="text-align: center;">Suspension Withdrawn Information</td>
                </tr>
                <tr>
                    <td class="greenLine grayBg w50" style="font-size: 10px;">Office Order No.</td>
                    <td class="greenLine grayBg" style="font-size: 10px;">Date</td>
                    <td class="greenLine grayBg" style="font-size: 10px;">Punishment in Brief</td>
                </tr>
                @foreach($employee->suspension->where('type','withdrawn') as $row)
                <tr>
                    <td class="greenLine">{!! $row->office_order_no or '' !!}</td>
                    <td class="greenLine">{!! date('d/m/y',strtotime($row->order_date)) !!}</td>
                    <td class="greenLine">{!! $row->clause or '' !!}</td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>-->
