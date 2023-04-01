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
@if($lands)
    <table>
        <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>স্থাপনার নাম</th>
            <th>জেলা</th>
            <th>থানা</th>
            @if(!isset($zone))
            <th>জোন</th>
            @endif
            <th>মৌজা</th>
            <th>প্রাপ্তি উৎস</th>
            <th>ঠিকানা</th>
            <th> দাগ নং</th>
            <th>খতিয়ান নং</th>
            <th>জমির পরিমান (একর)</th>
            <th>খাজনা প্রদানকৃত জমির পরিমান  (একর)</th>
            <!-- <th>প্রাপ্তি উৎস</th> -->
            <th>বর্তমান অবস্থা</th>
            {{-- <th>ভূমি উন্নয়ন করের বিবরণ</th>
            <th>নামজারীর বিবরণ</th> --}}
            <th>মন্তব্য</th>
        </tr>
        </thead>
        <tbody>
        @if(count($lands) > 0)
            <?php $i = 1; $totalLand = 0; $totalKhajnaLand = 0; ?>
            @foreach($lands as $land)
                <tr>
                    <td>{{ en2bn($i++) }}</td>
                    <td>{{$land->title or ''}}</td>
                    <td>{{$land->zila->title or ''}}</td>
                    <td>{{$land->thana->title or ''}}</td>
                    @if(!isset($zone))
                    <td>মডস {{$land->zone->title or ''}}</td>
                    @endif
                    <td>{{$land->area->title or ''}}</td>
                    <td>{{$land->source->title or ''}}</td>
                    <td>{{$land->address or ''}}</td>
                    <td>{{$land->dag_no or ''}}</td>
                    <td>{{$land->khotian or ''}}</td>
                    <td>
                        {{$land->quantity or ''}}
                        <?php $totalLand += bn2en($land->quantity); ?>
                    </td>
                    <td>
                        {{$land->khajna_land or ''}}
                        <?php $totalKhajnaLand += bn2en($land->khajna_land); ?>
                    </td>
                    {{-- <td>{{$land->ownership_details or ''}}</td> --}}
                    <td>{{$land->current_status or ''}}</td>
                    {{-- <td>{{$land->khajna or ''}}</td> --}}
                    {{-- <td>{{$land->namjari or ''}}</td> --}}
                    <td>{{$land->comment or ''}}</td> 
                </tr>
            @endforeach
            <tr>
                <td @if(!isset($zone)) colspan="10" @else colspan="9" @endif style="text-align: right;">মোট:</td>
                <td><b>{{ en2bn($totalLand) }}</b></td>
                <td><b>{{ en2bn($totalKhajnaLand) }}</b></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="align-center">
        <span><b>মোট জমির পরিমাণ: {{ en2bn($totalLand) }} একর</b></span> <br>
        <span><b>মোট খাজনা প্রদানকৃত জমির পরিমাণ: {{ en2bn($totalKhajnaLand) }} একর</b></span>
    </div>
@endif