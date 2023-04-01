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
@if($vumiOffice)
    <table>
        <thead>
        <tr>
            <th>ভূমি অফিসের নাম</th>
            <td>{{$vumiOffice->office_name or ''}}</td>
        </tr>
        <tr>
            <th>ভূমি অফিসের ঠিকানা</th>
            <td>{{$vumiOffice->address or ''}}</td>
        </tr>
        </thead>
    </table>
@endif