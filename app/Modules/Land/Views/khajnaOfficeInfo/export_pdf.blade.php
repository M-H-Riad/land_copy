<style type="text/css">
    @font-face {
        font-family: bf;
        src: url("sol.ttf");format("truetype");
    }

    body {
        font-family: bf;
        font-size: 18px;
    }

    p {
        margin-bottom: 0;
        margin-top: 0;
        font-size: 18px;
    }
    table{
        width: 100%;
        margin: 0 auto;
        border-collapse: collapse;
    }
    table tr{
        margin-top: 5px;
    }
    th{
        padding: 5px;
        border: 1px solid #0a0a0a;
    }
    td{
        padding: 5px;
        border: 1px solid #0a0a0a;
    }
</style>
@if($khajnaOffices)
    <table>
        <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>স্থাপনার নাম</th>
            <!-- <th>উপজেলা</th>
            <th>মৌজা</th> -->
            <th>ভূমি অফিসের নাম</th>
            <th>ওপেনিং কর দাবির সন</th>
            <th>বকেয়ার পরিমাণ</th>
            <th>বকেয়া কর দাবির সন (বাংলা)</th>
        </tr>
        </thead>
        <tbody>
        @if(count($khajnaOffices) > 0)
            <?php $i = 1; $totalBokeya =0; ?>
            @foreach($khajnaOffices as $khajnaOffice)
                <tr>
                    <td>{{ en2bn($i++) }}</td>
                    <td>{{$khajnaOffice->land->title or ''}}</td>
                    <!-- <td>{{$khajnaOffice->upazila->upazila_name or ''}}</td>
                    <td>{{$khajnaOffice->mowza->mowja_name or ''}}</td> -->
                    <td>{{$khajnaOffice->mokhajna_office->office_name or ''}}</td>
                    <td>{{$khajnaOffice->open_year or ''}}</td>
                    <td>{{$khajnaOffice->total_bokeya or ''}}</td>
                    <?php $totalBokeya += bn2en($khajnaOffice->total_bokeya); ?>
                    <td>{{$khajnaOffice->from_year or '-'}} <?php echo " -- "; ?> {{ $khajnaOffice->to_year or '-' }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right;"><b>মোট:</b></td>
                <td><b>{{ en2bn($totalBokeya) }} </b></td>
                <td></td>
            </tr>
        @endif
        </tbody>
    </table>
@endif