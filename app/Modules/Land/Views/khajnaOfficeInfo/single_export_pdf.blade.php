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

    table {
        width: 100%;
        margin: 0 auto;
        border-collapse: collapse;
    }

    table tr {
        margin-top: 5px;
    }

    th {
        padding: 5px;
        border: 1px solid #0a0a0a;
    }

    td {
        padding: 5px;
        border: 1px solid #0a0a0a;
    }
</style>
@if($khajnaOfficeInfo)
    <table>
        <thead>
        <tr>
            <th>স্থাপনার নাম</th>
            <td>{{$khajnaOfficeInfo->land->title or ''}}</td>
        </tr>
        <!-- <tr>
            <th>উপজেলার নাম</th>
            <td>{{$khajnaOfficeInfo->upazila->upazila_name or ''}}</td>
        </tr>
        <tr>
            <th>মৌজার নাম</th>
            <td>{{$khajnaOfficeInfo->mowza->mowja_name or ''}}</td>
        </tr> -->
        <tr>
            <th>ভূমি অফিসের নাম</th>
            <td>{{$khajnaOfficeInfo->mokhajna_office->office_name or ''}}</td>
        </tr>
        <tr>
            <th>ওপেনিং কর দাবির সন</th>
            <td>{{$khajnaOfficeInfo->open_year or ''}}</td>
        </tr>
        <tr>
            <th>বকেয়ার পরিমাণ</th>
            <td>{{$khajnaOfficeInfo->total_bokeya or ''}}</td>
        </tr>
        <tr>
            <th>ভূমি অফিসের নাম</th>
            <td>{{$khajnaOfficeInfo->from_year or '-'}} <?php echo " -- "; ?> {{ $khajnaOfficeInfo->to_year or '-' }}</td>
        </tr>
        </thead>
    </table>
@endif