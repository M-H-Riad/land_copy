<!DOCTYPE html>
<html>
<head>
    <title>Be right back.</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 40px;
            margin-bottom: 40px;
            color: red;
            font-weight : 600;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        {{-- <div class="title">403 Forbidden HTTP 403.</div> --}}
        <div class="title">You don't have permission to do this action. Please Contact with authority. </div>
        <hr>
        <div class="title">আপনার এই কার্যক্রমটি করার অনুমতি নেই।  কর্তৃপক্ষের সাথে যোগাযোগ করুন। </div>
    </div>
    <center>
        <button class="btn btn-success btn-lg" onclick="window.history.back()">Go Back</button>
    </center>
</div>
</body>
</html>
