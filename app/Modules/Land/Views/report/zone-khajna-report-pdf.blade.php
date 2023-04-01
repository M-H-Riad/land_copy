<style type="text/css">
    @font-face {
        font-family: bf;
        src: url("sol.ttf");format("truetype");
    }

    body {
        font-family: bf;
        /* font-size: 15px; */
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
        /* padding: 1px; */
        border: 1px solid #0a0a0a;
    }
    td{
        border-bottom: 1px solid #0a0a0a;
        border-right: 1px solid #0a0a0a;
        /* border: 1px solid #0a0a0a; */
        /* font-size: 15px !important; */
    }

    td {
        white-space: nowrap  !important;
    }
    tr td:last-child {
        border-bottom: none !important;
    }
    tr > td:last-of-type {
        border-bottom: none !important;
    }
</style>
@if($zones)
<table>
    <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>জোন</th>
            <th>স্থাপনার নাম</th>
            <th>মৌজা</th>
            <th>দাগ নং</th>
            <th>খতিয়ান নং</th>
            <th>জমির পরিমান (একর)</th>
            <th>খাজনাকৃত জমি (একর)</th>
            <th>মোট খাজনার পরিমাণ</th>
            <th>মোট বকেয়া</th>
        </tr>
    </thead>
    <tbody>
        @if(count($zones) > 0)
            <?php $i = 1; $grandTotalPaid = 0; $grandTotalBokeya = 0; ?>
            @foreach($zones as $zone)
                <?php
                    $subTotalPaid= 0;
                    $subTotalBokeya= 0;
                    $lands = App\Modules\Land\Models\Land::where('zone_id', $zone->id)->get();
                ?>
                @if(count($lands) > 0)
                <tr style="border: 1px solid black;">
                    <td>{{ $i++ }}</td>
                    <td>{{ $zone->title or ''}}</td>
                    <td>
                        <table>
                            @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->title or '-'}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table>
                            @foreach($lands as $land)
                                <tr>
                                    @if (isset($land->area))
                                        <td style="border-right: none;">
                                            {{$land->area->title or '-'}}
                                        </td>
                                    @else
                                    <td>-</td> 
                                    @endif
                                    
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table>
                            @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">
                                         {{$land->dag_no or '-'}} 
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table>
                            @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->khotian or '-'}}</td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td colspan="4" style="text-align: right;"><b>উপ -মোট</b></td>
                            </tr> --}}
                        </table>
                    </td>
                    <td>
                        <table>
                            @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->quantity or '-'}}</td>
                                    <?php $subTotalQuantity += bn2en($land->quantity); ?>
                                </tr>
                            @endforeach
                            <?php $grandTotalQuantity += $subTotalQuantity; ?>
                            {{-- <tr>
                                <td><b>{{$subTotalQuantity}}</b></td>
                            </tr> --}}
                        </table>
                    </td>
                    <td>
                        <table>
                            @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->khajna_land or '-'}}</td>
                                    <?php $subTotalLand += bn2en($land->khajna_land); ?>
                                </tr>
                            @endforeach
                            <?php $grandTotalLand += $subTotalLand; ?>
                        </table>
                    </td>
                    
                    <td>
                        <table>
                            @foreach($lands as $land)
                                <?php
                                    // $totalKhajnaPaid = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->sum('bokeya');
                                    $paidArray = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->get();
                                    $totalKhajnaPaid =0;
                                    foreach ($paidArray as $key => $paid) {
                                        $totalKhajnaPaid += bn2en($paid->bokeya);
                                    }
                                ?>
                                <tr>
                                    <td style="none; border-right: none;">{{ en2bn($totalKhajnaPaid) }}</td>
                                    <?php $subTotalPaid += $totalKhajnaPaid; ?>
                                </tr>
                            @endforeach
                            <?php $grandTotalPaid += $subTotalPaid; ?>
                            {{-- <tr>
                                <td><b>{{$subTotalPaid}}</b></td>
                            </tr> --}}
                        </table>
                    </td>
                    <td>
                        <table>
                            @foreach($lands as $land)
                                <?php
                                    // //Bokeya calculation.........
                                    // $totalBokeya = App\Modules\Land\Models\KhajnaOfficeInfo::where('land_id', $land->id)->sum('total_bokeya');
                                    // $totalPaid = App\Modules\Land\Models\KhajnaInfo::where('land_id', $land->id)->sum('bokeya');
                                    // $bokeya = ($totalBokeya - $totalPaid);

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
                                
                                <tr>
                                    <td style="none; border-right: none;">{{ en2bn($bokeya) }}</td>
                                    <?php $subTotalBokeya += $bokeya; ?>
                                </tr>
                            @endforeach
                            <?php $grandTotalBokeya += $subTotalBokeya; ?>
                            {{-- <tr>
                                <td><b>{{$subTotalBokeya}}</b></td>
                            </tr> --}}
                        </table>
                    </td>
                </tr>
                @endif 
            @endforeach
            <tr>
                <td style="border-left: 1px solid black;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right"> <b>মোট : </b></td>
                <td><b>{{ en2bn($grandTotalQuantity) }} (একর)</b></td>
                <td><b>{{ en2bn($grandTotalLand) }} (একর)</b></td>
                <td><b>{{ en2bn($grandTotalPaid) }}</b></td>
                <td><b>{{ en2bn($grandTotalBokeya) }}</b></td>
            </tr>
        @endif
    </tbody>
</table>

@endif

