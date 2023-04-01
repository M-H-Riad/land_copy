<style type="text/css">
    @font-face {
        font-family: serif;
        font-size: small;
        src: url("sol.ttf");format("truetype");
    }

    body {
        font-family: bf;
        font-size: 15px;
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
        padding: 3px;
        /* border: 1px solid #0a0a0a; */
    }

    td {
        padding: 5px;
        /* border: 1px solid #0a0a0a; */
    }
</style>
@if($khajnaInfo)
    <div>
        <h4 style="text-align: center;">ভূমি উন্নয়ন কর পরিশোধ রশিদ</h4>
    </div>
    <table>
        <thead>
        <tr>
            <td colspan="3">সিটি কর্পোরেশন/পৌর/ইউনিয়ন ভূমি অফিসের নাম: ....{{$khajnaInfo->khajna_office->office_name or ''}}</td>
            
        </tr>
        <tr>
            <td class="col-md-5">মৌজার নাম: ...{{$khajnaInfo->mowza->mowja_name or ''}}</td>
            <td class="col-md-2">জে এল নং: ..................................</td>
            <td class="col-md-5">উপজেলার নাম: {{$khajnaInfo->upazila->upazila_name or ''}}</td>
        </tr>
        <tr>
            <td>জেলা: ...................................................................</td>
            <td colspan="2">মালিকের নাম: ............................................................</td>
        </tr>
        <tr>
            <td colspan="3">রেজিস্টার অনুযায়ী হোল্ডিং নাম্বার ও ঠিকানা: .....................................................................................................</td>
        </tr>
        <tr>
            <td>জমির শ্রেণী: ........................................................</td>
            <td colspan="2">খতিয়ান নং: .................................................................</td>
        </tr>
        <tr>
            <td>দাগ নং: .............................................................</td>
            <td colspan="2">জমির পরিমান: ..............................................................</td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
    <table style="border: 1px solid gray;">
        <tr style="border: 1px solid gray;">
            <td rowspan="2" style="border: 1px solid gray;">যে বৎসরের দাবি পরিশোধ করা হইল</td>
            <td colspan="4" style="border: 1px solid gray; text-align:center;">আদায়ের বিবরণ</td>
            <td rowspan="2" style="border: 1px solid gray;">মন্তব্য</td>
        </tr>
        <tr>
            <!-- <td style="border: 1px solid gray;">2020</td> -->
            <td style="border: 1px solid gray;">ভূমি উন্নয়ন কর</td>
            <td style="border: 1px solid gray;">সুদ</td>
            <td style="border: 1px solid gray;">বিবিধ</td>
            <td style="border: 1px solid gray;">মোট</td>
            <!-- <td style="border: 1px solid gray;">মন্তব্য</td> -->
        </tr>
        <tr style="padding: 25px;">
            <td style="border: 1px solid gray; padding: 60px;"></td>
            <td style="border: 1px solid gray;"></td>
            <td style="border: 1px solid gray;"></td>
            <td style="border: 1px solid gray;"></td>
            <td style="border: 1px solid gray;"></td>
            <td style="border: 1px solid gray;"></td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"><b>দ্রষ্টব্য:</b> চেক দ্বারা ভূমি উন্নয়ন কর দেওয়া হইলে তাহার বিবরণ</td>
        </tr>
        <tr>
            <td>সর্বমোট টাকা (কথায়): ..............</td>
            <td style="text-align: right;">আদায়কারীর স্বাক্ষর এবং সীল <br>
            
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right;">পদবী: ............................</td>
        </tr>
        <tr>
            <td>জমা কারীর নাম ও স্বাক্ষর</td>
            <td style="text-align: right;">
            তারিখ: ...........................
            </td>
        </tr>
    </table>
    
    <!-- <table>
        <tr>
            <th>খাজনার তারিখ</th>
            <td>{{$khajnaInfo->khajna_date or ''}}</td>
        </tr>
        <tr>
            <th>দাবির সন (বাংলা)</th>
            <td>{{$khajnaInfo->from_year or ''}} to {{ $khajnaInfo->to_year or ''}}</td>
        </tr>
        <tr>
            
        </tr>
        
        <tr>
            
        </tr>
        <tr>
            <th>বকেয়া</th>
            <td>{{$khajnaInfo->bokeya or ''}}</td>
        </tr>
        <tr>
            <th>হাল</th>
            <td>{{$khajnaInfo->hal or ''}}</td>
        </tr>
        <tr>
            <th>মন্তব্য</th>
            <td>{{$khajnaInfo->note or ''}}</td>
        </tr>
        </thead>
    </table> -->
@endif