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
@if($land)
    <table>
        <thead>
        <tr>
            <th>স্থাপনার নাম</th>
            <td>{{$land->title or ''}}</td>
        </tr>
        <tr>
            <th>জেলা</th>
            <td>{{$land->zila->title or ''}}</td>
        </tr>
        <tr>
            <th>থানা</th>
            <td>{{$land->thana->title or ''}}</td>
        </tr>
        <tr>
            <th>জোন</th>
            <td>মডস {{$land->zone->title or ''}}</td>
        </tr>
        <tr>
            <th>মৌজা</th>
            <td>{{$land->area->title or ''}}</td>
        </tr>
        <tr>
            <th>প্রাপ্তি উৎস</th>
            <td>{{$land->source->title or ''}}</td>
        </tr>
        <tr>
            <th>ঠিকানা</th>
            <td>{{$land->address or ''}}</td>
        </tr>
        <tr>
            <th> দাগ নং</th>
            <td>{{$land->dag_no or ''}}</td>
        </tr>
        <tr>
            <th>খতিয়ান নং</th>
            <td>{{$land->khotian or ''}}</td>
        </tr>
        <tr>
            <th>জমির পরিমান</th>
            <td>{{$land->quantity or ''}}</td>
        </tr>
        <tr>
            <th>খাজনা প্রদানকৃত জমির পরিমান</th>
            <td>{{$land->khajna_land or ''}}</td>
        </tr>
        <!-- <tr>
            <th>প্রাপ্তি উৎস</th>
            <td>{{$land->ownership_details or ''}}</td>
        </tr> -->
        <tr>
            <th>বর্তমান অবস্থা</th>
            <td>{{$land->current_status or ''}}</td>
        </tr>
        {{-- <tr>
            <th>ভূমি উন্নয়ন করের বিবরণ</th>
            <td>{{$land->khajna or ''}}</td>

        </tr>
        <tr>
            <th>নামজারীর বিবরণ</th>
            <td>{{$land->namjari or ''}}</td>
        </tr> --}}
        <tr>
            <th>মন্তব্য</th>
            <td>{{$land->comment or ''}}</td>

        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($land->status == 0)
                    Inactive
                @elseif($land->status == 1)
                    Active
                @else
                    N/A
                @endif
            </td>
        </tr>
        </thead>
    </table>
@endif