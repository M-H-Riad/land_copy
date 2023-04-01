@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">
  @include('errorOrSuccess')
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-red-sunglo">
              <i class="icon-settings font-red-sunglo"></i>
              <span class="caption-subject bold uppercase">ভূমি অফিসের তথ্য</span>
          </div>
      </div>

      <div class="portlet-body">
        {{Form::open(['url'=>'land/vumi_office','method'=>'post','class'=>"form-horizontal",'role'=>'form','file'=>true])}}
          <div class="form-group col-md-12">
              <label for="office_name" class="col-md-3 control-label">ভূমি অফিসের নাম <span style="color:red">*</span></label>
              <div class="col-md-5">
              {!! Form::text('office_name', null, ['class' => 'form-control','placeholder' => 'ভূমি অফিসের নাম', 'style' => 'width:100%', 'required']) !!}
              </div>
          </div>
          
          <div class="form-group col-md-12">
              <label for="address" class="col-md-3 control-label">ভূমি অফিসের ঠিকানা</label>
              <div class="col-md-5">
              {!! Form::text('address', null, ['class' => 'form-control','placeholder' => 'ভূমি অফিসের ঠিকানা', 'style' => 'width:100%', 'required']) !!}
              </div>
          </div>
          
          <hr>
          <div class="form-group">
              <div class="col-md-11 text-center" style="padding-bottom: 20px; margin-top: 10px;">
                  <button type="submit" class="btn blue">Submit</button>
              </div>
          </div>
          {{Form::close()}}
          <div id="map_canvas" class="col-md-12" style="height: 450px; margin: 0.6em;"></div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

@endsection
