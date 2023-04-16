<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-green">
            <span class="caption-subject bold uppercase">Filter</span>
        </div>
    </div>
    <div class="portlet-body" style="padding: 10px">
        {{Form::model($_REQUEST,['method'=>'get','form-horizontal','role'=>'form'])}}
        <div class="col-md-12 side-padding-none">
            
            <div class="col-md-2" style="margin-bottom:5px;">
                {!! Form::select('zone_id', $zones, null, ['class' => 'form-control select2', 'placeholder' => 'জোন', 'style' => 'width: 100%;']) !!}
            </div>
            
            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::select('area_id', $areas, null, ['class' => 'form-control select2', 'placeholder' => 'মৌজা', 'style' => 'width: 100%;']) }}
            </div>

            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::select('source_type', $source_type, null, ['class' => 'form-control select2', 'placeholder' => 'উৎসের ধরণ', 'style' => 'width: 100%;']) }}
            </div>
            


            <div class="col-md-2" style="margin-bottom:5px;">
                {{ Form::text('deep_tubewell_place_name', null, ['class' => 'form-control', 'placeholder' => 'স্থাপনা/গভীর নলকূপের জায়গার নাম']) }}
            </div>
            

        </div>

        <div class="col-md-12 side-padding-none">
            
            
            <div class="col-md-2" style="margin-bottom:5px;">

                {{ Form::select('orderby', ['asc' => 'Ascending', 'desc' =>'Descending'], null, ['class' => 'form-control select2', 'placeholder' => 'Order By', 'style' => 'width: 100%;']) }}
            </div>
            <div class="col-md-5" style="margin-bottom:5px;">
                <a href="{{url('deep-tubewell/deep-tubewell')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
                @if($deepTubewells->count())
                    <a target="_blank" href="" class="btn btn-warning btn-sm">
                        <i class="fa fa-file-pdf-o"></i> Download PDF
                    </a>
                    <a target="_blank" href="" class=" btn btn-info btn-sm">
                        <i class="fa fa-file-excel-o"></i> Download Excel
                    </a>
                @endif
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>