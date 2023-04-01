@extends('main_layouts.app')


@section('content')

<div class="row animated zoomIn">
  @include('errorOrSuccess')
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-red-sunglo">
              <i class="icon-settings font-red-sunglo"></i>
              <span class="caption-subject bold uppercase">ভূমির তথ্যাদি</span>
          </div>
      </div>

      <div class="portlet-body">
        {{Form::open(['url'=>'land/land','method'=>'post','class'=>"form-horizontal",'role'=>'form', 'enctype' => 'multipart/form-data'])}}
          <div class="form-group col-md-12">
              <label for="title" class="col-md-3 control-label">স্থাপনার নাম <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('title', null, ['class' => 'form-control' , 'id' => 'title','required'=>'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="zila_id" class="col-md-3 control-label">জেলা<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('zila_id', $zilas, null, ['class' => 'form-control select2','placeholder' => 'Select Zila', 'style' => 'width:100%']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="thana_id" class="col-md-3 control-label">থানা<span style="color:red">*</span></label>
              <div class="col-md-5">
                <select name="thana_id" id="thana_id" class="form-control select2">
                    <option value="">Select Thana</option>
                </select>
              </div>
          </div>

          <div class="form-group col-md-12">
              <label for="zone_id" class="col-md-3 control-label">জোন<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('zone_id', $zones, null, ['class' => 'form-control select2','placeholder' => 'Select Land Zone', 'style' => 'width:100%']) !!}
              </div>
          </div>
          <!-- <div class="form-group col-md-12">
              <label for="zone_id" class="col-md-3 control-label">জোন<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::text('zone_id', null, ['class' => 'form-control', 'id' => 'zone_id','style' => 'width:100%']) !!}
                {!! Form::hidden('zones', $zones, null, ['class' => 'form-control','id' => 'zones']) !!}
              </div>
          </div> -->

          <!-- <div class="form-group col-md-12">
            <label for="tags" class="col-md-3 control-label">Tags: </label>
            <div class="col-md-5">
            <input name="tags" id="tags" class="form-control">
            </div>
          </div> -->

          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">মৌজা<span style="color:red">*</span></label>
              <div class="col-md-5">
                <select name="area_id" id="area_id" class="form-control select2" style="width: 100%;">
                  <option value="">Select Land Area</option>
                  @foreach ($areas as $key => $item)
                      <option value="{{ $key }}">{{ $item }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                  <button data-toggle="modal" data-target="#add-land_area-modal" type="button" class="btn btn-success bnt-lg"><i class="fa fa-plus"></i> Add New</button>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="source_id" class="col-md-3 control-label">প্রাপ্তি উৎস<span style="color:red">*</span></label>
              <div class="col-md-5">
                <select name="land_source_id" id="land_source_id" class="form-control select2" style="width: 100%;">
                  <option value="">Select Land Source type</option>
                  @foreach ($sources as $key => $item)
                      <option value="{{ $key }}">{{ $item }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
              <button data-toggle="modal" data-target="#add-land_source-modal" type="button" class="btn btn-success bnt-lg"><i class="fa fa-plus"></i> Add New</button>
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="address" class="col-md-3 control-label">ঠিকানা <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('address', null, ['class' => 'form-control', 'id' => 'searchTextField', 'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="dag_no" class="col-md-3 control-label">দাগ নং <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('dag_no', null, ['class' => 'form-control', 'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="khotian" class="col-md-3 control-label">খতিয়ান নং <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('khotian', null, ['class' => 'form-control', 'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="quantity" class="col-md-3 control-label">জমির পরিমান</label>
              <div class="col-md-5">
                  {{ Form::text('quantity', null, ['class' => 'form-control']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="khajna_land" class="col-md-3 control-label">খাজনা প্রদানকৃত জমির পরিমান</label>
              <div class="col-md-5">
                  {{ Form::text('khajna_land', null, ['class' => 'form-control']) }}
              </div>
          </div>
          <!-- <div class="form-group col-md-12">
              <label for="ownership_details" class="col-md-3 control-label">প্রাপ্তি উৎস <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('ownership_details', null, ['class' => 'form-control', 'required']) }}
              </div>
          </div> -->
          <div class="form-group col-md-12">
              <label for="current_status" class="col-md-3 control-label">বর্তমান অবস্থা <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('current_status', null, ['class' => 'form-control', 'required']) }}
              </div>
          </div>
          {{-- <div class="form-group col-md-12">
              <label for="khajna" class="col-md-3 control-label">ভূমি উন্নয়ন করের বিবরণ <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('khajna', null, ['class' => 'form-control', 'required']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="namjari" class="col-md-3 control-label">নামজারীর বিবরণ <span style="color:red">*</span></label>
              <div class="col-md-5">
                  {{ Form::text('namjari', null, ['class' => 'form-control', 'required']) }}
              </div>
          </div> --}}
          <div class="form-group col-md-12">
              <label for="comment" class="col-md-3 control-label">মন্তব্য </label>
              <div class="col-md-5">
                  {{ Form::text('comment', null, ['class' => 'form-control']) }}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="coordinates" class="col-md-3 control-label">Coordinates </label>
              <div class="col-md-5">
                  {{ Form::textarea('coordinates', null, ['class' => 'form-control MapLat', 'id'=>'coordinates', 'readonly']) }}
              </div>
          </div>

          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 1</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_1', null, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_1', null, ['class' => '']) }}
            </div>
          </div>
          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 2</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_2', null, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_2', null, ['class' => '']) }}
            </div>
          </div>
          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 3</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_3', null, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_3', null, ['class' => '']) }}
            </div>
          </div>
          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 4</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_4', null, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_4', null, ['class' => '']) }}
            </div>
          </div>
          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">Document Name 5</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('doc_name_5', null, ['class' => 'form-control', 'placeholder' => 'Document Name']) }}
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('doc_5', null, ['class' => '']) }}
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
@include('Land::land.source-create')
@include('Land::land.area-create')

<script type="text/javascript">
  $(document).ready(function () {

    $('#nopagination').DataTable({
      "paging": true,
      "bFilter": true,
      "info": true
    });

    highlight_nav('land');
  });
</script>


<!-- <script>
  $( function() {
    var availableTags = [
      "ActionScript vbc",
      "AppleScript 12",
      "Asp 34",
      "BASIC 56",
      "C",
      "C++"
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
    
  } );
  </script> -->

@endsection

@section('scripts')
<script>
  function initMap() {
    var map = new google.maps.Map(document.getElementById('map_canvas'), {
      center: {lat: 23.7532387, lng: 90.392429},
      zoom: 8,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    });

    var drawingManager = new google.maps.drawing.DrawingManager({
          polygonOptions: {
            fillOpacity: 0.2,
            strokeWeight: 3,
            editable: true,
            draggable: true,
            zIndex: 1
          },
          map: map,
          drawingControl: false,
        });

    drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);

    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
      // When draw mode is set to null you can edit the polygon you just drawed

      getCoordinates(event);
      drawingManager.setDrawingMode(null);
      google.maps.event.addListener(event.overlay.getPath(), 'remove_at', function(){
        getCoordinates(event);
      });
      google.maps.event.addListener(event.overlay.getPath(), 'set_at', function(){
        getCoordinates(event);
      });
      google.maps.event.addListener(event.overlay.getPath(), 'insert_at', function(){
        getCoordinates(event);
      });                
    });
  }

  function getCoordinates(drawingManager){
    var vertices = drawingManager.overlay.getPath();
    var coordinates = "";
    for (var i =0; i < vertices.getLength(); i++) {
      var xy = vertices.getAt(i);
      if(i > 0)
        coordinates += ",";
      coordinates += xy.lat()+","+xy.lng();
    }
    document.getElementById('coordinates').innerHTML = coordinates;
  }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCHru2B6homPejeeKGb-6O_GKI9RwgUsE&libraries=drawing&callback=initMap&language=en&sensor=true"
         async defer>
</script>
<script>
    $(document).ready(function() {
        $('select[name="zone_id"]').on('change', function() {
            var zoneID = $(this).val();
            var url = '{{ url("land/getareas/")}}/' + zoneID;
            if(zoneID) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="area_id"]').empty();
                        $('select[name="area_id"]').append('<option value="">Select Area</option>');
                        $.each(data, function(key, value) {
                            $('select[name="area_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });

        $('select[name="zila_id"]').on('change', function() {
            var zilaID = $(this).val();
            console.log(zilaID);
            var url = '{{ url("land/getthanas/")}}/' + zilaID;
            if(zilaID > 0) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="thana_id"]').empty();
                        $('select[name="thana_id"]').append('<option value="">Select Thana</option>');
                        $.each(data, function(key, value) {
                            $('select[name="thana_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
              $('select[name="thana_id"]').empty();
              $('select[name="thana_id"]').append('<option value="">Select Thana</option>');
            }
        });
    });
</script>
@endsection
