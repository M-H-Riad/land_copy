@extends('main_layouts.app')

@section('content')

<style>
    .multifield_content{
        display:flex !important;
        gap:5px;
    }
    #search_view{
        display: block;
        border: 1px solid #ccc;
        margin-top: 5px;
        padding: 5px;
        border-radius: 10px;
        width:100%;
    }
    .search_button{
        cursor: pointer;
    }
</style>
<div class="row animated zoomIn">
  @include('errorOrSuccess')
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-red-sunglo">
              <i class="icon-settings font-red-sunglo"></i>
              <span class="caption-subject bold uppercase">গভীর নলকূপের তথ্য</span>
          </div>
      </div>  

      <div class="portlet-body">
        {{Form::open(['url'=>'deep-tubewell/deep-tubewell/'.$deep_tubewell->id,'method'=>'put','class'=>"form-horizontal",'role'=>'form', 'enctype' => 'multipart/form-data'])}}
          
          <div class="form-group col-md-12">
              <label for="zone_id" class="col-md-3 control-label">জোন<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('zone_id', $zones, $deep_tubewell->zone_id, ['class' => 'form-control select2','placeholder' => 'Select Zone', 'style' => 'width:100%']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">মৌজা<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('area_id', $areas, $deep_tubewell->area_id, ['class' => 'form-control select2','placeholder' => 'Select Land Area', 'style' => 'width:100%']) !!}
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="source_id" class="col-md-3 control-label">উৎসের ধরণ<span style="color:red">*</span></label>
              <div class="col-md-5">
                {!! Form::select('source_type', $source_type, $deep_tubewell->source_type, ['class' => 'form-control select2','placeholder' => 'Select Source type', 'style' => 'width:100%']) !!}
              </div>
          </div>


          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">উৎস<span style="color:red">*</span></label>
              <div class="col-md-5">
                  <input type="text" class="form-control" name="source_text" value="{{$source[0]->title}}" id="source_auto">
                  <input type="hidden" class="form-control" name="source" value="" id="source_id">
                  <input type="hidden" class="form-control" name="source_pre" value="{{$source[0]->id}}" id="source_pre">
                  <input type="hidden" class="form-control" name="source_text_pre" value="{{$source[0]->title}}">
                  <div id="search_view" style="position:absolute;z-index: 1;background: white;">
                     <!-- <a class="search_button" type="button" data-id="3873" data-index="20">Bird</a><br>
                     <a class="search_button" type="button" data-id="3873" data-index="20">Bird</a><br>
                     <a class="search_button" type="button" data-id="3873" data-index="20">Bird</a><br> -->

                  </div>
              </div>
          </div>

          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">অনুমতি/চুক্তি/বরাদ্দ<span style="color:red">*</span></label>
              <div class="col-md-5">
              <input type="radio" name="onumoti_chukti_boraddo" value="1" id="onumoti" <?php if($deep_tubewell->onumoti_chukti_boraddo==1){echo "checked";}?>>
                <label for="onumoti">অনুমতি</label>  
                <input type="radio" name="onumoti_chukti_boraddo" value="2" id="cukti" <?php if($deep_tubewell->onumoti_chukti_boraddo==2){echo "checked";}?>>
                <label for="cukti">চুক্তি</label>
                <input type="radio" name="onumoti_chukti_boraddo" value="3" id="boraddo" <?php if($deep_tubewell->onumoti_chukti_boraddo==3){echo "checked";}?>>
                <label for="boraddo">বরাদ্দ</label>  
              </div>
          </div>

          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">অনুমতি/চুক্তি/বরাদ্দ তারিখ<span style="color:red">*</span></label>
              <div class="col-md-5">
                  <input type="date" class="form-control" name="onumoti_chukti_boraddo_date" value="{{$deep_tubewell->onumoti_chukti_boraddo_date}}">
              </div>
          </div>

          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">অনুমতি/চুক্তি/বরাদ্দ সংযুক্তি</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('onumoti_chukti_boraddo_attach_name', $deep_tubewell->onumoti_chukti_boraddo_attach_name, ['class' => 'form-control' , 'id' => 'title']) }}
                <!-- doc_1 -->
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('onumoti_chukti_boraddo_attach', null, ['class' => '']) }}
                <span class="col-md-3"><img class="card-img-top" src="{{ asset($deep_tubewell->onumoti_chukti_boraddo_attach) }}" alt="doc_5" style="height: 50px; width: 100px;" /></span>
            </div>
          </div>

          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">দখলপত্র তারিখ<span style="color:red">*</span></label>
              <div class="col-md-5">
                  <input type="date" class="form-control" name="dokholpotro_date" value="{{$deep_tubewell->dokholpotro_date}}">
              </div>
          </div>

          <div class="form-group col-md-12" style="margin-left: 70px;">
            <label for="coordinates" class="col-md-2 control-label" style="margin-top: 5px;">দখলপত্র সংযুক্তি</label>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::text('dokholpotro_attach_name', $deep_tubewell->dokholpotro_attach_name, ['class' => 'form-control', 'placeholder' => 'Document Name']) }} 
                <!-- doc_name_2 -->
            </div>
            <div class="col-md-3" style="margin-top: 5px;">
                {{ Form::file('dokholpotro_attach', null, ['class' => '']) }}
                <span class="col-md-3"><img class="card-img-top" src="{{ asset($deep_tubewell->dokholpotro_attach) }}" alt="doc_5" style="height: 50px; width: 100px;" /></span>
            </div>
          </div>

          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">স্থাপনা/গভীর নলকূপের জায়গার নাম<span style="color:red">*</span></label>
              <div class="col-md-5">
                  <input type="text" class="form-control" name="deep_tubewell_place_name" value="{{$deep_tubewell->deep_tubewell_place_name}}">
              </div>
          </div>

          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">খতিয়ান নং<span style="color:red">*</span></label>
              <div class="col-md-5">
                  <input type="text" class="form-control" name="khotiyan_no" value="{{$deep_tubewell->khotiyan_no}}">
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">দাগ নং<span style="color:red">*</span></label>
              <div class="col-md-5">
                  <input type="text" class="form-control" name="dag_no" value="{{$deep_tubewell->dag_no}}">
              </div>
          </div>

          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">জমির পরিমান (একর)<span style="color:red">*</span></label>
              <div class="col-md-5">
                  <input type="text" class="form-control" name="jomir_poriman" value="{{$deep_tubewell->jomir_poriman}}">
              </div>
          </div>
          <div class="form-group col-md-12">
              <label for="area_id" class="col-md-3 control-label">গন্তব্য<span style="color:red">*</span></label>
              <div class="col-md-5">
                  <input type="text" class="form-control" name="destination" value="{{$deep_tubewell->destination}}">
              </div>
          </div>  

          <div class="form-group col-md-12">
             <label for="area_id" class="col-md-3 control-label">অন্যান্য<span style="color:red">*</span></label>
            <div class="col-md-5">
                    <div>
                         <div class="col-md-6" style="margin-top: 5px;text-decoration:underline;">সংযুক্তির নাম</div>
                         <div class="col-md-6" style="margin-top: 5px;text-decoration:underline;">সংযুক্তি</div>
                    </div>
                <div id="wrapperfee">
                <?php 
                    $other_attaches = json_decode($deep_tubewell->other_attach);
                    //echo "<pre>"; print_r($other_attaches);
                    foreach($other_attaches as $other_attach){
                ?>
                    <div class="col-md-12">
                        <div class="col-md-5" style="margin-top: 5px;">
                            {{ Form::text('document_name[]', $other_attach->document_name, ['class' => 'form-control', 'placeholder' => 'Document Name']) }} 
                            <!-- doc_name_2 -->
                        </div>
                        <div class="col-md-3" style="margin-top: 5px;">
                          
                            <input type="file" name="document[]">
                            <input type="hidden" name="document[]" value="{{$other_attach->file_name}}">
                            <span class="col-md-3"><img class="card-img-top" src="{{ asset($other_attach->file_name) }}" alt="doc_5" style="height: 50px; width: 100px;" /></span>
                        </div>
                        <div class="col-md-3" style="margin-top: 5px;">
                            <button style="margin-left: 80px;display: block !important;" type="button" class="btn btn-sm btn-outline-danger editbtnRemove">
                            <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php } ?>
               
                   
                
                    <a type="button" class="addmorefee"> + Add more </a>
                    
                    <div class="morefeecol multifield_content">
                        <div class="col-md-5" style="margin-top: 5px;">
                            {{ Form::text('document_name[]', null, ['class' => 'form-control', 'placeholder' => 'Document Name']) }} 
                            <!-- doc_name_2 -->
                        </div>
                        <div class="col-md-3" style="margin-top: 5px;">
                            {{ Form::file('document[]', null, ['class' => '']) }}
                        </div>
                        <div class="col-md-3" style="margin-top: 5px;">
                            <button style="margin-left: 80px;" type="button" class="btn btn-sm btn-outline-danger btnRemove">
                            <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        
                    </div>
                    

                    
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

<script type="text/javascript">
  $(document).ready(function () {

    $('#nopagination').DataTable({
      "paging": true,
      "bFilter": true,
      "info": true
    });

    highlight_nav('deep_tubewell');
  });
</script>


@endsection

@section('scripts')
<script src="{{ asset('js/jquery.multifield.min.js') }}"></script>
<script>
    $('#search_view').hide();
    $(document).ready(function() {
        $('#wrapperfee').multifield({
            section: '.morefeecol',
            btnAdd:'.addmorefee',
            btnRemove:'.btnRemove',
        });

        

        $('#source_auto').keyup(function(){
            var source = $(this).val();
            $.ajax({
                url: "{{ route('get-source') }}",
                method: "post",
                data:{ 
                    source: source,
                },
                cache: false,
                dataType: 'json',
                success: function(res){
                   if(res){
                    console.log(res);
                    
                    var data = res.sources; 
                    console.log(res.sources);
                    var html = '';
                    for(var i=0;i<data.length;i++){
                        // if(i==0){
                        //     var add_br = '';
                        // }else{
                        //     var add_br = '<br>';
                        // }
                        
                        html += '<br><a class="search_button" type="button" data-id="'+ data[i].id +'"  data-index="' + data[i].title + '">' + data[i].title + '</a>';
                    }
                    $('#search_view').html(html);
                    if(html!=''){
                        $('#search_view').show();
                    }else{
                        $('#search_view').hide();
                        $('#source_id').val('');
                    }
                    
                   }
                    
                    
                }
            });
        });

        $(document).on('click','.search_button',function(){
             var title= $(this).attr('data-index');
             var id= $(this).attr('data-id');
             $('#source_auto').val(title);
             $('#source_id').val(id);
             $('#search_view').hide();
        });
    });
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

        $('.editbtnRemove').click(function(event){
            event.preventDefault();
            $(this).parent('div').parent('div').remove();
        });

    });
</script>
@endsection
