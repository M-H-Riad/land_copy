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
            {!! Form::text('office_name', null, ['class' => 'form-control','placeholder' => 'ভূমি অফিসের নাম', 'style' => 'width:100%']) !!}
            </div>
            <div class="col-md-3" style="margin-bottom:5px;">
            {!! Form::text('address', null, ['class' => 'form-control','placeholder' => 'ভূমি অফিসের ঠিকানা', 'style' => 'width:100%']) !!}
            </div>

            <div class="col-md-6" style="margin-bottom:5px;">
                <a href="{{url('land/vumi_office')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
                <a target="_blank" href="{{route('vumi_office.pdf.download', \Request::all())}}" class="btn btn-warning btn-sm">
                    <i class="fa fa-file-pdf-o"></i> Download PDF
                </a>
                <!-- <a target="_blank" href="{{route('vumi_office.export', \Request::all())}}" class=" btn btn-info btn-sm">
                    <i class="fa fa-file-excel-o"></i> Download Excel
                </a> -->
            </div>
        </div>

        <div class="col-md-12 side-padding-none">
            <!-- <div class="col-md-6" style="margin-bottom:5px;">
                <a href="{{url('land/vumi_office')}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
                <a target="_blank" href="{{route('vumi_office.pdf.download', \Request::all())}}" class="btn btn-warning btn-sm">
                    <i class="fa fa-file-pdf-o"></i> Download PDF
                </a>
                <a target="_blank" href="{{route('vumi_office.export', \Request::all())}}" class=" btn btn-info btn-sm">
                    <i class="fa fa-file-excel-o"></i> Download Excel
                </a>
            </div> -->
        </div>
        {{Form::close()}}
    </div>
</div>