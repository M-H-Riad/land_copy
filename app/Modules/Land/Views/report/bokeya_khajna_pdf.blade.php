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
            <th>জোন</th>
            <th>মৌজা</th>
            <th>দাগ নং</th>
            <th>খতিয়ান নং</th>
            <th>জমির পরিমান (একর)</th>
            <th>খাজনাকৃত জমির পরিমান (একর)</th>
            <th>পরিশোধিত খাজনার পরিমাণ</th>
            <th>মোট বকেয়া</th>
        </tr>
    </thead>
    <tbody>
        @if(count($lands) > 0)
            <?php $i = 1; $totalLand = 0; $totalKhajnaLand = 0; $totalKhajnaPaid = 0; $grandTotalBokeya = 0; ?>
            @foreach($lands as $land)
                <?php
                    // $khajnaPaid = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->sum('bokeya');
                    
                    // //Bokeya calculation.........
                    // $totalBokeya = App\Modules\Land\Models\KhajnaOfficeInfo::where('land_id', $land->id)->sum('total_bokeya');
                    // $bokeya = ($totalBokeya - $khajnaPaid);

                    //Bokeya calculation.........
                    $bokeyaArray = App\Modules\Land\Models\KhajnaOfficeInfo::where('land_id', $land->id)->get();
                    $paidArray = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->get();
                    $totalBokeya =0;
                    $totalPaid =0;
                    foreach ($bokeyaArray as $key => $bokeya) {
                        $totalBokeya += bn2en($bokeya->total_bokeya);
                    }
                    foreach ($paidArray as $key => $paid) {
                        $totalPaid += bn2en($paid->bokeya);
                    }
                    $bokeya = ($totalBokeya - $totalPaid);
                ?>
                @if(count($totalPaid) > 0)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$land->title or ''}}</td>
                        <td>{{$land->zone->title or ''}}</td>
                        <td>{{$land->area->title or ''}}</td>
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
                        
                        
                        <td>
                            {{ en2bn($totalPaid) }}
                            <?php $totalKhajnaPaid += $totalPaid; ?>
                        </td>
                        <td>                                      
                            {{ en2bn($bokeya) }}
                            <?php $grandTotalBokeya += $bokeya; ?>
                        </td>
                    </tr>
                @endif  
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" style="text-align:center"> <b>মোট : </b></td>
                <td><b>{{ en2bn($totalLand) }}</b></td>
                <td><b>{{ en2bn($totalKhajnaLand) }}</b></td>
                <td><b>{{ en2bn($totalKhajnaPaid) }}</b></td>
                <td><b>{{ en2bn($grandTotalBokeya) }}</b></td>
            </tr>
        @endif
    </tbody>
</table>
@endif