<div style="width: 100% ;text-align: center">
    <br>   <br>   <br>   <br>   <br>
    {!! Form::open(['url' => 'data-migration/wasa-old-salary-update', 'method' => 'post', 'files'=>True]) !!}
    {{ Form::selectMonth('month',null, ['class' => 'form-control','placeholder'=>'Select Month','required' ]) }}
    {{ Form::selectYear('year',2019,2010,null, ['class' => 'form-control','placeholder'=>'Select Year','required']) }}
    <br>   <br>

    {{ Form::select('data_from',['db'=>'from db','file'=>'from file'],null, ['class' => 'form-control','required' ,'id'=>'data_from']) }}
    <div class="db">
        <br>
        {{ Form::select('table_name',['loan_14_15'=>'loan_14_15','loan_16_17'=>'loan_16_17','loan_18_19'=>'loan_18_19'],null, ['class' => 'form-control','id'=>'db','placeholder'=>'Select DB table','required' ]) }}
    </div>
    <div class="file" style="display: none">
        <br>
        File (xls,xlsx) <input type="file" id="file" name="xlsfile" class="form-control" accept=".xls,.xlsx,.csv">
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Upload</button>

    {!! Form::close()  !!}
</div>
<script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}"  type="text/javascript"></script>
<script>
    $(function() {
        $('.file').hide();
        $(".file").removeAttr('required',true);
        $('#data_from').change(function(){

            if($('#data_from').val() === 'db') {
                $('.db').show();
                $('.file').hide();
                $(".db").attr('required',true);
                $(".file").removeAttr('required',true);
            } else {
                $('.file').show();
                $('.db').hide();
                $(".file").attr('required',true);
                $(".db").removeAttr('required',true);
            }
        });
    });
</script>