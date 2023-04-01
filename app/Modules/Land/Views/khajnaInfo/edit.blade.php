@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">
  @include('errorOrSuccess')
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-red-sunglo">
              <i class="icon-settings font-red-sunglo"></i>
              <span class="caption-subject bold uppercase">ভূমি উন্নয়ন কর (খাজনা বিবরণী)</span>
          </div>
      </div>

      <div class="portlet-body">
            <table class="table table-bordered table-hover striped" style="width: 30%; float:right; color:red;">
              <tr style="border: 2px solid red;">
                  <th>মোট বকেয়ার পরিমাণ: </th>
                  <th id="total_bokeya"> </th>
              </tr>
            </table>

      {{Form::open(['url'=>'land/khajna-info/'.$khajnaInfo->id,'method'=>'put','class'=>"form-horizontal",'role'=>'form', 'enctype' => 'multipart/form-data'])}}
          <div class="form-group col-md-12">
              <label for="title" class="col-md-3 control-label">স্থাপনার নাম <span style="color:red">*</span></label>
              <div class="col-md-5">
              {!! Form::select('land_id', $lands, $khajnaInfo->land_id, ['class' => 'form-control select2', 'id' => 'land_id','placeholder' => 'স্থাপনার নাম', 'style' => 'width:100%', 'required']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="khajna_office_id" class="col-md-3 control-label">ভূমি অফিসের নাম <span style="color:red">*</span></label>
              <div class="col-md-5" id="khajna_office_id">
              <input type="text" class="form-control" placeholder="ভূমি অফিসের নাম" disabled>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="mowja_id" class="col-md-3 control-label">মৌজার নাম <span style="color:red">*</span></label>
              <div class="col-md-5" id="mowja_id">
              <input type="text" class="form-control" placeholder="মৌজার নাম" disabled>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="zone_id" class="col-md-3 control-label">জোনের নাম <span style="color:red">*</span></label>
              <div class="col-md-5" id="zone_id">
              <input type="text" class="form-control" placeholder="জোনের নাম" disabled>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="dag_no" class="col-md-3 control-label">দাগ নং <span style="color:red">*</span></label>
              <div class="col-md-5" id="dag_no">
              <input type="text" class="form-control" placeholder="দাগ নং" disabled>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="khotian" class="col-md-3 control-label">খতিয়ান নং <span style="color:red">*</span></label>
              <div class="col-md-5" id="khotian">
              <input type="text" class="form-control" placeholder="খতিয়ান নং" disabled>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="quantity" class="col-md-3 control-label">জমির পরিমান <span style="color:red">*</span></label>
              <div class="col-md-5" id="quantity">
              <input type="text" class="form-control" placeholder="জমির পরিমান" disabled>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="source_id" class="col-md-3 control-label">প্রাপ্ত জমির উৎস <span style="color:red">*</span></label>
              <div class="col-md-5" id="source_id">
              <input type="text" class="form-control" placeholder="প্রাপ্ত জমির উৎস" disabled>
              </div>
          </div>
          <div class="form-group col-md-12">
            <label for="from_year" class="col-md-3 control-label">খাজনা দাবির সন (বাংলা) <span style="color:red">*</span></label>
              <div class="col-md-5">
                  <!-- <div class="form-group col-md-3"> -->
                      <select class="form-control col-md-2" name="from_year">
                      <option value="null">সন নির্বাচন করুন (হইতে)</option>
                          @for($i=1448; $i >= 1350; $i--)
                          <option value="{{ $i }}" @if($khajnaInfo->from_year == $i)  selected @endif> {{ en2bn($i) }} </option>
                          @endfor
                      </select>              
                  <!-- </div> -->
                  <!-- <div class="col-md-2" style="margin-left: 35px;"> <span>To</span></div> -->
                  <span style="margin-left: 175px;">হইতে</span>
                 
                  <!-- <div class="form-group col-md-3" style="margin-left: -41px;"> -->
                      <select class="form-control col-md-2" name="to_year">
                      <option value="null">সন নির্বাচন করুন (পর্যন্ত)</option>
                          @for($i=1448; $i >= 1350; $i--)
                          <option value="{{ $i }}" @if($khajnaInfo->to_year == $i)  selected @endif> {{ en2bn($i) }} </option>
                          @endfor
                      </select>
                  <!-- </div> -->
              </div>
        </div>
        <div class="form-group col-md-12">
            <label for="amount" class="col-md-3 control-label">খাজনার পরিমাণ</label>
            <div class="col-md-5">
               {{ Form::text('amount', $khajnaInfo->bokeya, ['class' => 'form-control', 'placeholder'=>'খাজনার পরিমাণ বাংলায় লিখুন','id' => 'note',]) }}
            </div>
         </div>
         <div class="form-group col-md-12">
            <label for="proisoditho_khajna" class="col-md-3 control-label">পরিশোধিত খাজনার সন (বাংলা)<span style="color:red">*</span></label>
            <div class="col-md-5" id="proisoditho_khajna">
            {!! Form::text('proisoditho_khajna', null, ['class' => 'form-control', 'style' => 'width:100%', 'readonly']) !!}
            </div>
        </div>

        <div class="form-group col-md-12">
            <label for="khajna_date" class="col-md-3 control-label">খাজনা পরিশোধের তারিখ<span style="color:red">*</span></label>
            <div class="col-md-5">
            {!! Form::date('khajna_date', $khajnaInfo->khajna_date, ['class' => 'form-control','placeholder' => 'খাজনার তারিখ', 'style' => 'width:100%', 'required']) !!}
            </div>
        </div>
          
          <div class="form-group col-md-12">
             <label for="note" class="col-md-3 control-label">মন্তব্য</label>
             <div class="col-md-5">
                {{ Form::textarea('note', $khajnaInfo->note, ['class' => 'form-control height-20 weight-300', 'placeholder'=>'মন্তব্য','id' => 'note',]) }}
             </div>
          </div>
          <div class="form-group col-md-12">
             <label for="note" class="col-md-3 control-label">Attachment(চেক)</label>
             <div class="col-md-5">
                <input class="form-control" type="file" name="document">
                <span style="color:red">Max File Size 5MB</span>
                <span class="col-md-5"><img class="card-img-top" src="{{ asset($khajnaInfo->document) }}" alt="Image" /></span>
             </div>
          </div>
          <div class="form-group col-md-12">
             <label for="note" class="col-md-3 control-label">Attachment(দাখিল)</label>
             <div class="col-md-5">
                <input class="form-control" type="file" name="dakhila">
                <span style="color:red">Max File Size 5MB</span>
                <span class="col-md-5"><img class="card-img-top" src="{{ asset($khajnaInfo->dakhila) }}" alt="Image" /></span>
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

<script>
$('document').ready(function(){
    var land_id = $("#land_id").val();
    getKhajnaOfficeInfo(land_id);
    getPorishoditoKhajnaInfo(land_id);
})
$("#land_id").on('change', function(){
    var land_id = $("#land_id").val();
    getKhajnaOfficeInfo(land_id);
    getPorishoditoKhajnaInfo(land_id);
})

function getKhajnaOfficeInfo(lnd_id){
    var land_id = lnd_id;
    var url = "{{ url('land/get-khajna-office-info')}}";
    $.ajax({
        type: "get",
        url: url,
        data: { id: land_id },
        success: function(data) {
            $.each(data.upazila,function(id, name){
                $('#upazila_id').empty();
                $("#upazila_id").append('<input class="form-control" type="text" value="'+name+'" disabled>');
                $("#upazila_id").append('<input type="hidden" name="upazila_id" value="'+id+'">');
            })
            $.each(data.mowza,function(id, name){
                $('#mowja_id').empty();
                $("#mowja_id").append('<input class="form-control" type="text" value="'+name+'" disabled>');
                $("#mowja_id").append('<input type="hidden" name="mowja_id" value="'+id+'">');
            })
            $.each(data.khajnaOffice,function(id, name){
                $('#khajna_office_id').empty();
                $("#khajna_office_id").append('<input class="form-control" type="text" value="'+name+'" disabled>');
                $("#khajna_office_id").append('<input type="hidden" name="khajna_office_id" value="'+id+'">');
            })
            $.each(data.zoneInfo,function(id, title){
                $('#zone_id').empty();
                $("#zone_id").append('<input class="form-control" type="text" value="'+title+'" disabled>');
                $("#zone_id").append('<input type="hidden" name="zone_id" value="'+id+'">');
            })
            $.each(data.landInfo,function(id, title){
                $('#dag_no').empty();
                $("#dag_no").append('<input class="form-control" type="text" value="'+data.landInfo.dag_no+'" disabled>');
                $("#dag_no").append('<input type="hidden" name="dag_no" value="'+id+'">');
            })
            $.each(data.landInfo,function(id, title){
                $('#khotian').empty();
                $("#khotian").append('<input class="form-control" type="text" value="'+data.landInfo.khotian+'" disabled>');
                $("#khotian").append('<input type="hidden" name="khotian" value="'+id+'">');
            })
            $.each(data.landInfo,function(id, title){
                $('#quantity').empty();
                $("#quantity").append('<input class="form-control" type="text" value="'+data.landInfo.quantity+'" disabled>');
                $("#quantity").append('<input type="hidden" name="quantity" value="'+id+'">');
            })
            $.each(data.landSource,function(id, title){
                $('#source_id').empty();
                $("#source_id").append('<input class="form-control" type="text" value="'+title+'" disabled>');
                $("#source_id").append('<input type="hidden" name="source_id" value="'+id+'">');
            })
            $('#total_bokeya').empty();
            $("#total_bokeya").append(data.bokeya);
        }
    })
}

function getPorishoditoKhajnaInfo(lnd_id){
    var land_id = lnd_id;
    var url = "{{ url('land/get-oorishodito-khajna-info')}}";
    $.ajax({
        type: "get",
        url: url,
        data: { id: land_id },
        success: function(data) {
            $.each(data.paidYear,function(index, value){
                $("#proisoditho_khajna").empty();
                $("#proisoditho_khajna").append('<input class="form-control" type="text" value="'+value+'" disabled>');
            })
        }
    })
}

</script>
@endsection
