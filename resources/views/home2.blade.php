@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green">
                    <!-- <i class="icon-settings font-green"></i> -->
                    <span class="caption-subject bold uppercase">Home</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row widget-row animated fadeInDown">
                    @include('errorOrSuccess')
                    <div class="col-md-12">

                        <!-- BEGIN WIDGET THUMB -->
                        {{-- <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading"><a href="#" title="Click Here"> Notification</a></h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-blue icon-calendar"></i>
                                <div class="widget-thumb-body">
                                    <span class="widget-thumb-subtitle">Total</span>
                                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="0">0</span>
                                </div>
                            </div>
                        </div> --}}
                        @if(Auth::user()->can('search_with_employee_id'))
                        <div class="portlet box purple">
                          <div class="portlet-title">
                            <div class="caption">
                              <!-- <i class="icon-settings font-green"></i> -->
                              <span class="caption-subject bold uppercase">Quick Search</span>
                          </div>
                      </div>
                      <div class="portlet-body">

                        {!! Form::open(['url' => 'employee-profile/search', 'method' => 'get', 'class'=>'bs-example bs-example-form']) !!}

                        <div class="input-group">
                          <input type="text" name="q" value="{{old('q')}}" class="form-control" placeholder="{{(Auth::user()->can('manage_pension') ? 'PPO NO' : 'Employee ID')}}">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">Go!</button>
                        </span>
                    </div><!-- /input-group -->
                    {!! Form::close()  !!}

                </div>
            </div>
            @endif
            <!-- END WIDGET THUMB -->
        </div>

    </div>
</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>

</div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            highlight_nav('dashboard');
        });
    </script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{URL::asset('assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>

<script src="{{URL::asset('assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/global/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
@endsection
