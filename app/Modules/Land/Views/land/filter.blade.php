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
            <div class="col-md-2" style="margin-bottom:5px;">
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'স্থাপনার নাম']) !!}
            </div>
            <div class="col-md-2" style="margin-bottom:5px;">
                {!! Form::text('ownership_details', null, ['class' => 'form-control', 'placeholder' => 'প্রাপ্তি উৎস']) !!}
            </div>
            <div class="col-md-2" style="margin-bottom:5px;">
                {!! Form::select('current_status', landCurrentStatusDropdown(), null, ['class' => 'form-control select2', 'placeholder' => 'বর্তমান অবস্থা', 'style' => 'width: 100%;']) !!}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
                <div class="input-group">
                    <span class="input-group-addon" style="padding: 3px 12px !important;">
                        {!! Form::select('quantity_sign',['=' => '=','>' => '>','<'=>'<','>=' => '>=','<=' => '<='],null) !!}
                    </span>
                    {!! Form::text('quantity', null, ['class' => 'form-control', 'placeholder' => 'জমির পরিমান']) !!}
                </div>
            </div>

            {{--<label for="address" class="col-md-1 control-label text-right">উৎস</label>--}}
            <div class="col-md-3" style="margin-bottom:5px;">
                {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'ঠিকানা']) }}
            </div>
            {{--<label for="source_id" class="col-md-1 control-label text-right">উৎস</label>--}}


        </div>
        <div class="col-md-12 side-padding-none">
            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::text('khotian', null, ['class' => 'form-control', 'placeholder' => 'খতিয়ান / দাগ নং']) }}
            </div>
            {{-- <div class="col-md-2" style="margin-bottom:5px;">
                {!! Form::select('khajna', landKhajnaDropdown(), null, ['class' => 'form-control select2', 'placeholder' => 'ভূমি উন্নয়ন করের বিবরণ', 'style' => 'width: 100%;']) !!}
            </div> --}}
            {{-- <div class="col-md-2" style="margin-bottom:5px;">
                {!! Form::select('namjari', landNamjariDropdown(), null, ['class' => 'form-control select2', 'placeholder' => 'নামজারীর বিবরণ', 'style' => 'width: 100%;']) !!}
            </div> --}}
            <div class="col-md-2" style="margin-bottom:5px;">
                {!! Form::select('zone_id', $zones, null, ['class' => 'form-control select2', 'placeholder' => 'জোন', 'style' => 'width: 100%;']) !!}
            </div>
            {{--<label for="area_id" class="col-md-1 control-label text-right">মৌজা</label>--}}
            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::select('area_id', $areas, null, ['class' => 'form-control select2', 'placeholder' => 'মৌজা', 'style' => 'width: 100%;']) }}
            </div>
            {{--<label for="source_id" class="col-md-1 control-label text-right">উৎস</label>--}}
            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::select('source_id', $sources, null, ['class' => 'form-control select2', 'placeholder' => 'উৎস', 'style' => 'width: 100%;']) }}
            </div>
            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::text('comment', null, ['class' => 'form-control', 'placeholder' => 'মন্তব্য']) }}
            </div>
            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::select('status',['1' => 'Active','0' => 'Inactive'], null, ['class' => 'form-control select2', 'placeholder' => 'By Status', 'style' => 'width: 100%;']) }}
            </div>

        </div>

        <div class="col-md-12 side-padding-none">
            
            
            <div class="col-md-2" style="margin-bottom:5px;">

                {{ Form::select('orderby', ['asc' => 'Ascending', 'desc' =>'Descending'], null, ['class' => 'form-control select2', 'placeholder' => 'Order By', 'style' => 'width: 100%;']) }}
            </div>
            <div class="col-md-5" style="margin-bottom:5px;">
                <a href="{{url('land/land')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
                @if($lands->count())
                    <a target="_blank" href="{{route('land.pdf', \Request::all())}}" class="btn btn-warning btn-sm">
                        <i class="fa fa-file-pdf-o"></i> Download PDF
                    </a>
                    <a target="_blank" href="{{route('land.export', \Request::all())}}" class=" btn btn-info btn-sm">
                        <i class="fa fa-file-excel-o"></i> Download Excel
                    </a>
                @endif
            </div>
        </div>
        {{Form::close()}}
    </div> 
</div>