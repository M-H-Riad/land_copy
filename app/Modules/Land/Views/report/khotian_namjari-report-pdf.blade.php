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
@if($namjari)
<div>
    <h4 style="text-align: center;"><b>খতিয়ান নং- {{$namjari->namjari_khotian_no or ''}}</b></h4>
</div>
<div class="col-md-12" style="margin-bottom: 20px; margin-top: 10px;">
    <table>
        <tr>
            <td class="col-md-2" style="border: none;">বিভাগ : ঢাকা</td>
            <td class="col-md-2" style="border: none;">জেলা : {{$namjari->land->zila->title or ''}}</td>
            <td class="col-md-3" style="border: none;">মৌজা : {{ $namjari->land->area->title or ''}}</td>
            <td class="col-md-2" style="border: none;">জে এল নং : {{ $namjari->namjari_jl_no or ''}}</td>
            <td class="col-md-2" style="border: none;">রে: সা: নং: </td>
        </tr>
    </table>

    </div>
</div>

<table>
    <thead>
        <tr>
            <td>মালিক, অকৃষি প্রজা বা ইজারাদারের নাম ও ঠিকানা</td>
            <td>অংশ</td>
            <td>রাজস্ব</td>
            <td>দাগ নং</td>
            <td>জমি ও শ্রেণী</td>
            <td>দাগের মোট পরিমান</td>
            <td>দাগের মধ্যে অত্র খতিয়ানের অংশ</td>
            <td>অংশ অনুযায়ীই জমির পরিমান</td>
            <td>দখল বিষয়ক বা অন্যান্য বিশেষ মন্তব্য</td>
        </tr>
    </thead>
    <tbody>
        <?php $motJomi = 0; ?>
        @foreach ($namjaries as $namjari)
        <tr>
            <td>{{$namjari->title or ''}}</td>
            <td></td>
            <td></td>
            <td>{{$namjari->namjarir_dag_no or ''}}</td>
            <td>
                @if($namjari->jomir_sreny == 0)
                    কৃষি
                @elseif($namjari->jomir_sreny == 1)
                    অকৃষি ( {{$namjari->jomir_sreny_details or 'Null'}} )
                @else
                    N/A
                @endif
            </td>
            <td>{{$namjari->oi_dage_mot_jomi or ''}}
                @if($namjari->jomir_unit == 1)
                    শতাংশ
                @elseif($namjari->jomir_unit == 2)
                    অযুতাংশ
                @elseif($namjari->jomir_unit == 3)
                    একর 
                @elseif($namjari->jomir_unit == 4)
                    কাঠা
                @elseif($namjari->jomir_unit == 5)
                    বিঘা
                @endif
            </td>
            <td>{{$namjari->dager_moddhe_khotianer_ongsho or ''}}</td>
            <td>{{$namjari->ongsho_onujaie__jomir_poriman or ''}}
                <?php $motJomi += bn2en($namjari->ongsho_onujaie__jomir_poriman); ?>
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
            </td>
            <td>{{$namjari->note or ''}}</td>
        </tr>
        @endforeach
        <tr>
            <td>ধারামতে নোট বা পরিবর্তন,  মোকদ্দমা নং এবং সন</td>
            <td></td>
            <td colspan="5" style="text-align: right;">মোট জমি:</td>
            <td><b>{{en2bn($motJomi)}}
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
            </b>
            </td>
            <td></td>
        </tr>
    </tbody>        
</table>
@endif