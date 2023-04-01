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
@if($namjaries)
    <table>
        <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>স্থাপনার নাম</th>
            <th>জোন</th>
            <th>মৌজা</th>
            <th>নামজারি স্টেটাস</th>
            <th>জমির শ্রেণী</th>
            <th>নামজারি তারিখ</th>
            {{-- <th>প্রাপ্তির তারিখ</th> --}}
            <th>খতিয়ান নং</th>
            <th>দাগ নং</th>
            <th>ওই দাগে মোট জমির পরিমান (একর)</th>
            {{-- <th>দাগের মধ্যে অত্র খতিয়ানের অংশ</th> --}}
            {{-- <th>অংশ অনুযায়ীই জমির পরিমান</th> --}}
            <th>জোত নং</th>
            <th>জে এল নং</th>
            <th>মন্তব্য</th>
        </tr>
        </thead>
        <tbody>
        @if(count($namjaries) > 0)
            <?php $i = 1; $totalLand = 0; ?>
            @foreach($namjaries as $namjari)
                <tr>
                    <td>{{ en2bn($i++) }}</td>
                    <td>{{$namjari->land->title or ''}}</td>
                    <td>
                        @if (isset($namjari->zone_id))
                            মডস {{$namjari->zone->title or ''}}
                        @endif
                    </td>
                    <td>{{$namjari->land->area->title or ''}}</td>
                    <td>
                        @if($namjari->status == 0)
                            <span style="color:orange;">না</span>
                        @else
                            <span style="color:green;">হ্যা</span>
                        @endif
                    </td>
                    <td>
                        @if($namjari->jomir_sreny == 0)
                            কৃষি
                        @elseif($namjari->jomir_sreny == 1)
                            অকৃষি 
                            @if (isset($namjari->jomir_sreny_details))
                                ( {{$namjari->jomir_sreny_details or '-'}} )
                            @endif
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ en2bn($namjari->namjari_date) }}</td>
                    {{-- <td>{{ en2bn($namjari->purchase_date) }}</td> --}}
                    <td>{{$namjari->namjari_khotian_no or ''}}</td>
                    <td>{{$namjari->namjarir_dag_no or ''}}</td>
                    <td>{{$namjari->oi_dage_mot_jomi or ''}}
                        {{-- @if($namjari->jomir_unit == 1)
                            শতাংশ
                        @elseif($namjari->jomir_unit == 2)
                            অযুতাংশ
                        @elseif($namjari->jomir_unit == 3)
                            একর 
                        @elseif($namjari->jomir_unit == 4)
                            কাঠা
                        @elseif($namjari->jomir_unit == 5)
                            বিঘা
                        @endif --}}
                        <?php $totalLand += bn2en($namjari->oi_dage_mot_jomi); ?>
                    </td>
                    {{-- <td>{{$namjari->dager_moddhe_khotianer_ongsho or ''}}</td> --}}
                    {{-- <td>{{$namjari->ongsho_onujaie__jomir_poriman or ''}}
                        @if($namjari->ongsho_onujaie_jomir_akok == 1)
                            শতাংশ
                        @elseif($namjari->ongsho_onujaie_jomir_akok == 2)
                            অযুতাংশ
                        @elseif($namjari->ongsho_onujaie_jomir_akok == 3)
                            একর 
                        @elseif($namjari->ongsho_onujaie_jomir_akok == 4)
                            কাঠা
                        @elseif($namjari->ongsho_onujaie_jomir_akok == 5)
                            বিঘা
                        @endif
                    </td>  --}}
                    <td>{{$namjari->namjari_jot_no or ''}}</td>
                    <td>{{$namjari->namjari_jl_no or ''}}</td>
                    <td>{{$namjari->note or ''}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="9" style="text-align: right;"><b>মোট:</b></td>
                <td><b>{{ en2bn($totalLand) }} (একর)</b></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        </tbody>
    </table>
@endif