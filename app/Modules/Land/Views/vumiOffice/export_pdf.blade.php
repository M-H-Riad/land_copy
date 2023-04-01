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
@if($vumiOffices)
    <table>
        <thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>ভূমি অফিসের নাম</th>
            <th>ভূমি অফিসের ঠিকানা</th>
        </tr>
        </thead>
        <tbody>
        @if(count($vumiOffices) > 0)
            <?php $i = 1; ?>
            @foreach($vumiOffices as $vumiOffice)
                <tr>
                    <td>{{ en2bn($i++) }}</td>
                    <td>{{$vumiOffice->office_name or ''}}</td>
                    <td>{{$vumiOffice->address or ''}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@endif