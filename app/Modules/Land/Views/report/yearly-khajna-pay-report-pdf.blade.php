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
        padding: 2px;
        border: 1px solid #0a0a0a;
    }

    td {
        white-space: nowrap;
        vertical-align: text-top !important;

        border-bottom: 1px solid black !important;
        border-right: 1px solid black !important;
    }
    tr:last-child {
        border-bottom: none !important;
    }
</style>
@if($khajnaPayYears)
<table>
    <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>খাজনা পরিশোধের সন</th>
            <th>স্থাপনার নাম</th>
            <th>জোন</th>
            <th>মৌজা</th>
            <th>দাগ নং</th>
            <th>খতিয়ান নং</th>
            <th>জমির পরিমান (একর)</th>
            <th>মোট খাজনার পরিমাণ</th>
        </tr>
    </thead>
    <tbody>
        @if(count($khajnaPayYears) > 0)
            <?php $i = 1; $grandTotal = 0; ?>
            @foreach($khajnaPayYears as $year)
                <?php
                    $subTotal= 0;
                    $khajnaInfoLandId = App\Modules\Land\Models\KhajnaInfo::where('khajna_date_year', $year->year)->pluck('land_id');

                    $landQuery = App\Modules\Land\Models\Land::whereIn('id', $khajnaInfoLandId);
                    $lands = $landQuery->get();
                ?>
                @if(count($lands) > 0)
                    <tr style="border: 1px solid black;">
                        <td>{{ $i++ }}</td>
                        <td>{{ $year->year or ''}}</td>
                        <td>
                            <table class="chield-table">
                                @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->title or ''}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                            <table class="chield-table">
                                @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->zone->title or ''}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                            <table class="chield-table">
                                @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->area->title or ''}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                            <table class="chield-table">
                                @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->dag_no or ''}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                            <table class="chield-table">
                                @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->khotian or ''}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                            <table class="chield-table">
                                @foreach($lands as $land)
                                <tr>
                                    <td style="border-right: none;">{{$land->quantity or ''}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="text-right" style="border-bottom: none; border-right: none;">পরিশোধিত মোট খাজনার পরিমাণ:</td>
                                </tr>
                            </table>
                        </td>
                        
                        <td>
                            <table class="chield-table">
                                @foreach($lands as $land)
                                <?php
                                    // $totalYearlyKhajna = App\Modules\Land\Models\KhajnaInfo::where('khajna_date_year', $year->year)
                                    //         ->where('land_id', $land->id)->sum('bokeya');
                                    $totalYearlyKhajnaArray = App\Modules\Land\Models\KhajnaInfo::where('khajna_date_year', $year->year)
                                                            ->where('land_id', $land->id)->get();
                                    $totalYearlyKhajna =0;
                                    foreach ($totalYearlyKhajnaArray as $key => $khajna) {
                                        $totalYearlyKhajna += bn2en($khajna->bokeya);
                                    }
                                ?>
                                <tr>
                                    <td style="border-right: none;">{{ en2bn($totalYearlyKhajna) }}</td>
                                    <?php $subTotal += bn2en($totalYearlyKhajna); ?>
                                </tr>
                                @endforeach
                                <tr>
                                    <td style="border-right: none; border-bottom: none;"><b>{{ en2bn($subTotal) }}</b></td>
                                    <?php $grandTotal += $subTotal; ?>
                                </tr>
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
                <td colspan="3" class="text-right"> <b>মোট : </b></td>
                <td><b>{{ en2bn($grandTotal) }}</b></td>
            </tr>
        @endif
    </tbody>
</table>

@endif

