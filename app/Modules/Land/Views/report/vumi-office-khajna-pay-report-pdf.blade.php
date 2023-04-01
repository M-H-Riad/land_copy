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
@if($vumiOffices)
<table class="nopagination">
    <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>ভূমি অফিসের নাম</th>
            <th>স্থাপনার নাম</th>
            <th>জোন</th>
            <th>মৌজা</th>
            <th>দাগ নং</th>
            <th>খতিয়ান নং</th>
            <th>জমির পরিমান (একর)</th>
            <th>খাজনা পরিশোধের তারিখ</th>
            <th>দাবির সন</th>
            <th>মোট খাজনার পরিমাণ</th>
        </tr>
    </thead>
    <tbody>
        @if(count($vumiOffices) > 0)
            <?php $i = 1; $grandTotal = 0; ?>
            @foreach($vumiOffices as $vumiOffice)
                    <?php
                    $vumiOfficeLandIds = App\Modules\Land\Models\KhajnaOfficeInfo::where('khajna_office_id', $vumiOffice->id)->pluck('land_id');
                    $landQuery = App\Modules\Land\Models\Land::whereIn('id', $vumiOfficeLandIds);                                    
                    $lands = $landQuery->get();
                    $landIds = $landQuery->pluck('id');
                ?>
                
                @if(count($lands) > 0)
                        <?php
                            $khajnaQuery = App\Modules\Land\Models\KhajnaInfo::whereIn('land_id', $landIds);
                            
                            $khajnaInfos = $khajnaQuery->get();
                        ?>
                        
                        @if(count($khajnaInfos) > 0)
                            <tr style="border: 1px solid black;">
                                <td>{{ $i++ }}</td>
                                <td>{{$vumiOffice->office_name or ''}}</td>
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                        <table>
                                            @foreach($khajnaInfos as $khajna)
                                                @foreach($lands as $land)
                                                    @if ($khajna->land_id == $land->id)
                                                        <tr style="border-bottom: 1px solid black;">
                                                            <td style="border-right: none;"><span>{{$land->title or ''}}</span></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    @endif
                                </td>
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                        <table>
                                            @foreach($khajnaInfos as $khajna)
                                                @foreach($lands as $land)
                                                    @if ($khajna->land_id == $land->id)
                                                        <tr>
                                                            <td style="border-right: none;">
                                                                @if ($land->zone)
                                                                    {{$land->zone->title or ''}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    @endif
                                </td>
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                        <table>
                                            @foreach($khajnaInfos as $khajna)
                                                @foreach($lands as $land)
                                                    @if ($khajna->land_id == $land->id)
                                                        <tr>
                                                            <td style="border-right: none;">
                                                                @if (isset($land->area))
                                                                    {{$land->area->title or ''}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    @endif
                                </td>
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                        <table>
                                            @foreach($khajnaInfos as $khajna)
                                                @foreach($lands as $land)
                                                    @if ($khajna->land_id == $land->id)
                                                        <tr>
                                                            <td style="border-right: none;">{{$land->dag_no or ''}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    @endif
                                </td>
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                        <table>
                                            @foreach($khajnaInfos as $khajna)
                                                @foreach($lands as $land)
                                                    @if ($khajna->land_id == $land->id)
                                                        <tr>
                                                            <td style="border-right: none;">{{$land->khotian or ''}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    @endif
                                </td>
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                        <table>
                                            @foreach($khajnaInfos as $khajna)
                                                @foreach($lands as $land)
                                                    @if ($khajna->land_id == $land->id)
                                                        <tr>
                                                            <td style="border-right: none;">{{$land->quantity or ''}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    @endif
                                </td>
                                
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                    <table>
                                        @foreach($khajnaInfos as $khajna)
                                            @foreach($lands as $land)
                                                @if ($khajna->land_id == $land->id)
                                                    <tr>
                                                        <td style="border-right: none;">{{ en2bn($khajna->khajna_date) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </table>
                                    @endif
                                </td>
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                    <table>
                                        @foreach($khajnaInfos as $khajna)
                                            @foreach($lands as $land)
                                                @if ($khajna->land_id == $land->id)
                                                    <tr>
                                                        <td style="border-right: none;">{{en2bn($khajna->from_year) }} <?php if($khajna->to_year != 'null'){ echo "to ".en2bn($khajna->to_year); } ?></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <tr>
                                            <td colspan="8" style="border-right: none; border-bottom: none;">পরিশোধিত মোট খাজনার পরিমাণ</td>
                                        </tr>
                                    </table>
                                    @endif
                                </td>
                                <td>
                                    @if(count($khajnaInfos) > 0)
                                    <?php $subTotal = 0; ?>
                                    <table>
                                        @foreach($khajnaInfos as $khajna)
                                            @foreach($lands as $land)
                                                @if ($khajna->land_id == $land->id)
                                                    <tr>
                                                        <td style="border-right: none;">{{ en2bn($khajna->bokeya) }}</td>
                                                        <?php $subTotal += bn2en($khajna->bokeya); ?>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <?php $grandTotal += bn2en($subTotal); ?>
                                        <tr>
                                            <td style="border-right: none; border-bottom: none;"><b>{{en2bn($subTotal)}}</b></td>
                                        </tr>
                                    </table>
                                    @endif
                                </td>
                            </tr>
                        @endif
                @endif
            @endforeach
            <tr>
                <td style="border-left: 1px solid black;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" class="text-right"> <b>মোট খাজনার পরিমাণ: </b></td>
                <td><b>{{ en2bn($grandTotal) }}</b></td>
            </tr>
        @endif
    </tbody>
</table>
@endif