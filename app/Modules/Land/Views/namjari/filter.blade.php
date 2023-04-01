<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-green">
            <span class="caption-subject bold uppercase">Filter</span>
        </div>
    </div>
    <div class="portlet-body" style="padding: 10px">
        {{Form::model($_REQUEST,['method'=>'get','form-horizontal','role'=>'form'])}}
        <div class="col-md-12 side-padding-none">
            {{--<label for="zone_id" class="col-md-1 control-label text-right">জোন</label>--}}
            <div class="col-md-3" style="margin-bottom:5px;">
                {!! Form::select('land_id', $lands, null, ['class' => 'form-control select2', 'placeholder' => 'স্থাপনার নাম']) !!}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
                {{ Form::select('status',['1' => 'Yes','0' => 'No'], null, ['class' => 'form-control select2', 'placeholder' => 'By Status', 'style' => 'width: 100%;']) }}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
                {{ Form::select('jomir_sreny',['1' => 'অকৃষি','0' => 'কৃষি'], null, ['class' => 'form-control select2', 'placeholder' => 'জমির শ্রেণী', 'style' => 'width: 100%;']) }}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
                {!! Form::text('namjari_khotian_no', null, ['class' => 'form-control', 'placeholder' => 'খতিয়ান নং']) !!}
            </div>
        </div>

        <div class="col-md-12 side-padding-none">
            <div class="col-md-3" style="margin-bottom:5px;">
                {{ Form::text('namjarir_dag_no', null, ['class' => 'form-control', 'placeholder' => 'দাগ নং']) }}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
                {{ Form::text('namjari_jot_no', null, ['class' => 'form-control', 'placeholder' => 'জোত নং']) }}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
                {{ Form::text('namjari_jl_no', null, ['class' => 'form-control', 'placeholder' => 'জে এল নং']) }}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
                {!! Form::select('zone_id', $zones, null, ['class' => 'form-control select2', 'placeholder' => 'জোন', 'style' => 'width: 100%;']) !!}
            </div>
        </div>

        <div class="col-md-12 side-padding-none">            
            <div class="col-md-8" style="margin-bottom:5px;">
                <a href="{{url('land/namjari')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
                <a target="_blank" href="{{route('namjari.pdf.download', \Request::all())}}" class="btn btn-warning btn-sm">
                    <i class="fa fa-file-pdf-o"></i> Download PDF
                </a>
                <a target="_blank" href="{{route('namjari.export', \Request::all())}}" class=" btn btn-info btn-sm">
                    <i class="fa fa-file-excel-o"></i> Download Excel
                </a>
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>