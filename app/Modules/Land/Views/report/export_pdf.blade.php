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
                <th>খাজনা পরিশোধের তারিখ</th>
                <th>দাবির সন</th>
                <th>খাজনার পরিমাণ</th>
                <th>বকেয়া</th>
            </tr>
        </thead>
        <tbody>
        @if(count($lands) > 0)
            <?php $i = 1; $grandTotal = 0; $BokeyaGrandTotal = 0; ?>
            @foreach($lands as $land)
                <?php
                    $khajnaQuery = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id);
                    $khajnaInfos = $khajnaQuery->get();

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
                @if(count($khajnaInfos) > 0)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$land->title or ''}}</td>
                        <td>{{$land->zone->title or ''}}</td>
                        <td>{{$land->area->title or ''}}</td>
                        <td>{{$land->dag_no or ''}}</td>
                        <td>{{$land->khotian or ''}}</td>
                        <td>{{$land->quantity or ''}}</td>
                        
                        <td>
                            @if(count($khajnaInfos) > 0)
                                @foreach($khajnaInfos as $khajna)                                        
                                {{ $khajna->khajna_date or ''}}
                                <hr>                                    
                                @endforeach
                                <b>-</b>
                            @endif
                        </td>
                        <td style="width: 250px;">
                            @if(count($khajnaInfos) > 0)
                                @foreach($khajnaInfos as $khajna)                                        
                                {{$khajna->from_year or ''}} <?php if($khajna->to_year != 'null'){ echo "to ".$khajna->to_year; } ?>
                                <hr>                                    
                                @endforeach
                                <span>পরিশোধিত খাজনার পরিমাণ</span>
                            @endif
                        </td>
                        <td>
                            @if(count($khajnaInfos) > 0)
                            <?php $subTotal= 0; ?>
                                @foreach($khajnaInfos as $khajna)                                        
                                {{ $khajna->bokeya or ''}}
                                <?php $subTotal += bn2en($khajna->bokeya); ?>
                                <hr>                                    
                                @endforeach
                                <b>{{en2bn($subTotal)}}</b>
                                <?php $grandTotal += $subTotal; ?>
                            @endif
                        </td>
                        <td>
                            @foreach($khajnaInfos as $khajna)
                                - <hr>                                    
                            @endforeach
                            @if ($bokeya > 0)
                                <b>{{ en2bn($bokeya) }}</b>
                                <?php $BokeyaGrandTotal += bn2en($bokeya); ?>
                            @else
                                <b>০</b>
                            @endif
                        </td>
                    </tr>
                @endif  
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" style="text-align:right;"> <b>মোট : </b></td>
                <td><b>{{ en2bn($grandTotal) }}</b></td>
                <td><b>{{ en2bn($BokeyaGrandTotal) }}</b></td>
            </tr>
        @endif
        </tbody>
    </table>
@endif