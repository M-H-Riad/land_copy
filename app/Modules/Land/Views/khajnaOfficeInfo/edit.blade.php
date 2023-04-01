@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">
  @include('errorOrSuccess')
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-red-sunglo">
              <i class="icon-settings font-red-sunglo"></i>
              <span class="caption-subject bold uppercase">স্থাপনা অনুযায়ী ভূমি অফিস</span>
          </div>
      </div>

      <div class="portlet-body">
      {{Form::open(['url'=>'land/khajna-office/'.$khajnaOfficeInfo->id,'method'=>'put','class'=>"form-horizontal",'role'=>'form'])}}
          <div class="form-group col-md-12">
              <label for="title" class="col-md-3 control-label">স্থাপনার নাম <span style="color:red">*</span></label>
              <div class="col-md-5">
              {!! Form::select('land_id', $lands, $khajnaOfficeInfo->land_id, ['class' => 'form-control select2','placeholder' => 'স্থাপনার নাম', 'style' => 'width:100%', 'required']) !!}
              </div>
          </div>

          <div class="form-group col-md-12">
              <label for="khajna_office_id" class="col-md-3 control-label">ভূমি অফিসের নাম <span style="color:red">*</span></label>
              <div class="col-md-5">
              {!! Form::select('khajna_office_id', $khajnaOffices, $khajnaOfficeInfo->khajna_office_id, ['class' => 'form-control select2','placeholder' => 'ভূমি অফিসের নাম', 'style' => 'width:100%', 'required']) !!}
              </div>
          </div>

          <div class="form-group col-md-12">
              <label for="open_year" class="col-md-3 control-label">ওপেনিং কর দাবির সন <span style="color:red">*</span></label>
              <div class="col-md-5">
              <!-- {!! Form::text('open_year', $khajnaOfficeInfo->open_year, ['class' => 'form-control','placeholder' => 'ওপেনিং কর দাবির সন', 'style' => 'width:100%', 'required']) !!} -->
              <select class="form-control col-md-5" name="open_year">
                    <option value="null">সন নির্বাচন করুন (বাংলা )</option>
                    @for($i=1448; $i >= 1350; $i--)
                    <option value="{{ $i }}" @if($i == $khajnaOfficeInfo->open_year) selected @endif> {{ en2bn($i) }} </option>
                    @endfor
                </select>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="total_bokeya" class="col-md-3 control-label">বকেয়ার পরিমাণ  (বাংলা)<span style="color:red">*</span></label>
              <div class="col-md-5">
              {!! Form::text('total_bokeya', $khajnaOfficeInfo->total_bokeya, ['class' => 'form-control','placeholder' => 'বকেয়ার পরিমাণ বাংলায় লিখুন', 'style' => 'width:100%', 'required']) !!}
              </div>
          </div>

          <div class="form-group col-md-12">
              <label for="from_year" class="col-md-3 control-label">বকেয়া কর দাবির সন (বাংলা) <span style="color:red">*</span></label>
                <div class="col-md-5">
                    <!-- <div class="col-md-2" style="width: 40%;"> -->
                        <select class="form-control col-md-2" name="from_year">
                            <option value="null">সন নির্বাচন করুন (হইতে)</option>
                            @for($i=1448; $i >= 1350; $i--)
                            <option value="{{ $i }}" @if($i == $khajnaOfficeInfo->from_year) selected @endif> {{ en2bn($i) }} </option>
                            @endfor
                        </select>
                    <!-- </div> -->
                    <span style="margin-left: 175px;">হইতে</span>
                   
                    <!-- <div class="col-md-2" style="width: 40%;"> -->
                        <select class="form-control col-md-2" name="to_year">
                        <option value="null">সন নির্বাচন করুন (পর্যন্ত)</option>
                            @for($i=1448; $i >= 1350; $i--)
                            <option value="{{ $i }}" @if($i == $khajnaOfficeInfo->to_year) selected @endif> {{ en2bn($i) }} </option>
                            @endfor
                        </select>              
                    <!-- </div> -->
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

<!-- @section('scripts')
<script>
$("#upazila_id").on('change', function(){
    var upazila_id = $("#upazila_id").val();
    getMowjaInfo(upazila_id);
})

$("#mowja_id").on('change', function(){
    var mowja_id = $("#mowja_id").val();
    getKhajnaOffice(mowja_id);
})

function getMowjaInfo(up_id){
    var upazila_id = up_id;
    var url = "{{ url('land/up-mowja/')}}";
    $.ajax({
        type: "get",
        url: url,
        data: { id: upazila_id },
        success: function(data) {
            $('#mowja_id').empty();
            $('#mowja_id').append('<option>মৌজার নাম</option>');
            $.each(data.mowjas,function(index, mowja){
               $('#mowja_id').append('<option value="'+index+'">'+mowja+'</option>');
            })
        }
    })
}

function getKhajnaOffice(mowja_id){
    var mowja_id = mowja_id;
    var url = "{{ url('land/mowja-khajnaoffice/')}}";
    $.ajax({
        type: "get",
        url: url,
        data: { mowja_id : mowja_id },
        success: function(data) {
            $('#khajna_office_id').empty();
            $('#khajna_office_id').append('<option>ভূমি অফিসের নাম</option>');
            $.each(data.khajnaoffices,function(index, office){
                console.log(office);
               $('#khajna_office_id').append('<option value="'+index+'">'+office+'</option>');
            })
        }
    })
}
</script>
@endsection -->
