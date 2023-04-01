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
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Source Title']) !!}
            </div>
            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::select('status',['1' => 'Active','0' => 'Inactive'], null, ['class' => 'form-control select2', 'placeholder' => 'By Status', 'style' => 'width: 100%;']) }}
            </div>
            <div class="col-md-4" style="margin-bottom:5px;">
                <a href="{{url('land/source')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>