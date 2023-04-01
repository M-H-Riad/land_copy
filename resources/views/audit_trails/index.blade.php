@extends('main_layouts.app')

@section('content')

<div class="row animated flipInX">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green">
                    <!-- <i class="icon-settings font-green"></i> -->
                    <span class="caption-subject bold uppercase">Filter</span>
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('method' => 'get')) !!}
                <div class="col-md-12 side-padding-none">
                    <div class="col-md-2" style="margin-bottom:5px;">
                        {{ Form::text('ip_s',request('ip_s'), ['class' => 'form-control', 'id' => 'ip_s','placeholder'=>'IP']) }}
                    </div>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        {{ Form::text('access_by_s',request('access_by_s'), ['class' => 'form-control', 'id' => 'access_by_s','placeholder'=>'User']) }}
                    </div>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        {{ Form::text('description',request('description'), ['class' => 'form-control', 'id' => 'access_by_s','placeholder'=>'Search in Details']) }}
                    </div>
                    <div class="col-md-1" style="margin-bottom:5px;">
                        {!! Form::select('action_title_s',$action_title_array,request('action_title_s'), ['class' => 'form-control', 'id' => 'action_title_s','placeholder' => 'Select Title']) !!}
                    </div>
                    <div class="col-md-1" style="margin-bottom:5px;">
                        {!! Form::select('type_s',$type_array,request('type_s'), ['class' => 'form-control', 'id' => 'type_s','placeholder' => 'Select Type']) !!}
                    </div>
                    <div class="col-md-1" style="margin-bottom:5px;">
                        {{ Form::text('date_from',request('date_from'), ['class' => 'form-control mask_date', 'id' => 'date_from','placeholder'=>'Date From']) }}
                    </div>
                    <div class="col-md-1" style="margin-bottom:5px;">
                        {{ Form::text('date_to',request('date_to'), ['class' => 'form-control mask_date', 'id' => 'date_to','placeholder'=>'Date To']) }}
                    </div>

                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-search"></i> Filter</button>
                    </div>

                    <div class="col-md-1">
                        <a href="{{url('audit-trail')}}" class="btn btn-danger filter-btn" style="padding: 5px;width: 100%;"><i class="fa fa-times"></i> Reset</a>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>

    <div class="row animated zoomIn">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Total - ({{$audit_trails->total()}})</span>
                    </div>

                </div>
                <div class="portlet-body">
                    <div style="overflow: auto">
                        <table class="table table-striped table-bordered table-hover" id="nopagination">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th style="padding: 8px !important;">IP</th>
                                    <th style="padding: 8px !important;">Title</th>
                                    <th style="padding: 8px !important;">Access By</th>
                                    <th style="padding: 8px !important;">Type</th>
                                    <th style="padding: 8px !important;">Date & Time</th>
                                    <th style="padding: 8px !important;">Details</th>
                                    <th style="padding: 8px !important;">Acting</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($audit_trails)>0)
                                <?php $i = $audit_trails->toArray()['from'];?>
                                @foreach($audit_trails as $audit_trail)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$audit_trail->ip}}</td>
                                    <td>{{$audit_trail->action_title}}</td>
                                    <td>{{$audit_trail->access_by}}</td>
                                    <td>{{$audit_trail->type}}</td>
                                    <td style="white-space: nowrap;">{{date("F jS, Y - h:i:s a", strtotime($audit_trail->created_at))}}</td>
                                    <td style="word-break:break-all">{{$audit_trail->description}}</td>
                                    <td style="word-break:break-all"><a class="btn btn-info" href="{{ route('audit-trail.show',$audit_trail->id) }}" target="_blank">Details</a></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if(count($audit_trails)>0)
                    {{$audit_trails->appends($_REQUEST)->render()}}
                    @endif
                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>



    <script type="text/javascript">
        $(document).ready(function () {

            $('#nopagination').DataTable({
                "paging": false,
                "bFilter": true,
                "info": false,
                'sort': false
            });
            highlight_nav('audit-trail');
        });
    </script>

    @endsection