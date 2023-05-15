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
@if($deepTubewell)
    <table>
        <thead>
        <tr>
            <th>জোন</th>
            <td>মডস {{$deepTubewell->zone->title}}</td>
        </tr>
        <tr>
            <th>মৌজা</th>
            <td>{{$deepTubewell->area->title}}</td>
        </tr>
        <tr>
            <th>উৎসের ধরণ</th>
            <td>{{$deepTubewell->sourceType->title}}</td>
        </tr>
        <tr>
            <th>উৎস</th>
            <td>{{$deepTubewell->sources->title}}</td>
        </tr>
        <tr>
            <th>অনুমতি/চুক্তি/বরাদ্দ</th>
            <td>@if($deepTubewell->onumoti_chukti_boraddo==1)
                    {{ অনুমতি }}
                @elseif($deepTubewell->onumoti_chukti_boraddo==2)
                    {{ চুক্তি }}
                @elseif($deepTubewell->onumoti_chukti_boraddo==3)
                    {{ বরাদ্দ }}
                @endif
            </td>
        </tr>
        <tr>
            <th>অনুমতি/চুক্তি/বরাদ্দ তারিখ</th>
            <td>{{$deepTubewell->onumoti_chukti_boraddo_date}}</td>
        </tr>
        <tr>
            <th>দখলপত্র তারিখ</th>
            <td>{{$deepTubewell->dokholpotro_date}}</td>
        </tr>
        <tr>
            <th>স্থাপনা/গভীর নলকূপের জায়গার নাম</th>
            <td>{{$deepTubewell->deep_tubewell_place_name}}</td>
        </tr>
        <tr>
            <th>খতিয়ান নং</th>
            <td>{{$deepTubewell->khotiyan_no}}</td>
        </tr>
        <tr>
            <th>দাগ নং</th>
            <td>{{$deepTubewell->dag_no}}</td>
        </tr>
        <tr>
            <th> জমির পরিমান</th>
            <td>{{$deepTubewell->jomir_poriman}}</td>
        </tr>
        
        <tr>
            <th>মন্তব্য</th>
            <td>{{$deepTubewell->destination}}</td>
        </tr>
        
        </thead>
    </table>
@endif