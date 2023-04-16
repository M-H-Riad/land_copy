<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-green">
            <span class="caption-subject bold uppercase">Filter</span>
        </div>
    </div>

    <div class="portlet-body" style="padding: 10px">
        {{Form::model($_REQUEST,['method'=>'get','form-horizontal','role'=>'form'])}}
        <div class="col-md-12 side-padding-none">
            <div class="col-md-3" style="margin-bottom:5px;">
                {!! Form::select('land_id', $lands, null, ['class' => 'form-control select2', 'placeholder' => 'স্থাপনার নাম']) !!}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
            {!! Form::select('mowja_id', $moujas, null, ['class' => 'form-control select2','placeholder' => 'মৌজার নাম', 'style' => 'width:100%']) !!}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
            {!! Form::select('khajna_office_id', $khajnaOff, null, ['class' => 'form-control select2','placeholder' => 'ভূমি অফিসের নাম', 'style' => 'width:100%']) !!}
            </div>
        </div>

        <div class="col-md-12 side-padding-none">
            <div class="col-md-6" style="margin-bottom:5px;">
                <a href="{{url('land/khajna-info')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
                <a target="_blank" href="{{route('khajna-info.pdf.download', \Request::all())}}" class="btn btn-warning btn-sm">
                    <i class="fa fa-file-pdf-o"></i> Download PDF
                </a>
                <a target="_blank" href="{{route('khajna-info.export', \Request::all())}}" class=" btn btn-info btn-sm">
                    <i class="fa fa-file-excel-o"></i> Download Excel
                </a>
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>