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
@if($khajnaInfos)
    <table>
        <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>স্থাপনার নাম</th>
            <th>খাজনার তারিখ</th>
            <th>দাবির সন (বাংলা)</th>
            <th>মৌজা</th>
            <th>ভূমি অফিসের নাম</th>
            <th>খাজনার পরিমাণ</th>
            <th>মন্তব্য</th>
        </tr>
        </thead>
        <tbody>
        @if(count($khajnaInfos) > 0)
            <?php $i = 1; $totalAmount=0; ?>
            @foreach($khajnaInfos as $khajnaInfo)
                <tr>
                    <td>{{ en2bn($i++) }}</td>
                    <td>{{$khajnaInfo->land->title or ''}}</td>
                    <td>{{$khajnaInfo->khajna_date or ''}}</td>
                    <td>{{$khajnaInfo->from_year or ''}} to {{ $khajnaInfo->to_year or ''}}</td>
                    <td>{{$khajnaInfo->land->area->title or ''}}</td>
                    <td>{{$khajnaInfo->khajna_office->office_name or ''}}</td>
                    <td>{{$khajnaInfo->bokeya or ''}}</td>
                    <?php $totalAmount += bn2en($khajnaInfo->bokeya); ?>
                    <td>{{$khajnaInfo->note or ''}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right;"><b>মোট:</b></td>
                <td><b>{{ en2bn($totalAmount) }} </b></td>
                <td></td>
            </tr>
        @endif
        </tbody>
    </table>
@endif