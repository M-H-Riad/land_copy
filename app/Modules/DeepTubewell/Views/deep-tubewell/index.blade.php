@extends('main_layouts.app')

@section('content')
    <div class="row animated zoomIn">
        @include('errorOrSuccess')

        <div class="col-md-12">
            @include('DeepTubewell::deep-tubewell.filter')
        </div> 
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">গভীর নলকূপের তথ্য</span>

                    </div>

                    <div class="actions font-white">
                        <a class="btn btn-success bnt-lg pull-right" href="{{ url('deep-tubewell/deep-tubewell/create')}}">
                            <i class="fa fa-plus"></i> Add
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover nopagination dt-responsive" >
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">জোন</th>
                            <th style="padding: 8px !important;">মৌজা</th>
                            <th style="padding: 8px !important;">উৎসের ধরণ</th>
                            <th style="padding: 8px !important;">উৎস</th>
                            <th style="padding: 8px !important;">অনুমতি/চুক্তি/বরাদ্দ</th>
                            <th style="padding: 8px !important;">অনুমতি/চুক্তি/বরাদ্দ তারিখ</th>
                            <th style="padding: 8px !important;">দখলপত্র তারিখ</th>
                            <th style="padding: 8px !important;">স্থাপনা/গভীর নলকূপের জায়গার নাম</th>
                            <th style="padding: 8px !important;">খতিয়ান নং</th>
                            <th style="padding: 8px !important;">দাগ নং</th>
                            <th style="padding: 8px !important;">জমির পরিমান</th>
                            <th style="padding: 8px !important;">গন্তব্য</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($deepTubewells) > 0)
                                <?php $i = $deepTubewells->toArray()['from'];  ?>
                                @foreach($deepTubewells as $deepTubewell)
                                <tr>
                                    <td>{{ en2bn($i++) }}</td>
                                    <td>{{$deepTubewell->zone->title}}</td>
                                    <td>{{$deepTubewell->area->title}}</td>
                                    <td>{{$deepTubewell->sourceType->title}}</td>
                                    <td>{{$deepTubewell->source}}</td>
                                    <td>
                                        @if($deepTubewell->onumoti_chukti_boraddo==1)
                                            {{ অনুমতি }}
                                        @elseif($deepTubewell->onumoti_chukti_boraddo==2)
                                            {{ চুক্তি }}
                                        @elseif($deepTubewell->onumoti_chukti_boraddo==3)
                                            {{ বরাদ্দ }}
                                        @endif
                                    </td>
                                    <td>{{$deepTubewell->onumoti_chukti_boraddo_date}}</td>
                                    <td>{{$deepTubewell->dokholpotro_date}}</td>
                                    <td>{{$deepTubewell->deep_tubewell_place_name}}</td>
                                    <td>{{$deepTubewell->khotiyan_no}}</td>
                                    <td>{{$deepTubewell->dag_no}}</td>
                                    <td>{{$deepTubewell->jomir_poriman}}</td>
                                    <td>{{$deepTubewell->destination}}</td>
                                    <td class="action_buttons_style">
                                        
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ url('deep-tubewell/deep-tubewell/'.$deepTubewell->id.'/edit') }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ url('deep-tubewell/deep-tubewell/'.$deepTubewell->id) }}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a target="_blank" class="btn btn-warning btn-sm" href="{{ url('deep-tubewell/deep-tubewell/'.$deepTubewell->id.'/single-pdf') }}">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </a>
                                            <form action="{{ route('deep-tubewell.destroy', $deepTubewell->id) }}" method="POST">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure to delete?')">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </button>
                                            </form>
                                        
                                    </td>
                                    
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    

                    <div id="map_canvas" class="col-md-12" style="height: 450px; margin: 0.6em;"></div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>



@endsection
 
@section('scripts')
    <script>
       
        
    </script>
@endsection
