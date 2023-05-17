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
@if($deep_tubewells)
    <table>
        <thead>
        <tr>
            <th>ক্রমিক নং</th>
            @if(!isset($zone))
            <th>জোন</th>
            @endif
            <th>মৌজা</th>
            <th>উৎসের ধরণ</th>
            <th>উৎস</th>
            <th>অনুমতি/চুক্তি/বরাদ্দ</th>
            <th>অনুমতি/চুক্তি/বরাদ্দ তারিখ</th>
            <th>দখলপত্র তারিখ</th>
            <th>স্থাপনা/গভীর নলকূপের জায়গার নাম</th>
            <th>খতিয়ান নং</th>
            <th>দাগ নং</th>
            <th>জমির পরিমান</th>
            <th>মন্তব্য</th>
        </tr>
        </thead>
        <tbody>
        @if(count($deep_tubewells) > 0)
           <?php $i = 1; ?>
            @foreach($deep_tubewells as $deepTubewell)
                <tr>
                    <td>{{ en2bn($i++) }}</td>
                    @if(!isset($zone))
                    <td>মডস {{$deepTubewell->zone->title}}</td>
                    @endif
                    <td>{{$deepTubewell->area->title}}</td>
                    <td>{{$deepTubewell->sourceType->title}}</td>
                    <td>{{$deepTubewell->sources->title}}</td>
                    <td>
                        @if($deepTubewell->onumoti_chukti_boraddo==1)
                            {{ অনুমতি }}
                        @elseif($deepTubewell->onumoti_chukti_boraddo==2)
                            {{ চুক্তি }}
                        @elseif($deepTubewell->onumoti_chukti_boraddo==3)
                            {{ বরাদ্দ }}
                        @endif
                    </td>
                    <td>{{$deepTubewell->onumoti_chukti_boraddo_date}}</td>
                    <td>{{$deepTubewell->dokholpotro_date}}</td>
                    <td>{{$deepTubewell->deep_tubewell_place_name}}</td>
                    <td>{{$deepTubewell->khotiyan_no}}</td>
                    <td>{{$deepTubewell->dag_no}}</td>
                    <td>{{$deepTubewell->jomir_poriman}}</td>
                    <td>{{$deepTubewell->destination}}</td>
                </tr>
            @endforeach
            <tr>
                <td @if(!isset($zone)) colspan="10" @else colspan="9" @endif style="text-align: right;">মোট:</td>
                <td><b></b></td>
                <td><b></b></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="align-center">
        
    </div>
@endif