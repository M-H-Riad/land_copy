@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">
  @include('errorOrSuccess')
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-red-sunglo">
              <i class="icon-settings font-red-sunglo"></i>
              <span class="caption-subject bold uppercase">নামজারির তথ্যাদি</span>
          </div>
      </div>

      <div class="portlet-body">
      {{Form::open(['url'=>'land/namjari/'.$namjari->id,'method'=>'put','class'=>"form-horizontal",'role'=>'form'])}}
          <div class="form-group col-md-12">
              <label for="title" class="col-md-3 control-label">স্থাপনার নাম <span style="color:red">*</span></label>
              <div class="col-md-5">
              {!! Form::select('land_id', $lands, $namjari->land_id, ['class' => 'form-control select2','placeholder' => 'স্থাপনার নাম', 'id' => 'land_id', 'style' => 'width:100%', 'required']) !!}
              </div>
          </div>

          <div class="form-group col-md-12">
            <label for="zila_id" class="col-md-3 control-label">জেলা <span style="color:red">*</span></label>
            <div class="col-md-5" id="zila_id">
            <input type="text" class="form-control" placeholder="জেলা" disabled>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="thana_id" class="col-md-3 control-label">থানা <span style="color:red">*</span></label>
            <div class="col-md-5" id="thana_id">
            <input type="text" class="form-control" placeholder="থানা" disabled>
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
              <label for="namjari_status" class="col-md-3 control-label">নামজারি স্টেটাস<span style="color:red">*</span></label>
              <div class="col-md-5">
              {!! Form::select('status', ['0' => 'না','1' => 'হ্যা'], $namjari->status, ['class' => 'form-control','placeholder' => 'Select Status', 'id' => 'namjari_status','style' => 'width:100%', 'required']) !!}
              </div>
          </div>
          <div id="namjari_details">
            <div class="form-group col-md-12">
                <label for="jomir_sreny" class="col-md-3 control-label">জমির শ্রেণী<span style="color:red">*</span></label>
                <div class="col-md-5">
                {{ Form::select('jomir_sreny',['0' => 'কৃষি','1' => 'অকৃষি'] , $namjari->jomir_sreny, ['class' => 'form-control', 'id' => 'jomir_sreny','placeholder'=>'জমির শ্রেণী','style' => 'width:100%']) }}
                
                {{ Form::text('jomir_sreny_details',$namjari->jomir_sreny_details, ['class' => 'form-control', 'id' =>'jomir_sreny_details', 'placeholder'=>'অকৃষি জমির বিবরণ','style' => 'width:100%, display:none']) }}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="namjari_date" class="col-md-3 control-label">নামজারি তারিখ</label>
                <div class="col-md-5">
                {{ Form::date('namjari_date', $namjari->namjari_date, ['class' => 'form-control', 'id' => 'namjari_date','placeholder'=>'নামজারি তারিখ','style' => 'width:100%']) }}
                </div>
            </div>
            {{-- <div class="form-group col-md-12">
                <label for="purchase_date" class="col-md-3 control-label">প্রাপ্তির তারিখ</label>
                <div class="col-md-5">
                {{ Form::date('purchase_date', $namjari->purchase_date, ['class' => 'form-control', 'id' => 'purchase_date','placeholder'=>'প্রাপ্তির তারিখ','style' => 'width:100%']) }}
                </div>
            </div> --}}
            <div class="form-group col-md-12">
                <label for="namjari_khotian_no" class="col-md-3 control-label"> খতিয়ান নং <span style="color:red">*</span></label>
                <div class="col-md-5">
                    {{ Form::text('namjari_khotian_no', $namjari->namjari_khotian_no, ['class' => 'form-control', 'placeholder'=>' খতিয়ান নং', 'id' => 'namjari_khotian_no',]) }}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="namjarir_dag_no" class="col-md-3 control-label">দাগ নং<span style="color:red">*</span></label>
                <div class="col-md-5">
                    {{ Form::text('namjarir_dag_no', $namjari->namjarir_dag_no, ['class' => 'form-control', 'placeholder'=>'দাগ নং', 'id' => 'namjarir_dag_no',]) }}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="oi_dage_mot_jomi" class="col-md-3 control-label">ওই দাগে মোট জমির পরিমান</label>
                <div class="col-md-5">
                    {{ Form::text('oi_dage_mot_jomi', $namjari->oi_dage_mot_jomi, ['class' => 'form-control', 'placeholder'=>'ওই দাগে মোট জমির পরিমান', 'id' => 'oi_dage_mot_jomi',]) }}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="jomir_unit" class="col-md-3 control-label">জমির একক<span style="color:red">*</span></label>
                <div class="col-md-5">
                    {!! Form::select('jomir_unit', ['1' => 'শতাংশ', '2' => 'অযুতাংশ', '3' => 'একর', '4' => 'কাঠা', '5' => 'বিঘা'],$namjari->jomir_unit, ['class' => 'form-control','placeholder' => 'জমির একক', 'id' => 'jomir_unit','style' => 'width:100%']) !!}
                </div>
            </div>
            {{-- <div class="form-group col-md-12">
                <label for="dager_moddhe_khotianer_ongsho" class="col-md-3 control-label">দাগের মধ্যে অত্র খতিয়ানের অংশ</label>
                <div class="col-md-5">
                    {!! Form::text('dager_moddhe_khotianer_ongsho',$namjari->dager_moddhe_khotianer_ongsho, ['class' => 'form-control','placeholder' => 'দাগের মধ্যে অত্র খতিয়ানের অংশ', 'id' => 'dager_moddhe_khotianer_ongsho','style' => 'width:100%']) !!}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="ongsho_onujaie__jomir_poriman" class="col-md-3 control-label">অংশ অনুযায়ীই জমির পরিমান <span style="color:red">*</span></label>
                <div class="col-md-5">
                    {{ Form::text('ongsho_onujaie__jomir_poriman', $namjari->ongsho_onujaie__jomir_poriman, ['class' => 'form-control col-md-3', 'placeholder'=>'অংশ অনুযায়ীই জমির পরিমান', 'id' => 'ongsho_onujaie__jomir_poriman',]) }}
                    
                    {!! Form::select('ongsho_onujaie_jomir_akok', ['1' => 'শতাংশ', '2' => 'অযুতাংশ', '3' => 'একর', '4' => 'কাঠা', '5' => 'বিঘা'], $namjari->ongsho_onujaie_jomir_akok, ['class' => 'form-control col-md-2','placeholder' => 'জমির একক', 'id' => 'ongsho_onujaie_jomir_akok','style' => 'width:100%']) !!}
                   
                </div>
            </div> --}}
            <div class="form-group col-md-12">
                <label for="namjari_jot_no" class="col-md-3 control-label">জোত নং</label>
                <div class="col-md-5">
                    {{ Form::text('namjari_jot_no', $namjari->namjari_jot_no, ['class' => 'form-control', 'placeholder'=>'জোত নং', 'id' => 'namjari_jot_no',]) }}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="namjari_jl_no" class="col-md-3 control-label">জে এল নং</label>
                <div class="col-md-5">
                    {{ Form::text('namjari_jl_no', $namjari->namjari_jl_no, ['class' => 'form-control', 'placeholder'=>'জে এল নং','id' => 'namjari_jl_no',]) }}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="note" class="col-md-3 control-label">মন্তব্য</label>
                <div class="col-md-5">
                    {{ Form::textarea('note',  $namjari->note, ['class' => 'form-control height-20 weight-300', 'placeholder'=>'মন্তব্য','id' => 'note',]) }}
                </div>
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
    var sreny = $("#jomir_sreny").val();
    checkJomirSreny(sreny)

    $("#jomir_sreny").on('change', function(){
        var sreny = $("#jomir_sreny").val();
        checkJomirSreny(sreny)
    })

    function checkJomirSreny(sreny){
        if(sreny == 1){
            $("#jomir_sreny_details").removeAttr('style');
        }
        else{
            $("#jomir_sreny_details").attr('style','display:none');
        }
    }
})
$('document').ready(function(){
    var namjariStatus = $("#namjari_status").val();
    checkStatus(namjariStatus)

    $("#namjari_status").on('change', function(){
        var status = $("#namjari_status").val();
        checkStatus(status)
    })

    function checkStatus(status){
        if(status == 1){
            $("#namjari_details").removeAttr('style');
        }
        else{
            $("#namjari_details").attr('style','display:none');
        }
    }
})
    
</script>

<script>
    $('document').ready(function(){
        var land_id = $("#land_id").val();
        getLandInfo(land_id);
    })
    $("#land_id").on('change', function(){
        var land_id = $("#land_id").val();
        getLandInfo(land_id);
    })

    function getLandInfo(lnd_id){
        var land_id = lnd_id;
        var url = "{{ url('land/get-land-info/zone/mowja')}}";
        $.ajax({
            type: "get",
            url: url,
            data: { id: land_id },
            success: function(data) {
                $.each(data.mowza,function(id, name){
                    $('#mowja_id').empty();
                    $("#mowja_id").append('<input class="form-control" type="text" value="'+name+'" disabled>');
                    $("#mowja_id").append('<input type="hidden" name="mowja_id" value="'+id+'">');
                })
                $.each(data.zoneInfo,function(id, title){
                    $('#zone_id').empty();
                    $("#zone_id").append('<input class="form-control" type="text" value="'+title+'" disabled>');
                    $("#zone_id").append('<input type="hidden" name="zone_id" value="'+id+'">');
                })

                $.each(data.zila,function(id, title){
                    $('#zila_id').empty();
                    $("#zila_id").append('<input class="form-control" type="text" value="'+title+'" disabled>');
                })
                $.each(data.thana,function(id, title){
                    $('#thana_id').empty();
                    $("#thana_id").append('<input class="form-control" type="text" value="'+title+'" disabled>');
                })
            }
        })
    }
</script>
@endsection
