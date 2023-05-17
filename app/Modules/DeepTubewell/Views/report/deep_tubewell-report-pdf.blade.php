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
@if($deep_infos)
<table>
    <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>স্থাপনা/গভীর নলকূপের জায়গার নাম</th>
            <th>জোন</th>
            <th>মৌজা</th>
            <th>উৎসের ধরণ</th>
            <th>উৎস</th>
            <th>অনুমতি/চুক্তি/বরাদ্দ</th>
            <th>অনুমতি/চুক্তি/বরাদ্দ তারিখ</th>
            <th>দখলপত্র তারিখ</th>
            <th>খতিয়ান নং</th>
            <th>দাগ নং</th>
            <th>জমির পরিমান (একর)</th>
            <th>মন্তব্য</th>
        </tr>
    </thead>
    <tbody>
    @if(count($deep_infos) > 0)
        <?php $total_land = 0;$i=1;?>
        @foreach($deep_infos as $deep_info)
            
                <tr style="border: 1px solid black;">
                    <td>{{ $i++ }}</td>
                    <td>{{$deep_info->deep_tubewell_place_name}}</td>
                    <td>{{$deep_info->zone->title}}</td>
                    <td>{{$deep_info->area->title}}</td>
                    <td>{{$deep_info->sourceType->title}}</td>
                    <td>{{$deep_info->sources->title}}</td>
                    <td>
                        @if($deep_info->onumoti_chukti_boraddo==1)
                            {{ অনুমতি }}
                        @elseif($deep_info->onumoti_chukti_boraddo==2)
                            {{ চুক্তি }}
                        @elseif($deep_info->onumoti_chukti_boraddo==3)
                            {{ বরাদ্দ }}
                        @endif
                    </td>
                    <td>{{$deep_info->onumoti_chukti_boraddo_date}}</td>
                    <td>{{$deep_info->dokholpotro_date}}</td>
                    
                    <td>{{$deep_info->khotiyan_no}}</td>
                    <td>{{$deep_info->dag_no}}</td>
                    <td>{{$deep_info->jomir_poriman}}</td>
                    <td>{{$deep_info->destination}}</td>
                </tr>
            <?php 
                $get_land = $deep_info->jomir_poriman;
                $total_land = $total_land+$get_land;
            ?>
        @endforeach
        <tr>
            
            <td colspan="11" class="text-right"> <b>মোট : </b></td>
            <td colspan="2" class="text-left"> <b>{{$total_land}} একর</b></td>
            
        </tr>
    @endif
    </tbody>
</table>

@endif

